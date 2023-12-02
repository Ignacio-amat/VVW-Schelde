<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;


    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'answers');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function answerChoices()
    {
        return $this->hasMany(AnswerChoice::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'categories_questions');
    }

    public function averageOfAnswers() {
        $answers = $this->answers();
        dd($answers);
    }

    public function surveyQuestion()
    {
        return $this->hasOne(SurveyQuestion::class);
    }

    public function conditionalQuestions()
    {
        $this->hasMany(ConditionalQuestion::class, 'question_id');
    }

    public function isQuestionRequired($questionId)
    {
        $surveyQuestions = SurveyQuestion::all();
        foreach ($surveyQuestions as $surveyQuestion) {
            if ($questionId === $surveyQuestion->question_id && $surveyQuestion->is_required == 1) {
                print "Question " . $questionId . " is required";
                return true;
            }
        }
        return false;
    }
}
