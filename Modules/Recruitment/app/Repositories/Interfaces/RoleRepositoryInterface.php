<?php

namespace Modules\Recruitment\Repositories\Interfaces;

interface RoleRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getPermissions($roleId);
    public function updatePermissions($roleId, array $permissionIds);
    public function findByName($name);
} 