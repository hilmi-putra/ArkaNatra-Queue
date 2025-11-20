<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DivisionModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminDivisi = DivisionModel::where('name', 'Administration')->first();
        $productionDivisi = DivisionModel::where('name', 'Production')->first();
        $salesDivisi = DivisionModel::where('name', 'Sales')->first();

        // Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'id_divisi' => $adminDivisi->id,
        ]);
        $admin->assignRole('admin');

        // Production user
        $production = User::create([
            'name' => 'Production User',
            'email' => 'production@gmail.com',
            'password' => Hash::make('password'),
            'id_divisi' => $productionDivisi->id,
        ]);
        $production->assignRole('production');

        // Sales user
        $sales = User::create([
            'name' => 'Sales User',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('password'),
            'id_divisi' => $salesDivisi->id,
        ]);
        $sales->assignRole('sales');
    }
}