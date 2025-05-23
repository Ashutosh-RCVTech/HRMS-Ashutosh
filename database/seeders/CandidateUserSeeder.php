<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CandidateUserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $batchSize = 100;
        $totalRecords = 1000;

        for ($i = 0; $i < $totalRecords; $i += $batchSize) {
            $users = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $users[] = [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'), // default password
                    'profile_completed' => $faker->boolean(70),
                    'profile_data' => $faker->optional()->paragraph,
                    'provider_id' => $faker->optional()->uuid,
                    'token' => $faker->optional()->sha256,
                    'refresh_token' => $faker->optional()->sha256,
                    'expires_in' => $faker->optional()->numberBetween(3600, 7200),
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('candidate_users')->insert($users);
        }
    }
}
