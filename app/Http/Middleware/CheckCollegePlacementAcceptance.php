<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Recruitment\Models\Placement\PlacementColleges;
use Illuminate\Support\Facades\Auth;

class CheckCollegePlacementAcceptance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $placementId=request()->segment(3);
        $collegeId=Auth::guard('college')->user()->id;
        $collegePlacement=PlacementColleges::where('college_id',$collegeId)
        ->where('placement_id',$placementId)->first();
      

        if($collegePlacement->college_acceptance!=1){
            // return redirect()->route('college.not.acceptance');
            return redirect()
            ->route('college.placement.detail')
            ->with('error', 'Please accept this campus drive');

        }
      
        return $next($request);
    }
}
