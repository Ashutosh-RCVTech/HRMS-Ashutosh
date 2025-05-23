<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\UserService;
use Modules\Recruitment\Http\Requests\Admin\StoreUserProfileRequest;

class UserProfileController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index()
    {
        // Fetch users and their profiles
        $users = $this->userService->getAllUsers();
        return view('recruitment::admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('recruitment::admin.users.create', compact('roles'));
    }

    public function store(StoreUserProfileRequest $request)
    {
        $user = $this->userService->createUserWithProfile(
            $request->userData(),
            $request->profileData()
        );

        // Handle roles assignment
        if ($request->has('roles')) {
            $this->userService->assignRoles($user->id, $request->roles);
        }

        return redirect()->route('admin.users.index');
    }
}
