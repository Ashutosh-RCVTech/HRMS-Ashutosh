<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\SkillService;

class SkillController extends Controller
{
    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $skills = $this->skillService->getAllSkillsPaginated(10, $search);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('recruitment::admin.skills.partials.skills-table', compact('skills'))->render(),
                'pagination' => [
                    'current_page' => $skills->currentPage(),
                    'last_page' => $skills->lastPage(),
                    'from' => $skills->firstItem(),
                    'to' => $skills->lastItem(),
                    'total' => $skills->total()
                ]
            ]);
        }

        return view('recruitment::admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('recruitment::admin.skills.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:skills,name',
                'description' => 'nullable|string',
                'category_id' => 'nullable|exists:skill_categories,id',
                'slug' => 'nullable|string|unique:skills,slug'
            ]);

            $this->skillService->createSkill($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'true',
                    'message' => 'Skill created successfully.',
                    'redirect' => route('admin.skills.index')
                ]);
            }
            return redirect()->route('admin.skills.index')
                ->with('success', 'Skill created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Skill: ' . $e->getMessage());
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
        $skill = $this->skillService->findSkill($id);
        return view('recruitment::admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:skills,name,' . $id,
                'description' => 'nullable|string',
                'category_id' => 'nullable|exists:skill_categories,id',
                'slug' => 'nullable|string|unique:skills,slug,' . $id
            ]);

            $this->skillService->updateSkill($validated, $id);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Skill updated successfully',
                    'redirect' => route('admin.skills.index')
                ]);
            }

            return redirect()->route('admin.skills.index')
                ->with('success', 'Skill updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating skill: ' . $e->getMessage());

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
        $this->skillService->deleteSkill($id);

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully.');
    }

    public function show($id)
    {
        $skill = $this->skillService->findSkill($id);
        return response()->json($skill);
    }

    // Job Opening Related Methods
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
            'job_opening_id' => 'required|integer'
        ]);

        $skills = $this->skillService->searchSkills(
            $request->input('query'),
            $request->input('job_opening_id')
        );
        return response()->json($skills);
    }

    public function list(Request $request)
    {
        $filters = $request->input('filters', []);
        $searchQuery = $request->input('search', '');
        $sortColumn = $request->input('sort_column', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 15);

        $skills = $this->skillService->searchSkillsWithFilters(
            $filters,
            $searchQuery,
            ['name', 'description'],
            $sortColumn,
            $sortDirection,
            ['name', 'created_at', 'category_id'],
            $perPage
        );

        return response()->json($skills);
    }

    public function addMultiple(Request $request)
    {
        $request->validate([
            'job_opening_id' => 'required|exists:job_openings,id',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skills,id'
        ]);

        $newskills = $this->skillService->addSkills(
            $request->input('job_opening_id'),
            $request->input('skill_ids')
        );

        return response()->json([
            'message' => 'Skills added successfully',
            'added_skills' => $newskills
        ]);
    }

    public function remove(Request $request, $skillId)
    {
        $request->validate([
            'job_opening_id' => 'required|exists:job_openings,id'
        ]);

        $this->skillService->removeSkill(
            $request->input('job_opening_id'),
            $skillId
        );

        return response()->json(['message' => 'Skill removed successfully']);
    }

    public function getJobOpeningSkills(Request $request, $jobOpeningId)
    {
        $skills = $this->skillService->getJobOpeningSkills($jobOpeningId);
        return response()->json($skills);
    }
}
