<?php

namespace Modules\Recruitment\Http\Controllers\College;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Recruitment\Models\College;
use Modules\Recruitment\Models\Placement\PlacementColleges;
use Modules\Recruitment\Models\CollegeCandidatePlacement;
use Illuminate\Support\Facades\Auth;

class CollegeDashboardController extends Controller
{
    public function __construct()
    {
        // Ensure only authenticated colleges can access these methods
        $this->middleware('auth:college');
    }

    /**
     * Display the college dashboard.
     */
    public function index()
    {
        // Get the authenticated college using the college guard
        $college = Auth::guard('college')->user();

        if (!$college) {
            abort(403, 'Unauthorized: No authenticated college found.');
        }

        // Get placements associated with this college
        $placements = PlacementColleges::with(['college'])
            ->where('college_id', $college->id)
            ->get();

        // Get counts for different statuses
        $pendingPlacements = $placements->where('college_acceptance', '0')->count();
        $acceptedPlacements = $placements->where('college_acceptance', '1')->count();
        $rejectedPlacements = $placements->where('college_acceptance', '2')->count();

        // Get candidates associated with accepted placements
        $candidatePlacements = CollegeCandidatePlacement::whereIn(
            'placement_id',
            $placements->where('college_acceptance', true)->pluck('placement_id')
        )->get();

        return view('recruitment::college.dashboard', compact(
            'college',
            'placements',
            'pendingPlacements',
            'acceptedPlacements',
            'rejectedPlacements',
            'candidatePlacements'
        ));
    }

    /**
     * Update college acceptance for a placement
     */
    public function updatePlacementAcceptance(Request $request, $placementId)
    {
        $request->validate([
            'acceptance' => 'required|boolean'
        ]);

        $college = Auth::guard('college')->user();

        if (!$college) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: No authenticated college found.'
            ], 403);
        }

        $placement = PlacementColleges::where('placement_id', $placementId)
            ->where('college_id', $college->id)
            ->firstOrFail();

        $placement->college_acceptance = $request->acceptance;
        $placement->save();

        return response()->json([
            'success' => true,
            'message' => $request->acceptance ? 'Placement accepted successfully' : 'Placement rejected successfully'
        ]);
    }

    /**
     * Get placement statistics
     */
    public function getPlacementStats()
    {
        $college = Auth::guard('college')->user();

        if (!$college) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: No authenticated college found.'
            ], 403);
        }

        $placements = PlacementColleges::where('college_id', $college->id)->get();

        $monthlyStats = $placements->groupBy(function ($placement) {
            return \Carbon\Carbon::parse($placement->created_at)->format('M Y');
        })->map(function ($group) {
            return $group->count();
        });

        return response()->json([
            'monthlyStats' => $monthlyStats
        ]);
    }
}
