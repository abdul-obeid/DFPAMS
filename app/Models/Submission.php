<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    public function document()
    {
        return $this->hasOne(Document::class);
    }

    public function event()
    {

        return $this->hasOne(Event::class);
    }
}
