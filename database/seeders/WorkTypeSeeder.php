<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkTypeModel;

class WorkTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'work_type' => 'Open Journal System (OJS)',
                'regular_estimation_days' => 14,
                'extra_days_per_quantity' => 3,
                'fast_track_estimation_days' => 7,
                'division_id' => 1
            ],
            [
                'work_type' => 'Website Company Profile',
                'regular_estimation_days' => 14,
                'extra_days_per_quantity' => 3,
                'fast_track_estimation_days' => 7,
                'division_id' => 1
            ]
        ];

        foreach ($types as $t) {
            WorkTypeModel::create($t);
        }
    }
}
