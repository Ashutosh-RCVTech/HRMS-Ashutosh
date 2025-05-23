<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidate_career_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidate_users')->onDelete('cascade');
            $table->string('current_industry');
            $table->string('department');
            $table->string('desired_job_type');
            $table->string('desired_employment_type');
            $table->string('preferred_shift');
            $table->string('preferred_work_location');
            $table->decimal('expected_salary', 10, 2);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_career_profiles');
    }
};
