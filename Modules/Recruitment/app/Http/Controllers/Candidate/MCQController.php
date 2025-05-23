<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Facades\Activity;
use Modules\Recruitment\Models\ExamAnswer;
use Modules\Recruitment\Models\ExamAttempt;
use Modules\Recruitment\Models\Quiz\Quizes;
use Illuminate\Validation\ValidationException;
use Modules\Recruitment\Models\Quiz\QuizQuestions;
use Modules\Recruitment\Models\Quiz\QuizCategories; 
use Modules\Recruitment\Models\Placement\QuizSchedule;
use App\Models\Student;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Modules\Recruitment\Models\CandidateUser;
class MCQController extends Controller
{
    public function landing(Request $request, $mcqId)
    {
        return view("recruitment::candidate.mcq.login");
    }




    // public function stream()
    // {
    //     $response = new StreamedResponse(function () {
    //         // Keep the connection open indefinitely
    //         while (true) {
    //             // Retrieve the most recently inserted student record.
    //             // You can modify the query as needed to fetch more records.
    //             $latestStudents = CandidateUser::orderBy('created_at', 'desc')->take(1)->get();

    //             // If there is new data, send it to the client.
    //             if ($latestStudents->isNotEmpty()) {
    //                 // Format the data according to SSE standards.
    //                 echo "data: " . $latestStudents->toJson() . "\n\n";

    //                 // Flush the data buffers immediately.
    //                 @ob_flush();
    //                 flush();
    //             }

    //             // Wait 3 seconds before checking again.
    //             sleep(3);
    //         }
    //     });

    //     // Set the proper headers for SSE.
    //     $response->headers->set('Content-Type', 'text/event-stream');
    //     $response->headers->set('Cache-Control', 'no-cache');
    //     $response->headers->set('X-Accel-Buffering', 'no');

    //     return $response;
    // }









    public function index(Request $request)
    {
        $placementId=decrypt(request()->segment(4));
        $collegeId=decrypt(request()->segment(5));
        $quizId = decrypt(request()->segment(6));

      
        $decryptQuizid = decrypt(request()->segment(6));

       
        // if (!auth('mcq_test_candidate')->check()) {
        //     return redirect()->route('candidate.mcq.signin', encrypt($quizId));
        // }
        if (!auth('mcq_test_candidate')->check()) {
            return redirect()->route('candidate.mcq.signin', ['placementId'=>request()->segment(4),'collegeId'=>request()->segment(5),'quizId' => request()->segment(6)]);
        }

        $quiz = Quizes::find($quizId);

        $quizDuration = $quiz->duration;

        $quizSchedule = QuizSchedule::where('quiz_id', $quizId)->first();

        // dd($quizSchedule);
        $quizScheduleDate = $quizSchedule->schedule_date;
        $quizScheduleTime = $quizSchedule->start_time;
        $quizScheduleTimeZone = $quizSchedule->timezone;
        // $quizScheduleDate = $quiz->schedule_date;
        // $quizScheduleTime = $quiz->start_time;
        // $quizScheduleTimeZone = $quiz->timezone;
        $scheduledDateTime = $quizScheduleDate . ' ' . $quizScheduleTime;
        // dd($scheduledDateTime);

        // Retrieve active categories along with their active questions and options.
        $categories = QuizCategories::with([
            'questions' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('id')
                    ->with([
                        'options'
                    ]);
            }
        ])
            ->where('active_status', 1)
            ->where('quiz_id', $quizId)
            ->orderBy('id')
            ->get();


        // Randomize questions if configured.
        if (config('exam.randomize_questions')) {
            $categories->each(function ($category) {
                $category->questions = $category->questions->shuffle();
            });
        }


        // Count total active questions.
        $totalQuestions = QuizQuestions::where('is_active', 1)->where('quiz_id', $quizId)->count();


        // Set a scheduled start time (IST) for the exam.
        $scheduledStartTime = Carbon::parse($scheduledDateTime, $quizScheduleTimeZone);

