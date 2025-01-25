<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProjectRequest;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class AdminController extends Controller
{
    // public function createUser(UserRequest $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|string|min:8',
    //         'role_id' => 'required|exists:roles,id',
    //     ]);

    //     if ($validated['role_id'] == $this->getAdminRoleId()) {
    //         return response()->json(['error' => 'Admin not allowed to create a user with the Admin role.'], 403);
    //     }
    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => bcrypt($validated['password']),
    //         'role_id' => $validated['role_id'],
    //     ]);
    //     return response()->noContent();
    // }
    public function createUser(UserRequest $request)
    {
        // Validate input

        if (!auth()->user()->hasRole('Admin')) {
            return response()->json(['error' => 'User does not have the Admin role.'], 403);
        }

        $validated = $request->validated();


        // Fetch the role by ID
        $role = Role::find($validated['role_id']);
        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }

        // Restrict the creation of Admin role users
        if ($role->name === 'Admin') {
            return response()->json(['error' => 'Admin not allowed to create a user with the Admin role.'], 403);
        }

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Use Hash::make for better security
        ]);

        // Assign the role to the user
        $user->assignRole($role->name);

        // Return a success response
        return response()->json([
            'message' => 'User created successfully.',
            'user' => $user,
        ], 201);
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
