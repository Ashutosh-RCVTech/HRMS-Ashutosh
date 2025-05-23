<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing permissions
        Permission::query()->delete();

        // Define permission groups
        $permissionGroups = [
            'dashboard' => ['view', 'export', 'filter', 'trends', 'refresh', 'calendar'],
            'users' => ['view', 'create', 'update', 'delete'],
            'jobs' => ['view', 'create', 'update', 'delete', 'toggle-status', 'generate-description'],
            'candidates' => ['view', 'create', 'update', 'delete', 'search', 'filter'],
            'job-applications' => ['view', 'update-status', 'download'],
            'skills' => ['view', 'create', 'update', 'delete', 'search', 'add-multiple'],
            'education-levels' => ['view', 'create', 'update', 'delete'],
            'benefits' => ['view', 'create', 'update', 'delete'],
            'job-types' => ['view', 'create', 'update', 'delete'],
            'schedules' => ['view', 'create', 'update', 'delete'],
            'degrees' => ['view', 'create', 'update', 'delete'],
            'clients' => ['view', 'create', 'update', 'delete'],
            'locations' => ['view', 'create', 'update', 'delete'],
            'contacts' => ['view', 'show', 'toggle-read', 'reply', 'delete', 'bulk-delete'],
        ];

        // Create permissions
        foreach ($permissionGroups as $group => $actions) {
            foreach ($actions as $action) {
                $permissionName = "{$group}_{$action}";
                Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
            }
        }
    }
}
