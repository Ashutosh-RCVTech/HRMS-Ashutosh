<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Recruitment\Models\Client;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $clients = [
            [
                'name' => 'RCV Technologies',
                'slug' => Str::slug('RCV Technologies'),
                'company_type' => 'Private',
                'industry' => 'Information Technology',
                'website_url' => 'https://rcvtech.com',
                'description' => 'RCV Technologies is a leading IT solutions provider specializing in software development and digital transformation.',
                'primary_email' => 'info@rcvtech.com',
                'phone_number' => '+1 (555) 123-4567',
                'linkedin_url' => 'https://linkedin.com/company/rcv-technologies',
                'address_line_1' => '123 Tech Park Avenue',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'USA',
                'postal_code' => '94105',
                'company_size' => '51-200',
                'founded_year' => 2010,
                'is_active' => true,
                'is_featured' => true,
                'subscription_tier' => 3,
                'contact_person_name' => 'John Smith',
                'contact_person_position' => 'HR Director',
                'contact_person_email' => 'john.smith@rcvtech.com',
                'recruitment_preferences' => json_encode([
                    'preferred_skills' => ['PHP', 'JavaScript', 'DevOps', 'Cloud'],
                    'experience_levels' => ['Mid-level', 'Senior']
                ])
            ],
            [
                'name' => 'ROILift',
                'slug' => Str::slug('ROILift'),
                'company_type' => 'Public',
                'industry' => 'Marketing & Advertising',
                'website_url' => 'https://roilift.com',
                'description' => 'ROILift is a performance marketing agency focused on driving measurable results for clients across various industries.',
                'primary_email' => 'contact@roilift.com',
                'phone_number' => '+1 (555) 987-6543',
                'linkedin_url' => 'https://linkedin.com/company/roilift',
                'address_line_1' => '456 Marketing Plaza',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10022',
                'company_size' => '11-50',
                'founded_year' => 2015,
                'is_active' => true,
                'is_featured' => false,
                'subscription_tier' => 2,
                'contact_person_name' => 'Sarah Johnson',
                'contact_person_position' => 'Talent Acquisition',
                'contact_person_email' => 'sarah.johnson@roilift.com',
                'recruitment_preferences' => json_encode([
                    'preferred_skills' => ['Marketing', 'SEO', 'PPC', 'Content Strategy'],
                    'experience_levels' => ['Entry-level', 'Mid-level']
                ])
            ]
        ];

        foreach ($clients as $clientData) {
            Client::updateOrCreate(
                ['name' => $clientData['name']],
                $clientData
            );
        }
    }
}