        // Calculate exam duration and remaining time.
        $examDuration = (int) $quizDuration * 60; // 120 minutes in seconds.
        $endTime = $scheduledStartTime->copy()->addSeconds($examDuration);
        $remainingTime = (int) $endTime->diffInSeconds(now()->setTimezone($quizScheduleTimeZone), absolute: true);



        $attempt = ExamAttempt::where('mcq_test_candidate_id', auth('mcq_test_candidate')->user()->id)
            ->where('quiz_id', $quizId)
            ->where('status', 'completed')
            ->latest()
            ->first();


        if ($attempt) {
            return view('recruitment::mcq.exam-attempt-after');
        }


        // Optionally, check if it's not time to start the exam yet.
        if (now()->lt($scheduledStartTime)) {
            return view('recruitment::mcq.waiting', compact('scheduledStartTime'));
        }

        if (now()->gt($endTime)) {
            return redirect()->route('candidate.mcq.exam.ended', [
                'start' => $scheduledStartTime->timestamp,
                'end' => $endTime->timestamp,
                'quizId' => $decryptQuizid
            ]);
        }



        if (Session::has('warning_count')) {
            $warningCount = Session::get('warning_count');
            $warningCount++;
            Session::put('warning_count', $warningCount);
        } else {
            $warningCount = 0;
            Session::put('warning_count', $warningCount);
        }

        // Initialize the exam session (this sets start time, device info, etc.).
        $this->initializeExamSession($scheduledStartTime, $examDuration, $quizId); // Pass scheduled start time.



        // Prepare all questions data for JavaScript.
        $allQuestions = [];
        foreach ($categories as $category) {
            foreach ($category->questions as $question) {
                $allQuestions[] = [
                    'id' => $question->id,
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'question_text' => $question->question_text,
                    'options' => $question->options->map(function ($option) {
                        return [
                            'id' => $option->id,
                            'text' => $option->option_text,
                        ];
                    }),
                ];
            }
        }





