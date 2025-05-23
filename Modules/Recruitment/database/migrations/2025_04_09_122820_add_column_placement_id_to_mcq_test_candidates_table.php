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
            $table->foreignId('placement_id')
                ->constrained('placement')->nullable()
                ->onDelete('cascade')->after('quiz_id');
            $table->foreignId('college_id')->constrained('colleges')->nullable()->onDelete('cascade')->after('placement_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mcq_test_candidates', function (Blueprint $table) {});
    }
};
