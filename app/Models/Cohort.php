<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'faculty', 'trimester_code'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
