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
        Schema::table('quiz_questions', function (Blueprint $table) {
            // Adding the quiz_id column after the id column and setting up the foreign key constraint.
            $table->foreignId('quiz_id')
                ->after('id')
                ->constrained('quizes') // Ensure the table name matches your actual table (e.g. 'quizzes' instead of 'quizes').
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['quiz_id']);
            // Then drop the column
            $table->dropColumn('quiz_id');
        });
    }
};
