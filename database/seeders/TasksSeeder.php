<?php

namespace Database\Seeders;

use App\Models\Tasks;
use Illuminate\Database\Seeder;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tasks::insert([
            [
                'title' => 'Task A',
                'description' => 'This is task A.',
                'project_id' => 1,
                'assigned_to' => 5,
                'status' => 'Pending',
                'start_time' => now()->addDays(1),
                'end_time' => now()->addDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Task B',
                'description' => 'This is task B.',
                'project_id' => 2,
                'assigned_to' => 5,
                'status' => 'In Progress',
                'start_time' => now()->addDays(1),
                'end_time' => now()->addDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
