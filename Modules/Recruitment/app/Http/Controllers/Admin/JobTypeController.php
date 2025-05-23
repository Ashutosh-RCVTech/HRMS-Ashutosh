<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\JobTypeService;

class JobTypeController extends Controller
{
    public function __construct(protected JobTypeService $jobTypeService) {}

    public function index(Request $request)
    {
        $jobTypes = $this->jobTypeService->getAllJobTypesPaginated(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('recruitment::admin.jobTypes.partials.jobTypes-table', compact('jobTypes'))->render(),
                'pagination' => [
                    'current_page' => $jobTypes->currentPage(),
                    'last_page' => $jobTypes->lastPage(),
                    'from' => $jobTypes->firstItem(),
                    'to' => $jobTypes->lastItem(),
                    'total' => $jobTypes->total()
                ]
            ]);
        }

        return view('recruitment::admin.jobTypes.index', compact('jobTypes'));
    }

    public function create()
    {
        return view('recruitment::admin.jobTypes.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:job_types,name|max:255',
            ]);

            $this->jobTypeService->createJobType($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'true',
                    'message' => 'Job Type created successfully.',
                    'redirect' => route('admin.jobTypes.index')
                ]);
            }
            return redirect()->route('admin.jobTypes.index')
                ->with('success', 'Job Type created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Job Type: ' . $e->getMessage());
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
        $jobType = $this->jobTypeService->getAllJobTypes()->find($id);
        return view('recruitment::admin.jobTypes.edit', compact('jobType'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:job_types,name,' . $id . '|max:255',
            ]);

            $this->jobTypeService->updateJobType($request->all(), $id);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Job Type updated successfully.',
                    'redirect' => route('admin.jobTypes.index')
                ]);
            }

            return redirect()->route('admin.jobTypes.index')
                ->with('success', 'Job Type updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Job Type : ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $this->jobTypeService->deleteJobType($id);

        return redirect()->route('admin.jobTypes.index')->with('success', 'Job Type deleted successfully.');
    }
}
