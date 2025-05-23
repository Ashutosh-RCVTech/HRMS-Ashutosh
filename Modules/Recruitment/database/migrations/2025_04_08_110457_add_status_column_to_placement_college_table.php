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
        Schema::table('placement_college', function (Blueprint $table) {
            $table->tinyInteger('mail_status')->default(0)->comment('0 = pending & 1 = done ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placement_college', function (Blueprint $table) {
            
        });
    }
};
