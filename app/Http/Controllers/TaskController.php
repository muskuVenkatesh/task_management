<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;

class TaskController extends Controller
{
    public function getAssignedTasks()
    {
        if (!auth()->user()->can('get_assigned_tasks')) {
            return response()->json(['error' => 'User does not have the permission to get_assigned_tasks.'], 403);
        }
        $tasks = Tasks::where('assigned_to', Auth::id())->get();
        return response()->json($tasks);
    }

    public function updateTask(TaskUpdateRequest $request, $taskId)
    {
        if (!auth()->user()->can('update_task')) {
            return response()->json(['error' => 'User does not have the permission to update_task.'], 403);
        }
        $task = Tasks::findOrFail($taskId);

        if ($task->assigned_to !== Auth::id()) {
            return response()->json(['error' => 'You are not assigned to this task.'], 403);
        }

        $task->update($request->validated());
        return response()->json($task);
    }

    public function getTaskById($taskId)
    {
        if (!auth()->user()->can('get_task')) {
            return response()->json(['error' => 'User does not have the permission to get_task.'], 403);
        }
        $task = Tasks::find($taskId);
        if (!$task) {
            return response()->json(['error' => 'Task not found.'], 404);
        }
        if ($task->assigned_to !== Auth::id()) {
            return response()->json(['error' => 'You are not assigned to this task.'], 403);
        }
        return response()->json($task);
    }


    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $tasks = Tasks::search($request->query('query'))->get();

        return response()->json($tasks);
    }
}
