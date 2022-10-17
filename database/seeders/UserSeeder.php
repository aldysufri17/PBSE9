<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => 1,
            'section_id' => 1,
            'status' => 1,
            'password' => bcrypt('secret'),
        ]);

        User::create([
            'name' => 'Teknik Komputer',
            'email' => 'tekkom@mail.com',
            'role_id' => 3,
            'section_id' => 1,
            'status' => 1,
            'password' => bcrypt('secret'),
        ]);
    }
}
