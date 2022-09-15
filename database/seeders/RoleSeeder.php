<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_id' => 1,
            'name' => 'Admin'
        ]);
        Role::create([
            'role_id' => 2,
            'name' => 'Auditor'
        ]);
        Role::create([
            'role_id' => 3,
            'name' => 'User'
        ]);
    }
}
