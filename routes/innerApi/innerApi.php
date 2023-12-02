<?php

use App\Http\Controllers\AnswerChoiceController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeScreenController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AnswerController;


Route::get('/questions/all', [QuestionController::class, 'getQuestions']);
Route::get('/questions/{id}', [QuestionController::class, 'getQuestion']);
Route::get('/question-with-answers/{id}', [QuestionController::class, 'getQuestionWithAnswers']);
Route::get('/visit/{categoryID}', [HomeScreenController::class, 'getDates']);

Route::get('/answers/{questionID}', [QuestionController::class, 'getAnswersOfQuestion']);
Route::get('/answers/all', [AnswerController::class, 'getAnswers']);

Route::get('/categories/all', [HomeScreenController::class,'getCategories']);
Route::get('/categories/get-averages', [HomeScreenController::class, 'getAverages']);
Route::get('/categories/{id}', [HomeScreenController::class,'getCategory']);
Route::get('/categories/get-categories-questions/{category_id}', [HomeScreenController::class,'getQuestionsInCategory']);
Route::get('/categories/get-category-data/{category_id}', [CategoryController::class,'getCategoryData']);

Route::get('/answer_choices/all', [AnswerChoiceController::class, 'getAnswerChoices']);

Route::get('/survey_questions/all', [SurveyController::class, 'getSurveyTopics']);

Route::get('/conditional_questions/all', [SurveyController::class, 'getConditionalQuestions']);

