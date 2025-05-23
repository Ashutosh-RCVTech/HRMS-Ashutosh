<?php

namespace Modules\Recruitment\Repositories;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        return User::with('profile')->get();
    }
    public function createWithProfile(array $userData, array $profileData)
    {
        return DB::transaction(function () use ($userData, $profileData) {
            $user = User::create($userData);
            $user->profile()->create($profileData);
            return $user;
        });
    }

    public function updateWithProfile($userId, array $userData, array $profileData)
    {
        return DB::transaction(function () use ($userId, $userData, $profileData) {
            $user = User::findOrFail($userId);
            $user->update($userData);

            if ($user->profile) {
                $user->profile()->update($profileData);
            } else {
                $user->profile()->create($profileData);
            }

            return $user->fresh()->load('profile');
        });
    }

    public function assignRole($userId, $roleId)
    {
        return DB::transaction(function () use ($userId, $roleId) {
            $user = User::findOrFail($userId);

            if (!$user->roles()->where('id', $roleId)->exists()) {
                $user->roles()->attach($roleId);
            }

            return $user->load('roles');
        });
    }

    // Optional: Add role removal method for completeness
    public function removeRole($userId, $roleId)
    {
        return DB::transaction(function () use ($userId, $roleId) {
            $user = User::findOrFail($userId);
            $user->roles()->detach($roleId);
            return $user->load('roles');
        });
    }
}
