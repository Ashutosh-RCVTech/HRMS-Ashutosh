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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // Basic Info
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('company_type')->nullable()->comment('e.g. Private, Public, Government, etc.');
            $table->string('industry')->nullable();
            $table->string('website_url')->nullable();
            $table->text('description')->nullable();

            // Contact Details
            $table->string('primary_email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('alternative_phone')->nullable();

            // Social Media Links
            $table->string('linkedin_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();

            // Address
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();

            // Company Size & Details
            $table->string('company_size')->nullable()->comment('e.g. 1-10, 11-50, 51-200, 201-500, 501+');
            $table->year('founded_year')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('tax_id')->nullable();

            // Recruitment Settings
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('subscription_tier')->default(1)->comment('1=Basic, 2=Pro, 3=Enterprise');
            $table->dateTime('subscription_expiry')->nullable();
            $table->integer('jobs_posted_count')->default(0);
            $table->integer('hiring_capacity')->nullable()->comment('How many positions they typically hire for');

            // Primary Contact Person
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_position')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();

            // Media
            $table->string('client_logo_path')->nullable();
            $table->string('banner_image_path')->nullable();

            // Custom Settings
            $table->json('recruitment_preferences')->nullable()->comment('Stored as JSON with preferred skills, experience levels, etc.');
            $table->json('custom_fields')->nullable()->comment('For any additional client-specific data');

            // Activity Tracking
            $table->dateTime('last_login_at')->nullable();
            $table->integer('login_count')->default(0);

            // Standard Timestamps
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
        Schema::dropIfExists('clients');
    }
};
