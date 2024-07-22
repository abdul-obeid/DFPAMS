<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'mmu_student_id',
        'cohort_id',
        'specialization',
    ];

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function project()
    {
        return $this->belongsToMany(Project::class, 'project_students', 'student_id', 'project_id');
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
