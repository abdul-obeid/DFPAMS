<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'faculty'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
