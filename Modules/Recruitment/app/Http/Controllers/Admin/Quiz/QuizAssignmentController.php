<?php

namespace Modules\Recruitment\Http\Controllers\Admin\Quiz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\Quiz\Quizes;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Services\Interfaces\IQuizAssignmentService;

class QuizAssignmentController extends Controller
{
    protected $quizAssignmentService;

    public function __construct(IQuizAssignmentService $quizAssignmentService)
    {
        $this->quizAssignmentService = $quizAssignmentService;
    }

    /**
     * Display a listing of quiz assignments for a specific quiz.
     *
     * @param int $quizId
     * @return \Illuminate\View\View
     */
    public function index($quizId)
    {
        $quiz = Quizes::findOrFail($quizId);
        $assignments = $this->quizAssignmentService->getAssignmentsForQuiz($quizId);
        
        return view('recruitment::admin.quiz.assignments.index', compact('quiz', 'assignments'));
    }

    /**
     * Show the form for assigning a quiz to candidates.
     *
     * @param int $quizId
     * @return \Illuminate\View\View
     */
    public function create($quizId)
    {
        $quiz = Quizes::findOrFail($quizId);
        $candidates = CandidateUser::orderBy('name')->get();
        
        return view('recruitment::admin.quiz.assignments.create', compact('quiz', 'candidates'));
    }

    /**
     * Store a newly created quiz assignment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $quizId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $quizId)
    {
        $request->validate([
            'candidate_ids' => 'required|array',
            'candidate_ids.*' => 'exists:candidate_users,id',
            'notes' => 'nullable|string',
        ]);

        $result = $this->quizAssignmentService->assignQuizToMultipleCandidates(
            $quizId,
            $request->candidate_ids,
            [
                'notes' => $request->notes,
            ]
        );

        if (count($result['errors']) > 0) {
            return redirect()->route('admin.quiz.assignments.create', $quizId)
                ->with('warning', 'Some assignments could not be created. See details below.')
                ->with('errors', $result['errors']);
        }

        return redirect()->route('admin.quiz.assignments.index', $quizId)
            ->with('success', 'Quiz assignments created successfully.');
    }

    /**
     * Display the specified quiz assignment.
     *
     * @param int $quizId
     * @param int $assignmentId
     * @return \Illuminate\View\View
     */
    public function show($quizId, $assignmentId)
    {
        $quiz = Quizes::findOrFail($quizId);
        $assignment = $this->quizAssignmentService->getAssignmentsForQuiz($quizId)
            ->where('id', $assignmentId)
            ->firstOrFail();
        
        return view('recruitment::admin.quiz.assignments.show', compact('quiz', 'assignment'));
    }

    /**
     * Show the form for editing the specified quiz assignment.
     *
     * @param int $quizId
     * @param int $assignmentId
     * @return \Illuminate\View\View
     */
    public function edit($quizId, $assignmentId)
    {
        $quiz = Quizes::findOrFail($quizId);
        $assignment = $this->quizAssignmentService->getAssignmentsForQuiz($quizId)
            ->where('id', $assignmentId)
            ->firstOrFail();
        
        return view('recruitment::admin.quiz.assignments.edit', compact('quiz', 'assignment'));
    }

    /**
     * Update the specified quiz assignment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $quizId
     * @param int $assignmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $quizId, $assignmentId)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,expired',
            'notes' => 'nullable|string',
        ]);

        $this->quizAssignmentService->updateAssignmentStatus(
            $assignmentId,
            $request->status,
            [
                'notes' => $request->notes,
            ]
        );

        return redirect()->route('admin.quiz.assignments.index', $quizId)
            ->with('success', 'Quiz assignment updated successfully.');
    }

    /**
     * Remove the specified quiz assignment from storage.
     *
     * @param int $quizId
     * @param int $assignmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($quizId, $assignmentId)
    {
        $this->quizAssignmentService->deleteAssignment($assignmentId);

        return redirect()->route('admin.quiz.assignments.index', $quizId)
            ->with('success', 'Quiz assignment deleted successfully.');
    }
} 