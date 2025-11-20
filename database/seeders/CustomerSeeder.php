<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerModel;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'token' => 'CUST-001',
                'name' => 'PT Maju Jaya',
                'address' => 'Jakarta Selatan',
                'phone' => '081234567890',
                'email' => 'contact@majujaya.com'
            ],
            [
                'token' => 'CUST-002',
                'name' => 'CV Sumber Rezeki',
                'address' => 'Surabaya',
                'phone' => '082233445566',
                'email' => 'info@sumberrezeki.co.id'
            ]
        ];

        foreach ($customers as $customer) {
            CustomerModel::create($customer);
        }
    }
}
