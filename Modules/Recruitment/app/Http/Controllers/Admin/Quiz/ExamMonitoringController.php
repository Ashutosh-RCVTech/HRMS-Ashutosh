<?php

namespace Modules\Recruitment\Http\Controllers\Admin\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Models\ExamAttempt;
use Modules\Recruitment\Models\McqTestCandidate;
use Carbon\Carbon;

class ExamMonitoringController extends Controller
{
    public function index()
    {
        return view('recruitment::admin.monitoring.index');
    }

    public function getAttempts(Request $request)
    {

        $query = ExamAttempt::with([
            'candidate.candidateUser.basicDetail', // Updated relationship chain
            'candidate' => function ($q) {
                $q->select('id', 'email', 'candidate_id');
            }
        ])->latest();
        $query->where('quiz_id', 9);
        if ($search = $request->get('search')) {
            $query->whereHas('candidate.candidateUser', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $attempts = $query->paginate(20);

        // Transform the collection to add a human-readable "created_at" field.
        $attempts->getCollection()->transform(function ($attempt) {
            // Assuming $attempt->created_at is an instance of Carbon,
            // If it's not, you can use Carbon::parse($attempt->created_at)
            $attempt->created_at_human = $attempt->created_at->diffForHumans();
            return $attempt;
        });

        return response()->json([
            'attempts' => $attempts->items(),
            'total' => $attempts->total(),
            'current_page' => $attempts->currentPage(),
            'last_page' => $attempts->lastPage(),
        ]);
    }

    public function getStats()
    {
        return response()->json([
            'total' => ExamAttempt::count(),
            'in_progress' => ExamAttempt::where('status', 'in_progress')->count(),
            'completed' => ExamAttempt::where('status', 'completed')->count(),
            'expired' => ExamAttempt::where('status', 'expired')->count(),
            'disqualified' => ExamAttempt::where('status', 'disqualified')->count(),
        ]);
    }
}
