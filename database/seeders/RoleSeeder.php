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
        'update_projects',
        'get_projects',
        'get_all_projects',
        'create_users',
        'get_all_users',
        'update_users',
        'delete_users',
        'get_user',

        // Manager permissions
         'get_manager_projects' ,
         'get_projects',
         'update_project' ,
         'delete_project',
         'create_task',
         'update-task',
         'get_all_tasks',
         'get_task',
         'delete_task'
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
    }

    $roles = ['Admin', 'Manager', 'Team Member'];

    foreach ($roles as $role) {
        Role::firstOrCreate(['name' => $role]);
    }

    // Assign permissions to roles
    $adminRole = Role::findByName('Admin');
    $managerRole = Role::findByName('Manager');
    $userRole = Role::findByName('Team Member');

    // Assign permissions to Admin role
    $adminRole->givePermissionTo([
        'create_projects', 'delete_projects', 'update_projects',
        'get_projects', 'get_all_projects', 'create_users',
        'get_all_users', 'update_users', 'delete_users', 'get_user'
    ]);

    $managerRole->givePermissionTo([
        'get_manager_projects' , 'get_projects','update_project' ,'delete_project',
        'create_task','update-task','get_all_tasks','get_task','delete_task'
    ]);
}


}
