<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recruitment\Models\Degree;

class DegreesSeeder extends Seeder
{
    public function run()
    {
        $degrees = [
            // Science & Technology
            'BSc',
            'MSc',
            'BTech',
            'MTech',
            'BCA',
            'MCA',
            'PhD in Science',

            // Business & Management
            'BBA',
            'MBA',
            'PGDM',
            'PhD in Management',

            // Commerce & Finance
            'BCom',
            'MCom',
            'CA',
            'CFA',
            'CS',
            'ICWA',

            // Arts & Humanities
            'BA',
            'MA',
            'PhD in Arts',
            'BFA',
            'MFA',

            // Medicine & Healthcare
            'MBBS',
            'BDS',
            'BPT',
            'BPharm',
            'MPharm',
            'MD',
            'MS',
            'PhD in Medicine',

            // Law & Governance
            'LLB',
            'LLM',
            'PhD in Law',

            // Education
            'BEd',
            'MEd',
            'PhD in Education',

            // Engineering Specializations
            'BE Mechanical',
            'BE Electrical',
            'BE Civil',
            'BE Computer Science',
            'BE Electronics',
            'BE Aerospace',
            'BE Biotech',
            'BE Chemical',

            // Other Specializations
            'Diploma in Engineering',
            'Diploma in Nursing',
            'Diploma in Finance'
        ];

        foreach ($degrees as $degree) {
            Degree::firstOrCreate(['name' => $degree]);
        }
    }
}
