<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_mmu_id',
        'app_or_research',
        'title',
        'specialization',
        'is_group_project',
        'cohort_id',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'project_students', 'project_id', 'student_id');
    }

    public function supervisor()
    {
        return $this->belongsToMany(Supervisor::class, 'supervised_projects', 'project_id', 'supervisor_id');
    }

    public function meetingLogs()
    {
        return $this->hasMany(MeetingLog::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
