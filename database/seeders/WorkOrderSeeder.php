<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkOrderModel;

class WorkOrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'status' => 'pending',
                'ref_id' => 'WO-001',
                'customer_id' => 1,
                'user_id' => 1,
                'division_id' => 1,
                'work_type_id' => 1,
                'domain' => 'customer1.com',
                'quantity' => 10,
                'description' => 'Bulk indexing job',
                'file_mou' => null,
                'file_work_form' => null,
                'additional_file' => null,
                'fast_track' => false,
                'date_received' => now(),
                'date_queue' => null,
                'date_revision' => null,
                'revision_count' => 0,
                'date_completed' => null,
            ],
            [
                'status' => 'progress', // FIXED
                'ref_id' => 'WO-002',
                'customer_id' => 2,
                'user_id' => 2,
                'division_id' => 1,
                'work_type_id' => 2,
                'domain' => 'customer2.net',
                'quantity' => 5,
                'description' => 'Urgent indexing project',
                'file_mou' => null,
                'file_work_form' => null,
                'additional_file' => null,
                'fast_track' => true,
                'date_received' => now()->subDays(2),
                'date_queue' => now(),
                'date_revision' => null,
                'revision_count' => 1,
                'date_completed' => null,
            ]
        ];

        foreach ($orders as $order) {
            WorkOrderModel::create($order);
        }
    }
}
