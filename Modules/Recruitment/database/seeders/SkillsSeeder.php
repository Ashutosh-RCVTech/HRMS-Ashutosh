<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recruitment\Models\Skill;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $skills = [
            // Development & Technical Skills
            'PHP',
            'Laravel',
            'Tailwind CSS',
            'HTML',
            'JavaScript',
            'React',
            'Node.js',
            'Python',
            'Django',
            'Vue.js',
            'Angular',
            'MySQL',
            'PostgreSQL',
            'DevOps',
            'AWS',
            'Docker',
            'Kubernetes',
            'Git',
            'Linux',
            'Data Science',
            'Machine Learning',

            // Content Creation & Digital Marketing
            'Writing & Editing',
            'SEO Knowledge',
            'Social Media Management',
            'Graphic Design',
            'Video Editing',
            'Marketing Strategy',
            'Analytics & Performance Tracking',
            'Basic HTML & CMS',

            // SEO & Search Engine Optimization
            'Keyword Research',
            'On-Page SEO',
            'Off-Page SEO',
            'Technical SEO',
            'Google Analytics & Search Console',
            'Competitor Analysis',
            'Content Strategy',
            'Local SEO',

            // Business Development & Sales
            'Lead Generation',
            'Sales & Negotiation',
            'CRM & Relationship Management',
            'Market Research & Analysis',
            'Networking & Communication',
            'Proposal Writing & Pitching',
            'Digital Marketing Knowledge',
            'Data Analysis & Reporting',

            // Online Bidding & Freelancing
            'Bidding Strategy',
            'Proposal Writing',
            'Client Communication',
            'Negotiation Skills',
            'Time Management',
            'Market Research',
            'Basic Digital Marketing Knowledge',
            'Portfolio Management'
        ];


        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill]);
        }
    }
}