        // dd($remainingTime );
        return view('recruitment::mcq.index', compact(
            'categories',
            'totalQuestions',
            'allQuestions',
            'remainingTime',
            'examDuration',
            'warningCount',
            'quizId',
            'decryptQuizid'

        ));
    }


    private function initializeExamSession($startTime = null, $examDuration = null, $quizId = null)
    {
        $agent = new Agent();

        // Use the scheduled start time if provided; otherwise, use now().
        $examStartTime = $startTime ?: now();
        Session::put('exam_started', true);
        if (!Session::has('exam_start_time')) {
            Session::put('exam_start_time', $examStartTime);
        }

        Session::put('exam_ip', request()->ip());
        Session::put('quiz_id', $quizId);
        Session::put('exam_user_agent', request()->userAgent());
        Session::put('exam_device_fingerprint', $this->generateDeviceFingerprint($agent));
        Session::put('last_activity', now());
        Session::put('tab_switches', 0);
        Session::put('answers', []);
        Session::put('reviewed_questions', []);
        if (!Session::has('warning_count')) {
            Session::put('warning_count', 0);
        }




        $endTime = $examStartTime->copy()->addSeconds($examDuration);

        // Create an exam attempt record.
        ExamAttempt::create([
            'mcq_test_candidate_id' => auth('mcq_test_candidate')->user()->id,
            'quiz_id' => $quizId,
            'start_time' => $examStartTime,
            'end_time' => $endTime,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_fingerprint' => $this->generateDeviceFingerprint($agent),
            'status' => 'in_progress'
        ]);
    }

  

    /**
     * Submit exam answers
     */
    public function submitExam(Request $request)
    {
        // Retrieve the authenticated candidate using the custom guard
        $authUser = auth('mcq_test_candidate')->user();
        $quizId = $request->input('quizId');

        // Get the exam session for the authenticated candidate
        $examSession = ExamAttempt::where('mcq_test_candidate_id', $authUser->id)
            ->where('status', 'in_progress')
            ->where('quiz_id', $quizId)
            ->first();

        activity('Exam Submitted')
            ->causedBy($authUser)
            ->withProperties(['ip' => $request->ip(), 'email' => $authUser->email])
            ->log('Exam is submitted by user at ' . Carbon::now() . ' - Session ID: ' . ($examSession ? $examSession->id : 'N/A'));

        if (!$examSession) {
            return response()->json(['error' => 'No active exam session found'], 404);
        }

        // Calculate time spent from the request value (adjusted as needed)
        $timeSpent = (int) $request->timeSpent - 1;

        // Start the transaction
        DB::beginTransaction();
        try {
            // Update exam session status and time spent
            $examSession->update([
                'status' => 'completed',
                'time_spent' => $timeSpent,
                'submitted_at' => now()
            ]);

            // Process answers and reviewed questions
            $answers = $request->input('answers', []);
            $reviewedQuestions = $request->input('reviewed_questions', []);

            $correct = 0;
            $incorrect = 0;
            $unanswered = 0;

            foreach ($answers as $answer) {
                if (isset($answer['question']) && isset($answer['answer'])) {
                    ExamAnswer::create([
                        'exam_attempt_id' => $examSession->id,
                        'question_id' => $answer['question'],
                        'selected_option' => $answer['answer'],
                        'is_reviewed' => in_array($answer['question'], $reviewedQuestions)
                    ]);
                }

                $question = QuizQuestions::find($answer['question']);
                if (!$question) {
                    continue;
                }

                if (empty($answer['answer'])) {
                    $unanswered++;
                } else {
                    $isCorrect = $question->options()
                        ->where('id', $answer['answer'])
                        ->where('is_correct', true)
                        ->exists();

                    if ($isCorrect) {
                        $correct++;
                    } else {
                        $incorrect++;
                    }
                }
            }
            $totalQuestions = QuizQuestions::where('is_active', 1)->where('quiz_id', $quizId)->count();
            // Update exam session with score details
            $examSession->update([
                'score' => count($answers) > 0 ? ($correct / $totalQuestions) * 100 : 0,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correct,
                'incorrect_answers' => $incorrect,
                'unanswered_questions' => $totalQuestions - ($incorrect + $correct)
            ]);

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Roll back on error
            DB::rollBack();

            activity('Exam Submission Error')
                ->causedBy($authUser)
                ->withProperties([
                    'ip' => $request->ip(),
                    'email' => $authUser->email,
                    'error' => $e->getMessage()
                ])
                ->log('Exam submission error occurred at ' . Carbon::now() . ' - Session ID: ' . $examSession->id);

            Log::error('Exam submission failed', [
                'error' => $e->getMessage(),
                'session_id' => $examSession->id
            ]);

            return response()->json(['error' => 'Exam submission failed. Please try again.'], 500);
        }

        // Log out using the custom guard and clear session data
        auth('mcq_test_candidate')->logout();
        $request->session()->invalidate();
        Session::forget([
            'exam_started',
            'exam_start_time',
            'exam_end_time',
            'exam_ip',
            'quiz_id',
            'exam_user_agent',
            'exam_device_fingerprint',
            'last_activity',
            'tab_switches',
            'answers',
            'reviewed_questions',
            'warning_count'
        ]);
        $request->session()->regenerateToken();

        return response()->json(['success' => true], 200);
    }


    /**
     * Validate exam session
     */
    private function validateSession()
    {
        if (!Session::has('exam_started')) {
            return false;
        }

        // Check IP address
        if (config('exam.track_ip') && Session::get('exam_ip') !== request()->ip()) {
            return false;
        }

        // Check user agent
        if (config('exam.track_user_agent') && Session::get('exam_user_agent') !== request()->userAgent()) {
            return false;
        }

        // Check device fingerprint
        if (config('exam.track_device_fingerprint')) {
            $agent = new Agent();
            if (Session::get('exam_device_fingerprint') !== $this->generateDeviceFingerprint($agent)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Generate device fingerprint
     */
    private function generateDeviceFingerprint($agent)
    {
        return md5(implode('|', [
            $agent->browser(),
            $agent->version($agent->browser()),
            $agent->platform(),
            $agent->version($agent->platform()),
            $agent->device(),
            $agent->robot(),
            $agent->isMobile(),
            $agent->isTablet(),
        ]));
    }

    /**
     * Detect suspicious activity
     */
    private function detectSuspiciousActivity()
    {
        // Check inactivity
        if (time() - Session::get('last_activity') > config('exam.max_inactive_time')) {
            return true;
        }

        // Check tab switches
        if (Session::get('tab_switches') > config('exam.max_tab_switches')) {
            return true;
        }

        return false;
    }

    /**
     * Handle suspicious activity
     */




    public function showEndedExam(Request $request)
    {
        $data = [
            'start' => Carbon::createFromTimestamp($request->start, 'Asia/Kolkata'),
            'end' => Carbon::createFromTimestamp($request->end, 'Asia/Kolkata'),
            'duration' => ($request->end - $request->start) / 60 . ' mins'
        ];

        return view('recruitment::mcq.after-exam', $data);
    }




    public function thanksCandidate(Request $request)
    {

        return view('recruitment::mcq.thanks');
    }



    public function beforeTimeSubmit(Request $request)
    {
        // First, verify that the email from the request matches the authenticated user's email
        $submittedEmail = $request->input('email');
        $authUser = auth('mcq_test_candidate')->user();
        $authEmail = $authUser->email;
        $quizId = $request->input('quizId');

        if ($submittedEmail !== $authEmail) {
            return response()->json(['error' => 'Email verification failed.'], 422);
        }

        // Retrieve the active exam session for the user
        $examSession = ExamAttempt::where('mcq_test_candidate_id', $authUser->id)
            ->where('status', 'in_progress')
            ->where('quiz_id', $quizId)
            ->first();


        $totalQuestions = QuizQuestions::where('is_active', 1)->where('quiz_id', $quizId)->count();

        // Log the exam submission activity using the custom guard's user
        activity('Exam Submitted')
            ->causedBy($authUser)
            ->withProperties(['ip' => $request->ip(), 'email' => $authEmail])
            ->log('Exam is submitted by user at ' . Carbon::now() . ' - Session ID: ' . ($examSession ? $examSession->id : 'N/A'));

        if (!$examSession) {
            return response()->json(['error' => 'No active exam session found'], 404);
        }

        // Calculate time spent (adjusted as needed)
        $timeSpent = (int) $request->timeSpent - 1;

        // Start the transaction
        DB::beginTransaction();
        try {
            // Update exam session status and time spent
            $examSession->update([
                'status' => 'completed',
                'time_spent' => $timeSpent,
                'submitted_at' => now()
            ]);

            // Process answers
            $answers = $request->input('answers', []);
            $reviewedQuestions = $request->input('reviewed_questions', []);

            $correct = 0;
            $incorrect = 0;
            $unanswered = 0;

            foreach ($answers as $answer) {
                if (isset($answer['question']) && isset($answer['answer'])) {
                    ExamAnswer::create([
                        'exam_attempt_id' => $examSession->id,
                        'question_id' => $answer['question'],
                        'selected_option' => $answer['answer'],
                        'is_reviewed' => in_array($answer['question'], $reviewedQuestions)
                    ]);
                }

                $question = QuizQuestions::find($answer['question']);
                if (!$question) {
                    continue;
                }

                if (empty($answer['answer'])) {
                    $unanswered++;
                } else {
                    $isCorrect = $question->options()
                        ->where('id', $answer['answer'])
                        ->where('is_correct', true)
                        ->exists();

                    if ($isCorrect) {
                        $correct++;
                    } else {
                        $incorrect++;
                    }
                }
            }

            $examSession->update([
                'score' => count($answers) > 0 ? ($correct / $totalQuestions) * 100 : 0,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correct,
                'incorrect_answers' => $incorrect,
                'unanswered_questions' => $totalQuestions - ($incorrect + $correct)
            ]);

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Roll back on error
            DB::rollBack();

            // Log the error activity using the custom guard's user
            activity('Exam Submission Error')
                ->causedBy($authUser)
                ->withProperties([
                    'ip' => $request->ip(),
                    'email' => $authEmail,
                    'error' => $e->getMessage()
                ])
                ->log('Exam submission error occurred at ' . Carbon::now() . ' - Session ID: ' . $examSession->id);

            Log::error('Exam submission failed', [
                'error' => $e->getMessage(),
                'session_id' => $examSession->id
            ]);

            return response()->json(['error' => 'Exam submission failed. Please try again.'], 500);
        }

        // Log out using the custom guard and clear session data
        auth('mcq_test_candidate')->logout();
        $request->session()->invalidate();
        Session::forget([
            'exam_started',
            'exam_start_time',
            'exam_end_time',
            'exam_ip',
            'exam_user_agent',
            'exam_device_fingerprint',
            'last_activity',
            'tab_switches',
            'answers',
            'reviewed_questions',
            'warning_count',
            'quiz_id'
        ]);
        $request->session()->regenerateToken();

        return response()->json(['success' => true], 200);
    }



    public function getExamResult(Request $request, $quizId, $mcqtestcandidateId)
    {
        // dd($request->all());

        $quiz = Quizes::find($quizId);
        $quizPassingPercentage = $quiz->passing_marks;
        // Fetch the latest exam attempt for the given user
        $examAttempt = ExamAttempt::where('mcq_test_candidate_id', $mcqtestcandidateId) // Use dynamic candidateId
            ->where('quiz_id', $quizId)->with('candidate.candidateInfo')
            ->first();

        if (!$examAttempt) {
            return response()->json(['message' => 'No exam attempt found'], 404);
        }

        // Fetch answers and related questions
        $examAnswers = ExamAnswer::where('exam_attempt_id', $examAttempt->id)
            ->with(['question.category', 'question.options']) // Load options for each question
            ->get();

        // Group answers by subject (category)
        $subjectResults = [];
        foreach ($examAnswers->groupBy('question.category.name') as $subjectName => $answers) {

            // $totalQuestions = $answers->count();

            $categoryId = $answers->first()->question->category_id;

            // Count *all* questions in this category for the quiz
            $totalQuestions = QuizQuestions::where('quiz_id', $quizId)
                ->where('category_id', $categoryId)
                ->count();

            // dd($totalQuestions);

            $correctAnswers = $answers->filter(function ($answer) {
                return $answer->selected_option !== null && $answer->isCorrect();
            })->count();

            $incorrectAnswers = $answers->filter(function ($answer) {
                return $answer->selected_option !== null && !$answer->isCorrect();
            })->count();

            $marked = $answers->where('is_reviewed', true)->count();

            // Calculate pass status
            // $passStatus = ($correctAnswers >= ($totalQuestions * 0.6)) ? 'passed' : 'failed';
            $requiredCorrect = ceil(($quizPassingPercentage / 100) * $totalQuestions);
            $passStatus = ($correctAnswers >= $requiredCorrect) ? 'passed' : 'failed';

            $subjectResults[] = [
                'name' => $subjectName,
                'total_questions' => $totalQuestions,
                'correct' => $correctAnswers,
                'incorrect' => $incorrectAnswers,
                'marked' => $marked,
                'pass_status' => $passStatus,
            ];
        }

        // Prepare overall result
        $resultData = [
            'overall' => [
                'score' => $examAttempt->score,
                'total_questions' => $examAttempt->total_questions,
                'name' => $examAttempt->candidate->candidateInfo->name,
                'email' => $examAttempt->candidate->candidateInfo->email,
                'correct' => $examAttempt->correct_answers,
                'incorrect' => $examAttempt->incorrect_answers,
                'time_spend' => number_format($examAttempt->time_spent / 60, 2),
                'marked' => $examAnswers->where('is_reviewed', true)->count(),
                'passing_percentage' => 60, // Set based on your requirements
            ],
            'subjects' => $subjectResults,
        ];


        if ($request['ajax']) {
            return view('recruitment::mcq.result-modal', compact('resultData', 'quizPassingPercentage'));
        }



        return view('recruitment::mcq.result', compact('resultData', 'quizPassingPercentage'));
    }

}
