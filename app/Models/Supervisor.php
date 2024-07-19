<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'supervised_projects', 'supervisor_id', 'project_id');
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
