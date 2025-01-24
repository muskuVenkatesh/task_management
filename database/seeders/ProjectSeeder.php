<?php

namespace Database\Seeders;

use App\Models\Projects;
use Illuminate\Database\Seeder;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Projects::insert([
            [
                'name' => 'Project Alpha',
                'description' => 'This is the first project.',
                'manager_id' => 4,
                'start_date' => now(),
                'end_date' => now()->addMonths(6),
                'created_at' => now(),
                'status' => 'Pending',
                'updated_at' => now(),
            ],
            [
                'name' => 'Project Beta',
                'description' => 'This is the second project.',
                'manager_id' => 5,
                'start_date' => now(),
                'end_date' => now()->addMonths(6),
                'status' => 'In Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
