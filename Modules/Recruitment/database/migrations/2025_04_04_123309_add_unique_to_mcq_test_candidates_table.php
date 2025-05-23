<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mcq_test_candidates', function (Blueprint $table) {
            // Add composite unique index
            $table->unique(['quiz_id', 'candidate_id'], 'mcq_quiz_candidate_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mcq_test_candidates', function (Blueprint $table) {
            // Drop the unique index
            $table->dropUnique('mcq_quiz_candidate_unique');
        });
    }
};
