<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Services\JobApplicationService;

class JobApplicationController extends Controller
{
    protected $service;

    public function __construct(JobApplicationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'experience',
            'location_type',
            'education_level',
            'location',
            'min_salary',
            'max_salary',
            'job_status',
            'sort_field',
            'sort_direction'
        ]);
        $perPage = $request->input('per_page', 10);

        $applications = $this->service->getFilteredApplications($filters, $perPage);
        $filterOptions = $this->service->getFilterOptions();

        return view('recruitment::admin.job-applications.index', compact('applications', 'filterOptions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'job_id' => 'required|exists:job_openings,id',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        try {
            $this->service->createApplication($validatedData);
            return redirect()->route('admin.job-applications.index')->with('success', 'Application submitted.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $application = $this->service->findById($id);
        return view('recruitment::admin.job-applications.show', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $this->service->updateApplicationStatus($id, $request->status);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function download($id)
    {
        return $this->service->downloadResume($id);
    }


    public function destroy($id)
    {
        try {
            $this->service->deleteApplication($id);
            return redirect()->route('admin.job-applications.index')->with('success', 'Application deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete application: ' . $e->getMessage());
        }
    }
}
