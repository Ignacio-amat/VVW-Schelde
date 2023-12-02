<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Sodium\add;

class SurveyQuestion extends Model
{
    use HasFactory;

    public function question()
    {
        $this->belongsTo(Question::class);
    }

    protected $fillable = [
        'is_Required',
    ];
}
