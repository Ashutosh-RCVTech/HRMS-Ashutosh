<?php

namespace Modules\Recruitment\Database\Seeders;


use Illuminate\Database\Seeder;

class RecruitmentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SkillsSeeder::class,
            SchedulesSeeder::class,
            LocationsSeeder::class,
            JobTypesSeeder::class,
            EducationLevelsSeeder::class,
            DegreesSeeder::class,
            BenefitsSeeder::class,
            ClientsSeeder::class
        ]);
    }
}
