<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use RoleAndUserSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\ExamAttemptsSeeder;
use Database\Seeders\CandidateUserSeeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\CollegeCandidateSeeder;
use Modules\Recruitment\Database\Seeders\JobOpeningSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            PermissionTableSeeder::class,
            // CandidateUserSeeder::class,
            // RoleAndUserSeeder::class,
            // CollegeCandidateSeeder::class,
            McqTestCandidateSeeder::class,
            // ExamAttemptsSeeder::class
        ]);
    }
}
