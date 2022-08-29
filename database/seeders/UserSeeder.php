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
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => 1,
            'status' => true,
            'password' => bcrypt('secret'),
        ]);

        //$user->assignRole('admin');

        $user = User::create([
            'name' => 'Teknik Komputer',
            'email' => 'tekkom@mail.com',
            'role_id' => 2,
            'status' => false,
            'password' => bcrypt('secret'),
        ]);

        //$user->assignRole('user');
    }
}
