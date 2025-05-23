<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamAttemptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 200 exam attempts.
        for ($i = 1; $i <= 200; $i++) {
            DB::table('exam_attempts')->insert([
                'mcq_test_candidate_id'  => 12,                // Candidate id fixed to 12
                'quiz_id'                => 1,                 // Quiz id fixed to 9
                'start_time'             => Carbon::now(),     // Current timestamp as start time
                'end_time'               => null,              // End time; can be updated on completion
                'time_spent'             => 0,                 // Initially no time spent
                'ip_address'             => '127.0.0.1',       // Example IP address; update as needed
                'status'                 => 'in_progress',         // Status set to pending
                'score'                  => 0,                 // Initial score value
                'total_questions'        => 0,                 // Total number of questions (to be updated accordingly)
                'correct_answers'        => 0,                 // Initially zero correct answers
                'incorrect_answers'      => 0,                 // Initially zero incorrect answers
                'unanswered_questions'   => 0,                 // Initially zero unanswered questions
                'answers'                => null,   // JSON encoded empty array for answers
                'reviewed_questions'     => null,   // JSON encoded empty array for reviewed questions
            ]);
        }
    }
}
