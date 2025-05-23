<?php

namespace Modules\Recruitment\Repositories;

use Spatie\Permission\Models\Role;
use Modules\Recruitment\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('permissions')->get();
    }

    public function find($id)
    {
        return $this->model->with('permissions')->findOrFail($id);
    }

    public function create(array $data)
    {
        $role = $this->model->create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'description' => $data['description'] ?? null,
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function update($id, array $data)
    {
        $role = $this->find($id);

        $role->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function delete($id)
    {
        $role = $this->find($id);
        return $role->delete();
    }

    public function getPermissions($roleId)
    {
        $role = $this->find($roleId);
        return $role->permissions;
    }

    public function updatePermissions($roleId, array $permissionIds)
    {
        $role = $this->find($roleId);
        return $role->syncPermissions($permissionIds);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}
