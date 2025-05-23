<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Recruitment\Services\Interfaces\IQuizAssignmentService;

class QuizAssignmentController extends Controller
{
    protected $quizAssignmentService;

    public function __construct(IQuizAssignmentService $quizAssignmentService)
    {
        $this->quizAssignmentService = $quizAssignmentService;
    }

    /**
     * Display a listing of the candidate's quiz assignments.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $candidateId = Auth::guard('candidate')->id();
        $assignments = $this->quizAssignmentService->getAssignmentsForCandidate($candidateId);
        
        return view('recruitment::candidate.quiz.assignments.index', compact('assignments'));
    }

    /**
     * Display the specified quiz assignment.
     *
     * @param int $assignmentId
     * @return \Illuminate\View\View
     */
    public function show($assignmentId)
    {
        $candidateId = Auth::guard('candidate')->id();
        $assignments = $this->quizAssignmentService->getAssignmentsForCandidate($candidateId);
        $assignment = $assignments->where('id', $assignmentId)->firstOrFail();
        
        return view('recruitment::candidate.quiz.assignments.show', compact('assignment'));
    }

    /**
     * Start the quiz for the candidate.
     *
     * @param int $assignmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function startQuiz($assignmentId)
    {
        $candidateId = Auth::guard('candidate')->id();
        $assignments = $this->quizAssignmentService->getAssignmentsForCandidate($candidateId);
        $assignment = $assignments->where('id', $assignmentId)->firstOrFail();
        
        // Check if the quiz is already completed
        if ($assignment->status === 'completed') {
            return redirect()->route('candidate.quiz.assignments.show', $assignmentId)
                ->with('warning', 'You have already completed this quiz.');
        }
        
        // Check if the quiz is expired
        if ($assignment->status === 'expired') {
            return redirect()->route('candidate.quiz.assignments.show', $assignmentId)
                ->with('warning', 'This quiz has expired.');
        }
        
        // Redirect to the quiz page
        return redirect()->route('candidate.mcq.index', encrypt($assignment->quiz_id));
    }
}