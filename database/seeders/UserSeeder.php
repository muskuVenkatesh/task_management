<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ['id' => 4, 'name' => 'Manager 1', 'email' => 'manager1@example.com', 'password' => bcrypt('password'), 'role_id' => 1],
            ['id' => 5, 'name' => 'Manager 2', 'email' => 'manager2@example.com', 'password' => bcrypt('password'), 'role_id' => 2],
            ['id' => 6, 'name' => 'Manager 2', 'email' => 'teammemeber2@example.com', 'password' => bcrypt('password'), 'role_id' => 3],
        ]);
    }
}
