<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'title',
        'description',
        'quickAccess',
        'icon'
    ];
    public function questions(){
        return $this->belongsToMany(Question::class, 'categories_questions');
    }
}
