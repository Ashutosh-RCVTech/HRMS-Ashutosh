<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeCandidateSeeder extends Seeder
{
    public function run(): void
    {
        $candidateIds = DB::table('candidate_users')->pluck('id')->take(100); // fetch first 100 candidate ids

        $data = [];

        foreach ($candidateIds as $candidateId) {
            $data[] = [
                'candidate_id' => $candidateId,
                'college_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('college_candidates')->insert($data);
    }
}
