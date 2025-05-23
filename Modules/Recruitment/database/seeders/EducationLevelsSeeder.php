<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recruitment\Models\EducationLevel;

class EducationLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $educationLevels = ['Bachelors', 'Masters', 'PhD'];

        foreach ($educationLevels as $level) {
            EducationLevel::firstOrCreate(['name' => $level]);
        }
    }
}
