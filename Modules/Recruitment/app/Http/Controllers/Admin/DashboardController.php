<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\CalendarService;
use Modules\Recruitment\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;
    protected $calendarService;

    public function __construct(DashboardService $dashboardService, CalendarService $calendarService)
    {
        $this->dashboardService = $dashboardService;
        $this->calendarService = $calendarService;
    }

    public function index()
    {
        try {
            return view(
                'recruitment::admin.dashboard',
                $this->dashboardService->getDashboardData()
            );
        } catch (\Exception $e) {
            // Handle exception
            return back()->withError($e->getMessage());
        }
    }

    public function filter(Request $request)
    {
        try {
            $status = $request->input('status', 'all');
            return response()->json(
                $this->dashboardService->getFilteredDashboardData($status)
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function calendarEvents()
    {
        return response()->json($this->calendarService->getJobDeadlineEvents());
    }

    public function refresh()
    {
        try {
            return response()->json(
                $this->dashboardService->getDashboardData()
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function export($metric)
    {
        try {
            return $this->dashboardService->exportMetricData($metric);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function trends(Request $request)
    {
        try {
            $timeframe = $request->input('timeframe', 'monthly');
            return response()->json(
                $this->dashboardService->getTrendData($timeframe)
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
