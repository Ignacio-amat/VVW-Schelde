<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;


    public function questions()
    {
        return $this->belongsToMany(Question::class, 'answers');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
