<?php

namespace Modules\Recruitment\Http\Controllers\Admin\Placement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\CollegeCandidatePlacement;
use Modules\Recruitment\Models\Placement\Placements;
use Modules\Recruitment\Models\Placement\PlacementColleges;
use Modules\Recruitment\Models\Placement\PlacementDegrees;
use Modules\Recruitment\Models\Placement\PlacementSkills;
use Modules\Recruitment\Models\EducationLevel;
use Modules\Recruitment\Models\College;
use Modules\Recruitment\Models\Skill;
use Modules\Recruitment\Models\Degree;
use Illuminate\Support\Facades\DB;
use Modules\Recruitment\Models\Placement\QuizSchedule;
use Modules\Recruitment\Models\Quiz\QuizCourses;
use Modules\Recruitment\Models\Quiz\Quizes;

use Modules\Recruitment\Models\CollegeCandidate;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\ExamAttempt;

use Barryvdh\DomPDF\Facade\Pdf;

class PlacementDriveController extends Controller
{

    public function index(Request $request)
    {
        $placements = Placements::with([
            'educationLevel',
            'placementColleges.college',
            'placementDegrees.degree',
            'placementSkills.skill'
        ])->latest()->paginate(10);


        // dd($placement);
        return view('Recruitment::admin.placement.index', compact('placements'));
    }

    public function create(Request $request)
    {
        $educationLevels = EducationLevel::all();
        return view('recruitment::admin.placement.create', compact('educationLevels'));
    }

