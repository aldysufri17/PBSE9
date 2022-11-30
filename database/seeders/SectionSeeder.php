<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'section_id' => 128,
            'name' => 'Admin'
        ]);
        Section::create([
            'section_id' => 1,
            'name' => 'GKB'
        ]);
        Section::create([
            'section_id' => 2,
            'name' => 'ELEKTRO'
        ]);
    }
}
