<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tasks extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $fillable = ['title', 'description', 'project_id', 'start_time','end_time','assigned_to', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return [
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->starttime,
            'end_time' => $this->endtime,
            'status' => $this->status,
        ];
    }
}
