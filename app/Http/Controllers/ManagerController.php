<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tasks;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
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

        $user = auth()->user()->id;
        $project = Projects::findOrFail($id);
        $user = $project->manager_id;
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
        $start_time = Carbon::parse($validated['start_time'])->format('Y-m-d H:i:s');
        $end_time = Carbon::parse($validated['end_time'])->format('Y-m-d H:i:s');

        $task = Tasks::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'project_id' => $validated['project_id'],
            'start_time' => $start_time,
            'end_time' => $end_time,
            'assigned_to' => $validated['assigned_to'],
            'status' => $validated['status'],
        ]);

        return response()->json($task, 201);
    }
}
