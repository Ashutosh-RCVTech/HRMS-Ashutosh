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
            $table->enum('status', ['pending', 'completed', 'expired'])
                ->default('pending')
                ->after('candidate_id'); // Optional: specify column position

            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mcq_test_candidates', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'assigned_at',
                'completed_at',
                'notes'
            ]);
        });
    }
};
