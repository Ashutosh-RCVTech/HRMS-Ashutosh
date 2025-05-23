<?php

namespace Modules\Recruitment\Http\Controllers\College;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Services\PlacementDriveService;

class PlacementDriveController extends Controller
{
    protected $driveService;

    public function __construct(PlacementDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

    public function index()
    {
        $drives = $this->driveService->getAllDrives();
        return view('recruitment::college.drives.index', compact('drives'));
    }

    public function create()
    {
        return view('recruitment::college.drives.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'drive_date' => 'required|date',
            'last_date_to_apply' => 'required|date|after:today',
            'eligibility_criteria' => 'required|string',
            'package_offered' => 'required|numeric',
            'status' => 'required|in:draft,active,completed,cancelled'
        ]);

        $data['college_id'] = auth()->guard('college')->id();

        $drive = $this->driveService->createDrive($data);

        return redirect()->route('college.drives.index')
            ->with('success', 'Placement drive created successfully.');
    }

    public function show($id)
    {
        $drive = $this->driveService->getDriveById($id);
        return view('recruitment::college.drives.show', compact('drive'));
    }

    public function edit($id)
    {
        $drive = $this->driveService->getDriveById($id);
        return view('recruitment::college.drives.edit', compact('drive'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'drive_date' => 'required|date',
            'last_date_to_apply' => 'required|date|after:today',
            'eligibility_criteria' => 'required|string',
            'package_offered' => 'required|numeric',
            'status' => 'required|in:draft,active,completed,cancelled'
        ]);

        $drive = $this->driveService->updateDrive($id, $data);

        return redirect()->route('college.drives.index')
            ->with('success', 'Placement drive updated successfully.');
    }

    public function destroy($id)
    {
        $this->driveService->deleteDrive($id);

        return redirect()->route('college.drives.index')
            ->with('success', 'Placement drive deleted successfully.');
    }
}
