<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\EducationLevelService;

class EducationLevelController extends Controller
{
    protected $service;

    public function __construct(EducationLevelService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $educationLevels = $this->service->getAllEducationLevelsPaginated(10, $search);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'educationLevels' => $educationLevels,
            ]);
        }

        return view('recruitment::admin.educationLevels.index', compact('educationLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruitment::admin.educationLevels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:education_levels,name|max:255',
            ]);

            $this->service->createEducationLevel($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Education level created successfully',
                    'redirect' => route('admin.educationLevels.index')
                ]);
            }
            return redirect()->route('admin.educationLevels.index')
                ->with('success', 'Education level created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating education level: ' . $e->getMessage());
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
     * Show the specified resource.
     */
    // public function show($id)
    // {
    //     return view('recruitment::show');
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $educationLevel = $this->service->getAllEducationLevels()->find($id);
        return view('recruitment::admin.educationLevels.edit', compact('educationLevel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:education_levels,name,' . $id . '|max:255',
        ]);

        $this->service->updateEducationLevel($request->all(), $id);

        return redirect()->route('admin.educationLevels.index')
            ->with('success', 'Education level updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->deleteEducationLevel($id);

        return redirect()->route('admin.educationLevels.index')
            ->with('success', 'Education level deleted successfully.');
    }
}
