<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperimentalFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('experimental_features')->insert([
            [
                'feature_id' => 1,
                'feature_Name' => 'job_cross',
                'feature_Status' => 'disabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'feature_id' => 2,
                'feature_Name' => 'program_cross',
                'feature_Status' => 'disabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
