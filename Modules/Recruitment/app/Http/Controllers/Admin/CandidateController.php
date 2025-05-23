<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\McqTestCandidate;
use Modules\Recruitment\Services\CandidateService;
use Modules\Recruitment\Http\Requests\Admin\CandidateRequest;
use Illuminate\Database\Eloquent\Collection;

class CandidateController extends Controller
{
    protected $candidateService;

    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    // public function index(Request $request)
    // {
    //     $candidates = $this->candidateService->getAllCandidates($request->all());

    //     // dd($candidates);
    //     $candidatesData = collect($candidates);

    //     // dd($candidatesData);
    //     $candidatesWithMcq = collect($candidatesData["data"])->map(function ($candidate) {
    //         $mcqTest = McqTestCandidate::where("candidate_id", $candidate['id'])->get();
    //         $candidate['McqTest'] = $mcqTest; // Add new key
    //         return $candidate;
    //     });
    //     // dd($candidatesWithMcq);

    //     return view('recruitment::admin.candidates.index', compact('candidates', 'candidatesWithMcq'));
    // }

    public function index(Request $request)
    {
        // Get all candidates
        $candidates = $this->candidateService->getAllCandidates($request->all());
        // Load the mcqTests relationship for each candidate
        $candidates->load('mcqTests');

        return view('recruitment::admin.candidates.index', compact('candidates'));
    }

    public function create()
    {
        return view('recruitment::admin.candidates.create');
    }

    public function store(CandidateRequest $request)
    {
        try {
            $data = $request->validated();

            // Convert comma-separated strings to arrays
            if (isset($data['basic_detail']['key_skills'])) {
                $data['basic_detail']['key_skills'] = array_map(
                    'trim',
                    explode(',', $data['basic_detail']['key_skills'])
                );
            }

            // Handle file uploads directly in controller
            if ($request->hasFile('basic_detail.resume')) {
                $data['basic_detail']['resume_path'] = $request->file('basic_detail.resume')
                    ->store('resumes', 'public');
            }

            if ($request->hasFile('basic_detail.profile_image')) {
                $data['basic_detail']['profile_image_path'] = $request->file('basic_detail.profile_image')
                    ->store('profile-images', 'public');
            }

            $candidate = $this->candidateService->createCandidate($data);
            return redirect()->route('admin.candidates.show', $candidate->id)
                ->with('success', 'Candidate created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create candidate: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $candidate = $this->candidateService->getCandidate($id);
            return view('recruitment::admin.candidates.show', compact('candidate'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.candidates.index')
                ->with('error', 'Candidate not found.');
        }
    }

    public function edit($id)
    {
        try {
            $candidate = $this->candidateService->getCandidate($id);
            return view('recruitment::admin.candidates.edit', compact('candidate'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.candidates.index')
                ->with('error', 'Candidate not found.');
        }
    }

    public function update(CandidateRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $data['id'] = $id;
            // Convert comma-separated strings to arrays
            if (isset($data['basic_detail']['key_skills'])) {
                $data['basic_detail']['key_skills'] = array_map(
                    'trim',
                    explode(',', $data['basic_detail']['key_skills'])
                );
            }

            // Handle file uploads directly in controller
            if ($request->hasFile('basic_detail.resume')) {
                $data['basic_detail']['resume_path'] = $request->file('basic_detail.resume')
                    ->store('resumes', 'public');
            }

            if ($request->hasFile('basic_detail.profile_image')) {
                $data['basic_detail']['profile_image_path'] = $request->file('basic_detail.profile_image')
                    ->store('profile-images', 'public');
            }

            $candidate = $this->candidateService->updateCandidate($id, $data);
            return redirect()->route('admin.candidates.show', $candidate->id)
                ->with('success', 'Candidate updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update candidate: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->candidateService->deleteCandidate($id);
            return redirect()
                ->route('admin.candidates.index')
                ->with('success', 'Candidate deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete candidate. ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $candidates = $this->candidateService->searchCandidates($request->get('query', ''));
        return response()->json($candidates);
    }

    public function filter(Request $request)
    {
        $candidates = $this->candidateService->filterCandidates($request->all());
        return response()->json($candidates);
    }
}
