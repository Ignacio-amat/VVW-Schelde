<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeScreenController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuickAccessSelectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//drop pages in when we need to login to access

//this routes server the purpose of having 2 step form
//->name function gives it name so that we can call it using route function
//-------
//-------

// public survey completetion
Route::get('/survey/completion', [SurveyController::class, 'completion']);
Route::resource('/survey', SurveyController::class)->only(['index', 'store'])->names([
    'index' => 'survey.index',
    'store' => 'survey.store',
]);

Auth::routes();

// Require login for all routes except the survey
Route::middleware(['auth'])->group(function () {
    Route::post('/categories/create-two', [CategoryController::class, 'createTwo'])->name('categories.create-two');
  
    // Question routes
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}/update', [QuestionController::class, 'update'])->name('questions.update');
    Route::resource('/questions', QuestionController::class)->except(['store', 'update']);

    // Home screen routes
    Route::resource('/', HomeScreenController::class);
    Route::resource('/categories', CategoryController::class);

    // Quick access selection routes
    Route::resource('/quick-access-selection', QuickAccessSelectionController::class);
    Route::resource('/users', UserController::class);
    Route::post('/categories/create-two', [CategoryController::class, 'createTwo'])->name('categories.create-two');
    Route::put('/categories/{category}/edit-two', [CategoryController::class, 'editTwo'])->name('categories.edit-two');

      //Routes for survey manipulation and access
    Route::get('/survey/edit', [SurveyController::class, 'edit'])->name('survey.edit');
    Route::put('/survey/update', [SurveyController::class, 'update'])->name('survey.update');
    //-------
  
    Route::post('/categories/{id}/delete', [CategoryController::class, 'delete']);
    Route::get('/{id}', [HomeScreenController::class, 'show']);
  

});
