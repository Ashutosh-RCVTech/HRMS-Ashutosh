<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\DegreeService;

class DegreeController extends Controller
{
    public function __construct(protected DegreeService $service) {}
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $degrees = $this->service->getAllDegreesPaginated(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('recruitment::admin.degrees.partials.degrees-table', compact('degrees'))->render(),
                'pagination' => [
                    'current_page' => $degrees->currentPage(),
                    'last_page' => $degrees->lastPage(),
                    'from' => $degrees->firstItem(),
                    'to' => $degrees->lastItem(),
                    'total' => $degrees->total()
                ]
            ]);
        }

        return view('recruitment::admin.degrees.index', compact('degrees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruitment::admin.degrees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:degrees,name|max:255',
            ]);

            $this->service->createDegree($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'true',
                    'message' => 'Degree created successfully',
                    'redirect' => route('admin.degrees.index')
                ]);
            }
            return redirect()->route('admin.degrees.index')
                ->with('success', 'Degree created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating degree: ' . $e->getMessage());
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $degree = $this->service->getAllDegrees()->find($id);

        if (!$degree) {
            abort(404, 'Degree not found.');
        }
        return view('recruitment::admin.degrees.edit', compact('degree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:degrees,name,' . $id . '|max:255',
            ]);

            $this->service->updateDegree($request->all(), $id);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Degree updated successfully',
                    'redirect' => route('admin.degrees.index')
                ]);
            }

            return redirect()->route('admin.degrees.index')
                ->with('success', 'Degree updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating degree: ' . $e->getMessage());

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
        // dd('ddd');
        $this->service->deleteDegree($id);
        return redirect()->route('admin.degrees.index')->with('success', 'Degree deleted successfully.');
    }
}
