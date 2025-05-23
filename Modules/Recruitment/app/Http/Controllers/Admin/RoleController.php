<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Services\RoleService;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'boolean',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id'
            ]);

            $role = $this->roleService->createRole($validated);
            return response()->json(['success' => true, 'role' => $role]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->getRole($id);
            return response()->json($role);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'boolean',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id'
            ]);

            $role = $this->roleService->updateRole($id, $validated);
            return response()->json(['success' => true, 'role' => $role]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->deleteRole($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function getPermissions($id)
    {
        try {
            $permissions = $this->roleService->getRolePermissions($id);
            return response()->json($permissions);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }
    }

    public function updatePermissions(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id'
            ]);

            $this->roleService->updateRolePermissions($id, $validated['permissions']);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function getUsers($id)
    {
        try {
            $role = $this->roleService->getRole($id);
            $users = $role->users()->with('profile')->get();
            return response()->json([
                'success' => true,
                'users' => $users,
                'total' => $users->count()
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to get users'], 422);
        }
    }

    public function getAvailableUsers()
    {
        try {
            $users = User::whereDoesntHave('roles')->orWhereHas('roles', function($query) {
                $query->where('name', '!=', 'admin');
            })->with('profile')->get();
            
            return response()->json([
                'success' => true,
                'users' => $users,
                'total' => $users->count()
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to get available users'], 422);
        }
    }

    public function assignUser($roleId, $userId)
    {
        try {
            $role = $this->roleService->getRole($roleId);
            $user = User::findOrFail($userId);
            
            if (!$user->hasRole($role)) {
                $user->assignRole($role);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'User assigned successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to assign user'], 422);
        }
    }

    public function removeUser($roleId, $userId)
    {
        try {
            $role = $this->roleService->getRole($roleId);
            $user = User::findOrFail($userId);
            
            if ($user->hasRole($role)) {
                $user->removeRole($role);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'User removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove user'], 422);
        }
    }
} 