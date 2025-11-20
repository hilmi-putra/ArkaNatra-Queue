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
                'work_type' => 'Indexing Basic',
                'regular_estimation_days' => 5,
                'extra_days_per_quantity' => 1,
                'fast_track_estimation_days' => 2,
                'division_id' => 1
            ],
            [
                'work_type' => 'Indexing Premium',
                'regular_estimation_days' => 3,
                'extra_days_per_quantity' => 0,
                'fast_track_estimation_days' => 1,
                'division_id' => 1
            ]
        ];

        foreach ($types as $t) {
            WorkTypeModel::create($t);
        }
    }
}
