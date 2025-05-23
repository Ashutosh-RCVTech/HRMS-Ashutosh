<?php

namespace Modules\Recruitment\Http\Controllers\College;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\Recruitment\Services\Interfaces\CollegeServiceInterface;
use Modules\Recruitment\Services\Interfaces\PlacementDriveServiceInterface;

class ProfileController extends Controller
{
    protected $collegeService;
    protected $placementDriveService;

    public function __construct(
        CollegeServiceInterface $collegeService,
        PlacementDriveServiceInterface $placementDriveService
    ) {
        $this->collegeService = $collegeService;
        $this->placementDriveService = $placementDriveService;
    }

    /**
     * Display the college profile.
     */
    public function show(): View
    {

        $college = Auth::guard('college')->user();

        // Get placement drive statistics
        $activeDrives = $this->placementDriveService->getActiveDrives();
        $upcomingDrives = $this->placementDriveService->getUpcomingDrives();
        $completedDrives = $this->placementDriveService->getCompletedDrives();

        // dd($activeDrives, $upcomingDrives, $completedDrives);

        return view('Recruitment::college.profile.show', compact(
            'college',
            'activeDrives',
            'upcomingDrives',
            'completedDrives'
        ));
    }

    /**
     * Show the form for editing the college profile.
     */
    public function edit(): View
    {
        $college = Auth::guard('college')->user();
        return view('Recruitment::college.profile.edit', compact('college'));
    }

    /**
     * Update the college profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $college = Auth::guard('college')->user();

        // Debug information
        Log::info('Profile Update Request', [
            'method' => $request->method(),
            'route' => $request->route()->getName(),
            'user_id' => $college->id,
            'input' => $request->all(),
            'files' => $request->allFiles()
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:colleges,email,' . $college->id,
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email|max:255',
            'contact_person_phone' => 'required|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Handle logo upload separately if a new logo is provided
            if ($request->hasFile('logo')) {
                $this->collegeService->updateLogo($college->id, $request->file('logo'));
                // Remove logo from validated data since it's handled separately
                unset($validated['logo']);
            }

            // Update other profile data
            $this->collegeService->update($college->id, $validated);

            Log::info('Profile Updated Successfully', [
                'college_id' => $college->id,
                'updated_fields' => array_keys($validated)
            ]);

            return redirect()->route('college.profile.show')
                ->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile Update Failed', [
                'college_id' => $college->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the college logo.
     */
    public function updateLogo(Request $request): RedirectResponse
    {
        $college = Auth::guard('college')->user();

        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $this->collegeService->updateLogo($college->id, $request->file('logo'));

        return redirect()->route('college.profile.show')
            ->with('success', 'Logo updated successfully.');
    }
}
