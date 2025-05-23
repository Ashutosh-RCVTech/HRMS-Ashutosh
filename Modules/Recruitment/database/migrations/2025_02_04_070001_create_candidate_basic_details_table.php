<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidate_basic_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidate_users')->onDelete('cascade');

            // $table->string('name');
            $table->string('location')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('mobile_verified')->default(false);
            $table->date('availability')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->string('resume_headline')->nullable();
            $table->json('key_skills')->nullable();
            $table->json('it_skills')->nullable();
            $table->text('projects')->nullable();
            $table->text('profile_summary')->nullable();
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
        Schema::dropIfExists('candidate_basic_details');
    }
};
