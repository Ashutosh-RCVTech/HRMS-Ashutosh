<?php

namespace Modules\Recruitment\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Recruitment\Models\CandidateUser;

use Spatie\Activitylog\Models\Activity;


class ActivityMcqCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */




    public function candidates(Request $request)
    {
        $query = CandidateUser::query();

        // Search by name or email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by status (active/inactive)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('last_active_at', '>=', now()->subMinutes(5));
            } else {
                $query->where(function ($q) {
                    $q->whereNull('last_active_at')
                        ->orWhere('last_active_at', '<', now()->subMinutes(5));
                });
            }
        }

        // Get users with pagination
        $candidates = $query->latest()->paginate(2)->appends(request()->query());



        return view('recruitment::activity-log.candidates', compact('candidates'));
    }


    public function candidateActivities(Request $request, $candidate = null)
    {



        $query = Activity::query();

        // Filter by user_id
        if (isset($candidate)) {
            $query->where('causer_id', $candidate);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('log_name', $request->action);
        }

        // Filter by date range
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        // Search in details
        if ($request->filled('search')) {
            $query->where('details', 'like', '%' . $request->search . '%');
        }

        // Get unique actions for filter dropdown
        $actions = Activity::distinct()->pluck('log_name');



        // Paginate results with 10 items per page
        $activities = $query->latest()->paginate(10)->appends(request()->query());

        return view('recruitment::activity-log.index', compact('activities', 'actions'));
    }



    public function logActivity(Request $request)
    {
        // Ensure the candidate is authenticated using the custom guard
        if (!auth('mcq_test_candidate')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get message from the request
        $message = $request->input('message', 'No message provided');

        // Log the activity using the candidate's authentication details
        activity('Suspicious Activity')
            ->causedBy(auth('mcq_test_candidate')->user())
            ->withProperties([
                'ip' => $request->ip(),
                'user_agent' => $request->header('CandidateUser-Agent'),
            ])
            ->log($message);

        return response()->json(['success' => true, 'message' => 'Activity logged']);
    }


    public function index()
    {
        return view('recruitment::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruitment::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('recruitment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('recruitment::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
