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
        Schema::create('quiz_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_id')
            ->constrained('placement')
            ->onDelete('cascade');
            $table->foreignId('placement_college_id')
            ->constrained('placement_college')
            ->onDelete('cascade');
            $table->foreignId('course_id')->constrained('quiz_courses')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quizes')->onDelete('cascade');

           $table->date('schedule_date')->nullable();
            $table->time('start_time');
            $table->string('timezone');
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
        Schema::dropIfExists('quiz_schedule');
    }
};
