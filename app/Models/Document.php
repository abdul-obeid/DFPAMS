<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function meetingLog()
    {
        return $this->belongsTo(MeetingLog::class);
    }
}
