<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\ManagerProjectRequest;

class ManagerController extends Controller
{

    // To get projects Assigned to the manager
    public function getProjectsByManager()
    {
        if (!auth()->user()->can('get_manager_projects')) {
            return response()->json(['error' => 'User does not have the permission to get_manager_projects.'], 403);
        }
        $manager = auth()->user();
        $projects = Projects::where('manager_id', $manager->id)->get();
        return response()->json($projects);
    }

    public function update(ManagerProjectRequest $request, $id)
    {

        if (!auth()->user()->can('update_project')) {
            return response()->json(['error' => 'User does not have the permission to update the project.'], 403);
        }
        $project = Projects::findOrFail($id);
        if ($project->manager_id !== Auth::id()) {
            return response()->json(['error' => 'You are not the owner of this project.'], 403);
        }

        $project->update($request->validated());
        return response()->json($project);
    }


    public function delete($id)
    {
        if (!auth()->user()->can('get_manager_projects')) {
            return response()->json(['error' => 'User does not have the permission to delete_project.'], 403);
        }
        $project = Projects::findOrFail($id);
        if ($project->manager_id !== Auth::id()) {
            return response()->json(['error' => 'You are not the owner of this project.'], 403);
        }
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }


    // Method for Assign tasks to team members

    public function assignTask(TaskRequest $request)
    {

        if (!auth()->user()->can('create_task')) {
            return response()->json(['error' => 'User does not have the permission to create_task.'], 403);
        }
        $validated = $request->validated();

        // Ensure the manager is assigning a task to a team member
        $teamMember = User::find($validated['assigned_to']);

        if (!$teamMember->hasRole('Team Member')) {
            return response()->json(['error' => 'Assigned user is not a team member.'], 403);
        }

        $task = Tasks::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'project_id' => $validated['project_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'assigned_to' => $validated['assigned_to'],
            'status' => $validated['status'],
        ]);

        return response()->json($task, 201);
    }
}
