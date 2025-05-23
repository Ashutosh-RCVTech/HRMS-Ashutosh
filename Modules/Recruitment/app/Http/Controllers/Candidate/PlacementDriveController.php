<?php

namespace Modules\Recruitment\app\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Models\College;
use Modules\Recruitment\Services\PlacementDriveService;
use Modules\Recruitment\Models\CollegeCandidate;
use Modules\Recruitment\Models\CollegeCandidatePlacement;
use Modules\Recruitment\Models\Placement\Placements;
use Modules\Recruitment\Models\Placement\PlacementColleges;
use Modules\Recruitment\Models\Placement\QuizSchedule;

class PlacementDriveController extends Controller
{
    protected $placementDriveService;

    public function __construct(PlacementDriveService $placementDriveService)
    {
        $this->placementDriveService = $placementDriveService;
    }

    // public function index(Request $request)
    // {
    //     $filters = [
    //         'status' => $request->get('status', '0'),
    //         'date_from' => $request->get('date_from'),
    //         'date_to' => $request->get('date_to'),
    //     ];

    //     $candidateId = auth()->guard('candidate')->id();

    //     $collegeCandidate = CollegeCandidate::where('candidate_id', $candidateId)->latest()->first();

    //     $collegeId = $collegeCandidate->college_id ?? null;

    //     if ($collegeCandidate) {

    //         $placementIds = CollegeCandidatePlacement::where('college_candidate_id', $collegeCandidate->id)
    //             ->pluck('placement_id')
    //             ->toArray();

    //         $placementDrives = Placements::whereIn('id', $placementIds)
    //             ->whereHas('placementColleges', function ($query) use ($collegeId) {
    //                 $query->where('college_id', $collegeId)->where('college_acceptance', 1);
    //             })->where('status', operator: 1)->get();
    //     } else {
    //         $placementDrives = collect();
    //     }

    //     return view('recruitment::candidate.placement.index', compact('placementDrives', 'collegeId'));
    // }



    public function index(Request $request)
    {
        $filters = [
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $candidateId = auth()->guard('candidate')->id();
        $collegeCandidate = CollegeCandidate::where('candidate_id', $candidateId)->latest()->first();
        $collegeId = $collegeCandidate->college_id ?? null;

        $placementDrives = collect();

        if ($collegeCandidate) {
            $placementIds = CollegeCandidatePlacement::where('college_candidate_id', $collegeCandidate->id)
                ->pluck('placement_id')
                ->toArray();

            $placementDrives = Placements::whereIn('id', $placementIds)
                ->with(['placementColleges' => function ($query) use ($collegeId) {
                    // Only load the current candidate's college's data
                    $query->where('college_id', $collegeId);
                }])
                ->when($filters['date_from'], function ($query) use ($filters) {
                    $query->whereDate('created_at', '>=', $filters['date_from']);
                })
                ->when($filters['date_to'], function ($query) use ($filters) {
                    $query->whereDate('created_at', '<=', $filters['date_to']);
                })
                ->whereHas('placementColleges', function ($query) use ($collegeId, $filters) {
                    $query->where('college_id', $collegeId)
                        ->where('college_acceptance', 1);

                    if ($filters['status'] === '0') {
                        $query->where('status', 0);
                    } elseif ($filters['status'] === '1') {
                        $query->where('status', 1);
                    }
                })
                ->get();



            // dd($placementDrives);
        }

        return view('recruitment::candidate.placement.index', compact('placementDrives', 'collegeId'));
    }



    public function show($id, $collegeId)
    {

        $placement = Placements::with([
            'educationLevel',
            'placementColleges.college',
            'placementDegrees.degree',
            'placementSkills.skill'
        ])->find($id);

        $placementCollege = PlacementColleges::where('placement_id', $id)->where('college_id', $collegeId)->first();
        $quizSchedule = QuizSchedule::where('placement_college_id', $placementCollege->id)->where('placement_id', $id)->first();

        return view('recruitment::candidate.placement.show', compact('placement', 'quizSchedule'));
    }

    public function startTest($placementId, $collegeId, $quizId)
    {
        dd($placementId, $collegeId, $quizId);
        return view("recruitment::candidate.mcq.login");
    }
}
