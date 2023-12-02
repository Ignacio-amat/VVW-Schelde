<?php

namespace App\Http\Controllers;

use App\Models\AnswerChoice;
use Illuminate\Http\Request;

class AnswerChoiceController extends Controller
{
    public function getAnswerChoices()
    {
        return AnswerChoice::all();
    }
}
