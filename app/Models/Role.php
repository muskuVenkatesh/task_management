<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillabale = ['name','guard_name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }



}
