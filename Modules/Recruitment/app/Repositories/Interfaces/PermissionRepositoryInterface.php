<?php

namespace Modules\Recruitment\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getCategories();
    public function findByCategory($category);
    public function findByName($name);
} 