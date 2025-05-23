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
        Schema::table('placement_drives', function (Blueprint $table) {
            // Add date and time fields
            if (!Schema::hasColumn('placement_drives', 'drive_date')) {
                $table->date('drive_date')->after('description')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'start_time')) {
                $table->time('start_time')->after('drive_date')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'end_time')) {
                $table->time('end_time')->after('start_time')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'last_date_to_apply')) {
                $table->date('last_date_to_apply')->after('end_time')->nullable();
            }
            
            // Add status tracking fields
            if (!Schema::hasColumn('placement_drives', 'completed_at')) {
                $table->timestamp('completed_at')->after('status')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->after('completed_at')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'rescheduled_at')) {
                $table->timestamp('rescheduled_at')->after('cancelled_at')->nullable();
            }
            
            // Add venue and registration fields
            if (!Schema::hasColumn('placement_drives', 'venue')) {
                $table->string('venue')->after('description')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'max_students')) {
                $table->integer('max_students')->after('venue')->default(0);
            }
            if (!Schema::hasColumn('placement_drives', 'registered_students')) {
                $table->integer('registered_students')->after('max_students')->default(0);
            }
            
            // Add other metadata fields
            if (!Schema::hasColumn('placement_drives', 'eligibility_criteria')) {
                $table->text('eligibility_criteria')->after('description')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'package_offered')) {
                $table->decimal('package_offered', 10, 2)->after('eligibility_criteria')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'required_documents')) {
                $table->json('required_documents')->after('package_offered')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'venue_updated_at')) {
                $table->timestamp('venue_updated_at')->after('rescheduled_at')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'criteria_updated_at')) {
                $table->timestamp('criteria_updated_at')->after('venue_updated_at')->nullable();
            }
            if (!Schema::hasColumn('placement_drives', 'documents_updated_at')) {
                $table->timestamp('documents_updated_at')->after('criteria_updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placement_drives', function (Blueprint $table) {
            $columns = [
                'drive_date',
                'start_time',
                'end_time',
                'last_date_to_apply',
                'completed_at',
                'cancelled_at',
                'rescheduled_at',
                'venue',
                'max_students',
                'registered_students',
                'eligibility_criteria',
                'package_offered',
                'required_documents',
                'venue_updated_at',
                'criteria_updated_at',
                'documents_updated_at'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('placement_drives', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 