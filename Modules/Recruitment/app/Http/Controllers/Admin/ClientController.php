<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\ClientService;
use Modules\Recruitment\Services\Interfaces\IFileUploadService;

class ClientController extends Controller
{
    public function __construct(protected ClientService $service, protected IFileUploadService $fileUploadService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'active' => $request->input('active'),
            'featured' => $request->input('featured'),
            'subscription_tier' => $request->input('subscription_tier'),
            'search' => $request->input('search')
        ];

        // This now returns a Query Builder, allowing paginate()
        $clients = $this->service->getAllClients($filters)->paginate(10);

        return view('recruitment::admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruitment::admin.clients.create');
    }

    /**
     * Handle file uploads for client
     */
    protected function handleFileUploads(Request $request): array
    {
        $fileData = [];

        try {
            if ($request->hasFile('client_logo')) {
                $filePath = $this->fileUploadService->upload(
                    $request->file('client_logo'),
                    'client/logos'
                );

                if ($filePath) {
                    $fileData['client_logo_path'] = $filePath;
                } else {
                    throw new \Exception('Client logo upload failed.');
                }
            }

            if ($request->hasFile('banner_image')) {
                $filePath = $this->fileUploadService->upload(
                    $request->file('banner_image'),
                    'client/banners'
                );

                if ($filePath) {
                    $fileData['banner_image_path'] = $filePath;
                } else {
                    throw new \Exception('Banner image upload failed.');
                }
            }
        } catch (\Exception $e) {
            Log::error('File Upload Error: ' . $e->getMessage());
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file_upload' => 'There was an issue uploading the file. Please try again.'
            ]);
        }

        return $fileData;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:clients,name|max:255',
                'company_type' => 'nullable|string|max:100',
                'industry' => 'nullable|string|max:100',
                'website_url' => 'nullable|url|max:255',
                'description' => 'nullable|string',
                'primary_email' => 'nullable|email|max:255',
                'secondary_email' => 'nullable|email|max:255',
                'phone_number' => 'nullable|string|max:20',
                'alternative_phone' => 'nullable|string|max:20',
                'linkedin_url' => 'nullable|url|max:255',
                'facebook_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                'address_line_1' => 'nullable|string|max:255',
                'address_line_2' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'company_size' => 'nullable|string|max:50',
                'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
                'registration_number' => 'nullable|string|max:100',
                'tax_id' => 'nullable|string|max:100',
                'is_active' => 'nullable|boolean',
                'is_featured' => 'nullable|boolean',
                'subscription_tier' => 'nullable|integer|in:1,2,3',
                'subscription_expiry' => 'nullable|date',
                'hiring_capacity' => 'nullable|integer|min:1',
                'contact_person_name' => 'nullable|string|max:255',
                'contact_person_position' => 'nullable|string|max:255',
                'contact_person_email' => 'nullable|email|max:255',
                'contact_person_phone' => 'nullable|string|max:20',
                'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'recruitment_preferences' => 'nullable|array',
                'custom_fields' => 'nullable|array',
            ]);

            $fileData = $this->handleFileUploads($request);
            $data = $request->all();

            // Merge file data
            $data = array_merge($data, $fileData);

            $this->service->createClient($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Client created successfully.',
                    'redirect' => route('admin.clients.index')
                ]);
            }
            return redirect()->route('admin.clients.index')
                ->with('success', 'Client created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating Client: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = $this->service->getClientById($id);

        if (!$client) {
            return redirect()->route('admin.clients.index')
                ->with('error', 'Client not found.');
        }

        return view('recruitment::admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = $this->service->getClientById($id);
        return view('recruitment::admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:clients,name,' . $id . '|max:255',
                'company_type' => 'nullable|string|max:100',
                'industry' => 'nullable|string|max:100',
                'website_url' => 'nullable|url|max:255',
                'description' => 'nullable|string',
                'primary_email' => 'nullable|email|max:255',
                'secondary_email' => 'nullable|email|max:255',
                'phone_number' => 'nullable|string|max:20',
                'alternative_phone' => 'nullable|string|max:20',
                'linkedin_url' => 'nullable|url|max:255',
                'facebook_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                'address_line_1' => 'nullable|string|max:255',
                'address_line_2' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'company_size' => 'nullable|string|max:50',
                'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
                'registration_number' => 'nullable|string|max:100',
                'tax_id' => 'nullable|string|max:100',
                'is_active' => 'nullable|boolean',
                'is_featured' => 'nullable|boolean',
                'subscription_tier' => 'nullable|integer|in:1,2,3',
                'subscription_expiry' => 'nullable|date',
                'hiring_capacity' => 'nullable|integer|min:1',
                'contact_person_name' => 'nullable|string|max:255',
                'contact_person_position' => 'nullable|string|max:255',
                'contact_person_email' => 'nullable|email|max:255',
                'contact_person_phone' => 'nullable|string|max:20',
                'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'recruitment_preferences' => 'nullable|array',
                'custom_fields' => 'nullable|array',
            ]);

            // Get existing client data
            $client = $this->service->getClientById($id);

            // Handle File Upload
            $fileData = $this->handleFileUploads($request);

            $data = $request->all();
            $data = array_merge($data, $fileData);

            $this->service->updateClient($data, $id);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Client updated successfully.',
                    'redirect' => route('admin.clients.index')
                ]);
            }

            return redirect()->route('admin.clients.index')
                ->with('success', 'Client updated successfully.');
        } catch (\Exception $e) {
            Log::error("Error updating client: " . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->deleteClient($id);
        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }

    /**
     * Toggle client active status
     */
    public function toggleActiveStatus($id)
    {
        try {
            $this->service->toggleActiveStatus($id);
            return redirect()->route('admin.clients.index')->with('success', 'Client status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.clients.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Toggle client featured status
     */
    public function toggleFeaturedStatus($id)
    {
        try {
            $this->service->toggleFeaturedStatus($id);
            return redirect()->route('admin.clients.index')->with('success', 'Client featured status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.clients.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update client subscription
     */
    public function updateSubscription(Request $request, $id)
    {
        try {
            $request->validate([
                'subscription_tier' => 'required|integer|in:1,2,3',
                'subscription_expiry' => 'nullable|date'
            ]);

            $this->service->updateSubscription(
                $id,
                $request->input('subscription_tier'),
                $request->input('subscription_expiry')
            );

            return redirect()->route('admin.clients.index')->with('success', 'Client subscription updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.clients.index')->with('error', $e->getMessage());
        }
    }
}
