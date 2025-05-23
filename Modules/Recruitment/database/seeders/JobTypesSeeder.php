<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recruitment\Models\JobType;

class JobTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $jobTypes = [
            'Full-Time',
            'Part-Time',
            'Internship',
            'Experienced',
            'Contract',
            'Temporary',
            'Freelance',
            'Apprenticeship',
            'Volunteer',
            'Seasonal'
        ];

        foreach ($jobTypes as $jobType) {
            JobType::firstOrCreate(['name' => $jobType]);
        }
    }
}
