<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{

    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $permissions = [
        'create_projects',
        'delete_projects',
        'create_users',
        'update_projects',
        'get_projects',
        'get_all_projects'
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    // Create roles
    $roles = ['Admin', 'Manager', 'Team Member'];

    foreach ($roles as $role) {
        Role::create(['name' => $role]);
    }

    // Assign permissions to roles
    $adminRole = Role::findByName('Admin');
    $managerRole = Role::findByName('Manager');
    $userRole = Role::findByName('Team Member');

    $adminRole->givePermissionTo(['create_projects', 'delete_projects','create_users','update_projects','get_projects','get_all_projects']);
    // $managerRole->givePermissionTo(['create projects', 'edit projects']);
    // $userRole->givePermissionTo('create projects');

    $adminRole = Role::findByName('Admin');
$managerRole = Role::findByName('Manager');
$teamMemberRole = Role::findByName('Team Member');



}
}
