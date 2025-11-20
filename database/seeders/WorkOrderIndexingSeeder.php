<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkOrderIndexingModel;

class WorkOrderIndexingSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'work_order_id' => 1,
                'indexing_type_id' => 1,
                'finished' => false
            ],
            [
                'work_order_id' => 1,
                'indexing_type_id' => 2,
                'finished' => true
            ],
            [
                'work_order_id' => 2,
                'indexing_type_id' => 3,
                'finished' => false
            ],
        ];

        foreach ($data as $item) {
            WorkOrderIndexingModel::create($item);
        }
    }
}
