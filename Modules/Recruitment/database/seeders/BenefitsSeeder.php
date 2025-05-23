<?php

namespace Modules\Recruitment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recruitment\Models\Benefit;

class BenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $benefits = ['Health Insurance', 'Provident Fund', 'Health Insurance', 'National Pension Scheme', 'Gym Membership', 'Stock Options'];

        foreach ($benefits as $benefit) {
            Benefit::firstOrCreate(['name' => $benefit]);
        }
    }
}
