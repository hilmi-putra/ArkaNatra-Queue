<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DivisionModel;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        DivisionModel::create(['name' => 'Administration']);
        DivisionModel::create(['name' => 'Production']);
        DivisionModel::create(['name' => 'Sales']);
        DivisionModel::create(['name' => 'Asservice']);
    }
}