<?php

namespace Database\Seeders;

use App\Models\WorkOrderModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestingWorkOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks for safe truncation of test data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Clean up old test data based on a specific, safe identifier
        $this->command->info('Clearing old test work orders...');
        WorkOrderModel::where('ref_id', 'like', 'TEST-%')->delete();
        $this->command->info('Old test work orders cleared.');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Create 100 new work orders using the factory
        $this->command->info('Creating 1000 new test work orders...');
        WorkOrderModel::factory()->count(1000)->create();
        $this->command->info('1000 new test work orders created successfully.');
    }
}
