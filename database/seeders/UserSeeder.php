<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    // Insert users
    $users = User::insert([
        ['id' => 4, 'name' => 'Admin', 'email' => 'venkatesh6@gmail.com', 'password' => bcrypt('password'), 'role_id' => 1],
        ['id' => 5, 'name' => 'Manager 1', 'email' => 'manager2@example.com', 'password' => bcrypt('password'), 'role_id' => 2],
        ['id' => 6, 'name' => 'Team_member', 'email' => 'teammemeber2@example.com', 'password' => bcrypt('password'), 'role_id' => 3],
    ]);

    $adminRole = Role::findByName('Admin');
    $managerRole = Role::findByName('Manager');
    $teamMemberRole = Role::findByName('Team Member');

    $user1 = User::find(4);
    if ($user1) {
        $user1->assignRole($adminRole);
    }

    $user2 = User::find(5);
    if ($user2) {
        $user2->assignRole($managerRole);
    }

    $user3 = User::find(6);
    if ($user3) {
        $user3->assignRole($teamMemberRole);
    }
}

    }

