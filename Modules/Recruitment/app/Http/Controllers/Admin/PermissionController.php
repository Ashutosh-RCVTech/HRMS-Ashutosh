<?php

namespace Modules\Recruitment\Http\Controllers\Admin;


use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->getAllPermissions();
        // $categories = $this->permissionService->getPermissionCategories();
        return view('permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $permission = $this->permissionService->createPermission($validated);
            return response()->json(['success' => true, 'permission' => $permission]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        try {
            $permission = $this->permissionService->getPermission($id);

            // Add logging or dd() for debugging
            Log::info('Permission retrieved', ['id' => $id, 'permission' => $permission]);

            return response()->json($permission);
        } catch (\Exception $e) {
            // Log the full error for debugging
            Log::error('Permission retrieval error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Permission not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category' => 'required|string|max:255'
            ]);

            $permission = $this->permissionService->updatePermission($id, $validated);
            return response()->json(['success' => true, 'permission' => $permission]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->permissionService->deletePermission($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function getCategories()
    {
        try {
            $categories = $this->permissionService->getPermissionCategories();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
