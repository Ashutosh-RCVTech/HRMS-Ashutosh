<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\CalendarService;

class CalendarController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function getEvents(Request $request)
    {
        $events = $this->calendarService->getCalendarEvents(
            $request->input('start'),
            $request->input('end')
        );

        return response()->json($events);
    }
}
