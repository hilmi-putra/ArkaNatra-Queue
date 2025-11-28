<?php

namespace Database\Factories;

use App\Models\CustomerModel;
use App\Models\DivisionModel;
use App\Models\User;
use App\Models\WorkOrderModel;
use App\Models\WorkTypeModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WorkOrderModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkOrderModel::class;

    protected static $queueNumber = 1;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get random IDs from related models.
        // Using pluck('id')->random() is efficient. If tables are empty, this will fail.
        // Assuming the necessary related data exists from other seeders.
        $customerId = CustomerModel::inRandomOrder()->first()->id ?? null;
        $divisionId = DivisionModel::inRandomOrder()->first()->id ?? null;
        $workTypeId = WorkTypeModel::inRandomOrder()->first()->id ?? null;
        
        // Get users with specific roles
        $salesId = User::role('sales')->inRandomOrder()->first()->id ?? null;
        $productionId = User::role('production')->inRandomOrder()->first()->id ?? null;

        return [
            'ref_id' => 'TEST-' . date('Ymd') . '-' . Str::random(6),
            'customer_id' => $customerId,
            'division_id' => $divisionId,
            'work_type_id' => $workTypeId,
            'sales_id' => $salesId,
            'production_id' => $productionId,
            'domain' => $this->faker->domainName,
            'quantity' => $this->faker->numberBetween(1, 3),
            'description' => $this->faker->sentence,
            'status' => 'queue',                 // Ubah jadi QUEUE
            'fast_track' => $this->faker->boolean(25),
            'date_received' => now()->toDateString(),
            'date_queue' => now()->toDateString(), // biasanya kalau QUEUE harus punya date_queue
            'estimasi_date' => null,
            
            // ⭐ Antrian ke berurutan
            'antrian_ke' => self::$queueNumber++,

            'revision_count' => 0,
            'date_completed' => null,
            'file_mou' => null,
            'file_work_form' => null,
            'additional_file' => null,
        ];

    }
}
