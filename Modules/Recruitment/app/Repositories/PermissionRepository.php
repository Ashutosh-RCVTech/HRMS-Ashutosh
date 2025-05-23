<?php

namespace Modules\Recruitment\Repositories;

use Spatie\Permission\Models\Permission;
use Modules\Recruitment\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('roles')->get();
    }

    public function find($id)
    {
        return $this->model->with('roles')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'description' => $data['description'] ?? null,
            'category' => $data['category'],
        ]);
    }

    public function update($id, array $data)
    {
        $permission = $this->find($id);
        return $permission->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'],
        ]);
    }

    public function delete($id)
    {
        $permission = $this->find($id);
        return $permission->delete();
    }

    public function getCategories()
    {
        return $this->model->distinct()->pluck('category');
    }

    public function findByCategory($category)
    {
        return $this->model->where('category', $category)->get();
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}
