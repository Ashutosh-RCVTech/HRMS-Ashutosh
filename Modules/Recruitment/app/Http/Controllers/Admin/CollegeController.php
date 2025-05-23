<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Models\College;

class CollegeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $colleges = College::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('state', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('recruitment::admin.colleges.partials.colleges-table', compact('colleges'))->render();
        }

        return view('recruitment::admin.colleges.index', compact('colleges', 'search'));
    }

    public function show(College $college)
    {
        return view('recruitment::admin.colleges.show', compact('college'));
    }

    public function destroy(College $college)
    {
        $college->delete();
        return redirect()->route('admin.colleges.index')->with('success', 'College deleted successfully');
    }

    public function toggleStatus(Request $request, College $college)
    {
        try {
            $college->is_active = !$college->is_active;
            $college->save();

            return response()->json([
                'success' => true,
                'message' => 'College status updated successfully',
                'is_active' => $college->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update college status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
