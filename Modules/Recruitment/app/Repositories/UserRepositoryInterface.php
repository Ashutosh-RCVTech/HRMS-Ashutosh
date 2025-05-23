<?php

namespace Modules\Recruitment\Repositories;

interface UserRepositoryInterface
{
    public function getAll();
    public function createWithProfile(array $userData, array $profileData);
    public function updateWithProfile($userId, array $userData, array $profileData);
    public function assignRole($userId, $roleId);
}
