<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\Interfaces\RoleRepositoryInterface;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->all();
    }

    public function getRole($id)
    {
        return $this->roleRepository->find($id);
    }

    public function createRole(array $data)
    {
        // Validate role name uniqueness
        if ($this->roleRepository->findByName($data['name'])) {
            throw new \Exception('A role with this name already exists.');
        }

        return $this->roleRepository->create($data);
    }

    public function updateRole($id, array $data)
    {
        $existingRole = $this->roleRepository->find($id);
        
        // Check if name is being changed and if it's already taken
        if (isset($data['name']) && $data['name'] !== $existingRole->name) {
            if ($this->roleRepository->findByName($data['name'])) {
                throw new \Exception('A role with this name already exists.');
            }
        }

        return $this->roleRepository->update($id, $data);
    }

    public function deleteRole($id)
    {
        return $this->roleRepository->delete($id);
    }

    public function getRolePermissions($roleId)
    {
        return $this->roleRepository->getPermissions($roleId);
    }

    public function updateRolePermissions($roleId, array $permissionIds)
    {
        return $this->roleRepository->updatePermissions($roleId, $permissionIds);
    }
} 