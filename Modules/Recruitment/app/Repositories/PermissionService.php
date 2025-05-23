<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }

    public function getPermission($id)
    {
        return $this->permissionRepository->find($id);
    }

    public function createPermission(array $data)
    {
        // Validate permission name uniqueness
        if ($this->permissionRepository->findByName($data['name'])) {
            throw new \Exception('A permission with this name already exists.');
        }

        return $this->permissionRepository->create($data);
    }

    public function updatePermission($id, array $data)
    {
        $existingPermission = $this->permissionRepository->find($id);
        
        // Check if name is being changed and if it's already taken
        if (isset($data['name']) && $data['name'] !== $existingPermission->name) {
            if ($this->permissionRepository->findByName($data['name'])) {
                throw new \Exception('A permission with this name already exists.');
            }
        }

        return $this->permissionRepository->update($id, $data);
    }

    public function deletePermission($id)
    {
        return $this->permissionRepository->delete($id);
    }

    public function getPermissionCategories()
    {
        return $this->permissionRepository->getCategories();
    }

    public function getPermissionsByCategory($category)
    {
        return $this->permissionRepository->findByCategory($category);
    }
} 