<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Events\ProjectCreated;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProjectRequest;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class AdminController extends Controller
{
    public function createUser(UserRequest $request)
    {

        if (!auth()->user()->can('create_users')) {
            return response()->json(['error' => 'User does not have the permission to create a user.'], 403);
        }
        if (!auth()->user()->hasRole('Admin')) {
            return response()->json(['error' => 'User does not have the Admin role.'], 403);
        }

        $validated = $request->validated();


        $role = Role::find($validated['role_id']);
        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        if ($role->name === 'Admin') {
            return response()->json(['error' => 'Admin not allowed to create a user with the Admin role.'], 403);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($role->name);

        return response()->json([
            'message' => 'User created successfully.',
            'user' => $user,
        ], 201);
    }

    public function getAllUsers()
    {
        if (!auth()->user()->can('get_user')) {
            return response()->json(['error' => 'User does not have permission to view users.'], 403);
        }
        $users = User::withoutTrashed()->get();
        return response()->json([
            'users' => $users
        ]);
    }


    public function getUserById($id)
    {

        if (!auth()->user()->can('get_user')) {
            return response()->json(['error' => 'User does not have permission to get user.'], 403);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        return response()->json([
            'message' => 'User retrieved successfully.',
            'user' => $user,
        ], 200);
    }

        public function updateUser(UserRequest $request, $id)
    {
        if (!auth()->user()->can('update_users')) {
            return response()->json(['error' => 'User does not have the permission to update a user.'], 403);
        }

        if (!auth()->user()->hasRole('Admin')) {
            return response()->json(['error' => 'User does not have the Admin role.'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $validated = $request->validated();

        if (isset($validated['role_id'])) {
            $role = Role::find($validated['role_id']);
            if (!$role) {
                return response()->json(['error' => 'Role not found.'], 404);
            }

            if ($role->name === 'Admin') {
                return response()->json(['error' => 'Cannot assign the Admin role to a user.'], 403);
            }

            $user->syncRoles($role->name);
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password,
        ]);

        return response()->noContent();
    }

    public function deleteUser($id)
    {
        if (!auth()->user()->can('delete_users')) {
            return response()->json(['error' => 'User does not have the permission to delete a user.'], 403);
        }

        if (!auth()->user()->hasRole('Admin')) {
            return response()->json(['error' => 'User does not have the Admin role.'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully.',
        ], 200);
    }


    private function getAdminRoleId()
    {
        return Role::where('name', 'Admin')->value('id');
    }

    private function getManagerRoleId()
    {
        return Role::where('name', 'Manager')->value('id');
    }

    public function createProject(ProjectRequest $request)
    {
        $validated = $request->validated();
        $roleId = auth()->user()->role_id;
        $manager = User::find($validated['manager_id']);
    if (!$manager || $manager->role_id !== $this->getManagerRoleId()) {
        return response()->json(['error' => 'The selected user is not a manager.'], 403);
    }

    if ($manager->role_id == $this->getAdminRoleId()) {
        return response()->json(['error' => 'Admin not allowed to assign the project himself'], 403);
    }
        $project = Projects::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'manager_id' => $validated['manager_id'],
            'status' => $validated['status'],
        ]);
        event(new ProjectCreated($project));

        return response()->json(['message' => 'Project created successfully', 'data' => $project], 201);
    }

    public function getAllProjects(Request $request)
    {
        $projects = Projects::withoutTrashed()->get();
        $total = $projects->count();
        return response()->json(['data' => $projects, 'total' => $total], 200);
    }

    public function getProjectById($id)
    {
        $project = Projects::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return response()->json(['data' => $project], 200);
    }

    public function updateProject(ProjectRequest $request, $id)
    {
    $validated = $request->validated();
    $project = Projects::find($id);

    if (!$project) {
    return response()->json(['error' => 'Project not found'], 404);
    }

    $manager = User::find($validated['manager_id']);
    if (!$manager || $manager->role_id !== $this->getManagerRoleId()) {
    return response()->json(['error' => 'The selected user is not a manager.'], 403);
    }

    $project->update([
    'name' => $validated['name'],
    'description' => $validated['description'],
    'start_date' => $validated['start_date'],
    'end_date' => $validated['end_date'],
    'manager_id' => $validated['manager_id'],
    'status' => $validated['status'],
    ]);

    return response()->json(['message' => 'Project updated successfully', 'data' => $project], 200);
    }

    public function deleteProject($id)
    {
    $project = Projects::find($id);
    if (!$project) {
        return response()->json(['error' => 'Project not found'], 404);
    }
    $project->delete();
    return response()->json(['message' => 'Project soft deleted successfully'], 200);
    }




}
