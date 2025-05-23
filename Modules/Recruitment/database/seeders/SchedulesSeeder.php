<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recruitment\Models\Schedule;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $schedules = [
            'Day Shift',
            'Night Shift',
            'Rotational Shift',
            'Flexible Hours',
            'Remote',
            'Hybrid',
            'On-Site',
            'Weekend Shift'
        ];

        foreach ($schedules as $schedule) {
            Schedule::firstOrCreate(['name' => $schedule]);
        }
    }
}
