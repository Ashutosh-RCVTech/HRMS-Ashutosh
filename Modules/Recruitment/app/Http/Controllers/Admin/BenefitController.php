<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\BenefitService;

class BenefitController extends Controller
{
    public function __construct(protected BenefitService $service) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $benefits = $this->service->getAllBenefitsPaginated(10, $search);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'benefits' => $benefits,
            ]);
        }

        return view('recruitment::admin.benefits.index', compact('benefits'));
    }

    public function create()
    {
        return view('recruitment::admin.benefits.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:benefits,name|max:255',
            ]);

            $this->service->createBenefit($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'true',
                    'message' => 'Benefit created successfully',
                    'redirect' => route('admin.benefits.index')
                ]);
            }
            return redirect()->route('admin.benefits.index')
                ->with('success', 'Benefit created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating benefit: ' . $e->getMessage());
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
        $benefit = $this->service->getAllBenefits()->find($id);
        return view('recruitment::admin.benefits.edit', compact('benefit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:benefits,name,' . $id . '|max:255',
        ]);

        $this->service->updateBenefit($request->all(), $id);

        return redirect()->route('admin.benefits.index')->with('success', 'Benefit updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->deleteBenefit($id);

        return redirect()->route('admin.benefits.index')->with('success', 'Benefit deleted successfully.');
    }
}
