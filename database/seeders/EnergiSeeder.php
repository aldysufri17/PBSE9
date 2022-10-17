<?php

namespace Database\Seeders;

use App\Models\Energy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnergiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Energy::create([
            'name' => 'PLN',
            'unit' => 'KWH'
        ]);
        Energy::create([
            'name' => 'BBM Genset',
            'unit' => 'Liter'
        ]);
        Energy::create([
            'name' => 'Air',
            'unit' => 'M3'
        ]);
        Energy::create([
            'name' => 'Kendaraan Diesel',
            'unit' => 'Liter'
        ]);
        Energy::create([
            'name' => 'Kendaraan Non Diesel',
            'unit' => 'Liter'
        ]);
        Energy::create([
            'name' => 'Gas',
            'unit' => 'KG'
        ]);
    }
}
