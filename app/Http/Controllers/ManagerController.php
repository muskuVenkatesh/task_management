<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function getProjectsByManager()
{
    if (!auth()->user()->can('get_manager_projects')) {
        return response()->json(['error' => 'User does not have the permission to get_manager_projects.'], 403);
    }
    $manager = auth()->user();
    $projects = Projects::where('manager_id', $manager->id)->get();
    return response()->json($projects);
}

}