    public function searchCollege(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = College::query()
            // ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });

        $colleges = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $colleges->items(),
            'next_page_url' => $colleges->nextPageUrl(),
            'total' => $colleges->total()
        ]);
    }

    public function searchSkills(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Skill::query()
            // ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });

        $skills = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $skills->items(),
            'next_page_url' => $skills->nextPageUrl(),
            'total' => $skills->total()
        ]);
    }

    public function searchDegree(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Degree::query()
            // ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });

        $degrees = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $degrees->items(),
            'next_page_url' => $degrees->nextPageUrl(),
            'total' => $degrees->total()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'openings' => 'required|integer|min:1',
            'education_level' => 'required|integer|exists:education_levels,id',

            'degree_id' => 'required|array|min:1|max:10',
            'degree_id.*' => 'integer|exists:degrees,id',

            'skill_id' => 'required|array|min:1|max:10',
            'skill_id.*' => 'integer|exists:skills,id',

            'college_id' => 'required|array|min:1|max:10',
            'college_id.*' => 'integer|exists:colleges,id',
        ]);

        // dd($request->all(), $validated);

        DB::beginTransaction();

        try {

            $placement = Placements::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'description' => $validated['description'],
                'no_of_openings' => $validated['openings'],
                'education_level_id' => $validated['education_level'],
                'status' => 0,
            ]);


            foreach ($validated['degree_id'] as $degreeId) {
                PlacementDegrees::create([
                    'placement_id' => $placement->id,
                    'degree_id' => $degreeId,
                ]);
            }


            foreach ($validated['skill_id'] as $skillId) {
                PlacementSkills::create([
                    'placement_id' => $placement->id,
                    'skill_id' => $skillId,
                ]);
            }


            foreach ($validated['college_id'] as $collegeId) {
                PlacementColleges::create([
                    'placement_id' => $placement->id,
                    'college_id' => $collegeId,
                    'college_acceptance' => 0,
                    'status' => 0,
                ]);
            }



            DB::commit();
            return redirect()->route('admin.placement.index')->with('success', 'Placement created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong.', 'details' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $placement = Placements::with([
            'educationLevel',
            'placementColleges.college',
            'placementDegrees.degree',
            'placementSkills.skill'
        ])->find($id);

        return view('Recruitment::admin.placement.show', compact('placement'));
    }

    public function updateStatus($placementId)
    {
        $placement = Placements::find($placementId);
        $placement->status = !$placement->status;
        $placement->save();
        return redirect()->route('admin.placement.index')->with('success', 'Placement status Updated successfully.');
    }
    public function edit($id)
    {
        $educationLevels = EducationLevel::all();
        $placement = Placements::with([
            'placementColleges.college',
            'placementDegrees.degree',
            'placementSkills.skill'
        ])->find($id);

        return view('Recruitment::admin.placement.edit', compact('placement', 'educationLevels'));
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'placement_id' => 'required|integer|exists:placement,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'openings' => 'required|integer|min:1',
            'education_level' => 'required|integer|exists:education_levels,id',

            'degree_id' => 'required|array|min:1|max:10',
            'degree_id.*' => 'integer|exists:degrees,id',

            'skill_id' => 'required|array|min:1|max:10',
            'skill_id.*' => 'integer|exists:skills,id',

            'college_id' => 'required|array|min:1|max:10',
            'college_id.*' => 'integer|exists:colleges,id',
        ]);
        // dd($validated);

        DB::beginTransaction();

        try {
            $placement = Placements::findOrFail($validated['placement_id']);

            // Update placement main data
            $placement->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'no_of_openings' => $validated['openings'],
                'education_level_id' => $validated['education_level'],

            ]);

            // === Sync Skills ===
            $existingSkills = PlacementSkills::withTrashed()
                ->where('placement_id', $placement->id)
                ->get()
                ->keyBy('skill_id');

            foreach ($validated['skill_id'] as $skillId) {
                if (isset($existingSkills[$skillId])) {
                    if ($existingSkills[$skillId]->trashed()) {
                        $existingSkills[$skillId]->restore();
                    }
                    $existingSkills->forget($skillId);
                } else {
                    PlacementSkills::create([
                        'placement_id' => $placement->id,
                        'skill_id' => $skillId,
                    ]);
                }
            }

            foreach ($existingSkills as $remaining) {
                $remaining->delete();
            }

            // === Sync Degrees ===
            $existingDegrees = PlacementDegrees::withTrashed()
                ->where('placement_id', $placement->id)
                ->get()
                ->keyBy('degree_id');

            foreach ($validated['degree_id'] as $degreeId) {
                if (isset($existingDegrees[$degreeId])) {
                    if ($existingDegrees[$degreeId]->trashed()) {
                        $existingDegrees[$degreeId]->restore();
                    }
                    $existingDegrees->forget($degreeId);
                } else {
                    PlacementDegrees::create([
                        'placement_id' => $placement->id,
                        'degree_id' => $degreeId,
                    ]);
                }
            }

            foreach ($existingDegrees as $remaining) {
                $remaining->delete();
            }

            // === Sync Colleges ===
            $existingColleges = PlacementColleges::withTrashed()
                ->where('placement_id', $placement->id)
                ->get()
                ->keyBy('college_id');

            foreach ($validated['college_id'] as $collegeId) {
                if (isset($existingColleges[$collegeId])) {
                    if ($existingColleges[$collegeId]->trashed()) {
                        $existingColleges[$collegeId]->restore();
                    }
                    $existingColleges->forget($collegeId);
                } else {
                    PlacementColleges::create([
                        'placement_id' => $placement->id,
                        'college_id' => $collegeId,
                        'college_acceptance' => 0,
                        'status' => 0,
                    ]);
                }
            }

            foreach ($existingColleges as $remaining) {
                $remaining->delete();
            }

            DB::commit();

            return redirect()->route('admin.placement.index')->with('success', 'Placement updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong while updating the placement.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $placement = Placements::findOrFail($id);
        $placement->delete();

        return redirect()->route('admin.placement.index')->with('success', 'Placement deleted successfully.');
    }


    //not in use 
    public function addCollege(Request $request, $id)
    {

        return view('Recruitment::admin.placement.addCollege', compact('id'));
    }

    //not in use
    public function storeNewCollege(Request $request)
    {

        $validated = $request->validate([
            'placement_id' => 'required|integer|exists:placement,id',
            'college_id.*' => 'integer|exists:colleges,id',
            'schedule_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'timezone' => ['required', 'in:Asia/Kolkata,America/New_York,America/Chicago,America/Denver,America/Los_Angeles,Europe/London,Europe/Berlin'],

        ]);
    }


    public function getQuizzesByCourse($courseId)
    {
        $quizzes = Quizes::where('course_id', $courseId)->get(['id', 'name']);
        return response()->json($quizzes);
    }



    public function showScheduleStudent($placementId, $placementCollegId)
    {
        $placement = Placements::findOrFail($placementId);
        $quizCourses = QuizCourses::all();

        $quizSchedule = QuizSchedule::where('placement_id', $placementId)
            ->where('placement_college_id', $placementCollegId)
            ->first();

        $quizzes = $quizSchedule
            ? Quizes::where('course_id', $quizSchedule->course_id)->get()
            : collect();


        $placementCollege = PlacementColleges::findOrFail($placementCollegId);


        $candidatePlacementIds = CollegeCandidatePlacement::where('placement_id', $placementId)->pluck('college_candidate_id');
        $collegeCandidates = CollegeCandidate::with('candidateInfo.mcqTests.examAttempts')
            ->whereIn('id', $candidatePlacementIds)
            ->where('college_id', $placementCollege->college_id)
            ->latest()->get();

        $passingPercentage = 0;
        if ($quizSchedule) {
            $quiz = Quizes::where('course_id', $quizSchedule->course_id)->where('id', $quizSchedule->quiz_id)->first();
            $passingPercentage = $quiz->passing_marks;
        }

        return view('Recruitment::admin.placement.scheduleStudent', compact(
            'placement',
            'placementId',
            'placementCollegId',
            'quizCourses',
            'quizSchedule',
            'quizzes',
            'collegeCandidates',
            'passingPercentage'
        ));
    }


    public function pdfExportAllByPlacement($placementId, $placementCollegeId)
    {
        $placement = Placements::findOrFail($placementId);
        $placementCollege = PlacementColleges::findOrFail($placementCollegeId);

        $quizSchedule = QuizSchedule::where('placement_id', $placementId)
            ->where('placement_college_id', $placementCollegeId)
            ->first();

        if (!$quizSchedule) {
            return response()->json(['message' => 'Quiz not scheduled for this placement and college'], 404);
        }

        $quiz = Quizes::where('course_id', $quizSchedule->course_id)
            ->where('id', $quizSchedule->quiz_id)
            ->first();

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found for this schedule'], 404);
        }

        $passingPercentage = $quiz->passing_marks;

        // Get candidate IDs based on placement and college
        $candidatePlacementIds = CollegeCandidatePlacement::where('placement_id', $placementId)
            ->pluck('college_candidate_id');

        // Load candidates and their attempt for this quiz
        $collegeCandidates = CollegeCandidate::with(['candidateInfo.mcqTests.examAttempts' => function ($q) use ($quiz) {
            $q->where('quiz_id', $quiz->id);
        }])
            ->whereIn('id', $candidatePlacementIds)
            ->where('college_id', $placementCollege->college_id)
            ->get();

        // Collect attempt details
        $candidatesWithAttempts = $collegeCandidates->map(function ($candidate) use ($passingPercentage) {
            $attempt = optional($candidate->candidateInfo)->mcqTests->first()?->examAttempts->first();

            return [
                'candidate' => $candidate,
                'score' => $attempt?->score,
                'status' => $attempt
                    ? ($attempt->score >= $passingPercentage ? 'Passed' : 'Failed')
                    : '-',
            ];
        });

        $pdf = Pdf::loadView('recruitment::admin.quiz.quizes.resultPdfAll', [
            'candidatesWithAttempts' => $candidatesWithAttempts,
            'quiz' => $quiz,
            'placement' => $placement,
            'placementCollege' => $placementCollege,
            'passingPercentage' => $passingPercentage,
        ]);

        return $pdf->download("quiz-results-All-{$placement->title}-{$placementCollege->college->name}.pdf");
    }




    //not in use 
    public function createQuizSchedule($placementId, $placementCollegId)
    {
        $quizCourses = QuizCourses::all();
        return view('Recruitment::admin.placement.quiScheduleCreate', compact('placementId', 'placementCollegId', 'quizCourses'));
    }


    public function storeQuizSchedule(Request $request)
    {
        $validated = $request->validate([
            'placement_id' => 'required|integer|exists:placement,id',
            'placement_college_id' => 'integer|exists:placement_college,id',
            'course_id' => 'required',
            'quiz_id' => 'required|exists:quizes,id',
            'schedule_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'timezone' => ['required', 'in:Asia/Kolkata,America/New_York,America/Chicago,America/Denver,America/Los_Angeles,Europe/London,Europe/Berlin'],
        ]);

        QuizSchedule::insert($validated);

        return redirect()->route('admin.placement.college.quiz.studuent', [
            $request->placement_id,
            $request->placement_college_id
        ])->with('success', 'Quiz schedule created successfully.');
    }


    //not in use 
    public function showScheduleQuiz($placementId)
    {
        $quizSchedules = QuizSchedule::with(['placement', 'college.college', 'quiz', 'course'])
            ->where('placement_id', $placementId)
            ->latest()
            ->get();

        return view('Recruitment::admin.placement.showSchedule', compact('quizSchedules', 'placementId'));
    }


    //not in use 
    public function editQuizSchedule($id)
    {

        $quizSchedule = QuizSchedule::where('id', $id)->first();
        $quizCourses = QuizCourses::all();
        $quizzes = Quizes::where('course_id', $quizSchedule->course_id)->get();
        return view('Recruitment::admin.placement.quiScheduleEdit', compact('quizSchedule', 'quizCourses', 'quizzes'));
    }

    public function updateQuizSchedule(Request $request, $id)
    {
        $validated = $request->validate([
            'placement_id' => 'required|integer|exists:placement,id',
            'placement_college_id' => 'integer|exists:placement_college,id',
            'course_id' => 'required',
            'quiz_id' => 'required|exists:quizes,id',
            'schedule_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'timezone' => ['required', 'in:Asia/Kolkata,America/New_York,America/Chicago,America/Denver,America/Los_Angeles,Europe/London,Europe/Berlin'],
        ]);

        $quizSchedule = QuizSchedule::findOrFail($id);
        $quizSchedule->update($validated);

        return redirect()->route('admin.placement.college.quiz.studuent', [
            $request->placement_id,
            $request->placement_college_id
        ])->with('success', 'Quiz schedule updated successfully.');
    }
}
