<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\ScheduleService;

class ScheduleController extends Controller
{
    protected $service;

    public function __construct(ScheduleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $schedules = $this->service->getAllSchedulesPaginated(10, $search);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'schedules' => $schedules,
            ]);
        }

        return view('recruitment::admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('recruitment::admin.schedules.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:schedules,name|max:255',
            ]);

            $this->service->createSchedule($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Schedule created successfully',
                    'redirect' => route('admin.schedules.index')
                ]);
            }
            return redirect()->route('admin.schedules.index')
                ->with('success', 'Schedule created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating schedule: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $schedule = $this->service->getAllSchedules()->find($id);
        return view('recruitment::admin.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:schedules,name,' . $id . '|max:255',
        ]);

        $this->service->updateSchedule($request->all(), $id);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->deleteSchedule($id);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}
