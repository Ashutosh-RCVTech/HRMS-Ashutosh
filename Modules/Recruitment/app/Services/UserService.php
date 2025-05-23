<?php

namespace Modules\Recruitment\Services;


use Modules\Recruitment\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }
    public function createUserWithProfile(array $userData, array $profileData)
    {
        // Hash the password before creating
        $userData['password'] = bcrypt($userData['password']);
        return $this->userRepository->createWithProfile($userData, $profileData);
    }

    public function updateUserWithProfile($userId, array $userData, array $profileData)
    {
        // Handle password hashing if present
        if (isset($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        }
        return $this->userRepository->updateWithProfile($userId, $userData, $profileData);
    }

    public function assignRoles($userId, array $roleIds)
    {
        foreach ($roleIds as $roleId) {
            $this->userRepository->assignRole($userId, $roleId);
        }
    }

    // Optional: Additional methods for completeness
    public function removeRoleFromUser($userId, $roleId)
    {
        // This method would require an update to the repository interface
        // if it were to be implemented.
    }

    public function getUserById($userId)
    {
        // This method would require a corresponding method in the repository interface
    }


    public function deleteUser($userId)
    {
        // This method would require a corresponding method in the repository interface
    }
}
