<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    public function meetingLog()
    {
        return $this->hasOne(MeetingLog::class);
    }

    public function document()
    {
        return $this->hasOne(Document::class);
    }
}
