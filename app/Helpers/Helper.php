<?php

use Illuminate\Support\Facades\DB;
use Modules\Recruitment\Models\Placement\PlacementColleges;

if (!function_exists('hasPermissionForRoles')) {
    function hasPermissionForRoles($permissionName, $roleNames)
    {

        if (auth('web')->check()) {

            $gaurd = 'web';
        }

        if (auth('user')->check()) {
            $gaurd = 'user';
        }

        if (count($roleNames) == 0) {
            return false;
        }
        if (in_array("admin", $roleNames)) {
            return true;
        }
        $roleIds = DB::table('roles')->whereIn('name', $roleNames)->pluck('id');
        $permissionId = DB::table('permissions')->where('name', $permissionName)->where('guard_name', $gaurd)->value('id');



        $count = DB::table('role_has_permissions')
            ->whereIn('role_id', $roleIds)
            ->where('permission_id', $permissionId)
            ->count();


        if ($count > 0) {

            return true;
        } else {
            return false;
        }
    }

    if (!function_exists('collegeHavePlacement')) {
        /**
         * Get the latest placement records and count for a given college.
         *
         * @param  int  $collegeId
         * @return array
         */


        function collegeHavePlacement($collegeId)
        {
            $latestRecords = PlacementColleges::join('placement', 'placement.id', '=', 'placement_college.placement_id')
                ->where('placement_college.college_id', $collegeId)
                ->where('placement_college.college_acceptance', 0)
                ->orderBy('placement_college.created_at', 'desc') // Or any appropriate column for ordering
                ->take(5)
                ->get();

            $count = PlacementColleges::join('placement', 'placement.id', '=', 'placement_college.placement_id')
                ->where('placement_college.college_id', $collegeId)
                ->where('placement_college.college_acceptance', 0)
                ->count();

            return [
                'latestRecords' => $latestRecords,
                'count' => $count,
            ];
        }
    }
}
