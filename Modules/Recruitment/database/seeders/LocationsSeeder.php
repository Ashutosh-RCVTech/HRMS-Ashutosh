<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recruitment\Models\Location;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $locations = ['Greater Noida', 'Delhi', 'Noida', 'Bangalore', 'Ahmedabad', 'Mumbai', 'Pune'];

        foreach ($locations as $location) {
            Location::firstOrCreate(['name' => $location]);
        }
    }
}
