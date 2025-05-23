<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\LocationService;

class LocationController extends Controller
{
    protected $service;

    public function __construct(LocationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $locations = $this->service->getAllLocationsPaginated(10, $search);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'locations' => $locations,
            ]);
        }

        return view('recruitment::admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('recruitment::admin.locations.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:locations,name|max:255',
            ]);

            $this->service->createLocation($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Location created successfully',
                    'redirect' => route('admin.locations.index')
                ]);
            }
            return redirect()->route('admin.locations.index')
                ->with('success', 'Location created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating location: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $location = $this->service->getAllLocations()->find($id);
        return view('recruitment::admin.locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:locations,name,' . $id . '|max:255',
        ]);

        $this->service->updateLocation($request->all(), $id);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->deleteLocation($id);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
