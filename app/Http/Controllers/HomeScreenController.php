<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\CategoriesQuestions;
use App\Models\Category;
use App\Models\Question;
use App\Models\Visit;
use Brick\Math\Exception\DivisionByZeroException;
use DivisionByZeroError;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class HomeScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $latestAnswers = Visit::orderBy('created_at', 'ASC')->take(3)->get();
        $recentSurveyAnswers = [];
        foreach ($latestAnswers as $latestAnswer) {
            array_push($recentSurveyAnswers,$latestAnswer->created_at);
        }

        return view('home.index', [
            'categories' => $categories,
            'latest_answers' => array_reverse($recentSurveyAnswers)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $questions = $category->questions;
        return view('home.show', [
            'questions' => $questions,
            'categoryName' => $category->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('home.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete something
        return redirect('/');
    }


    public function getCategories()
    {
        return Category::all();
    }

    public function getCategory($id)
    {
        return Category::findOrFail($id);
    }

    public function getQuestionsInCategory($categoryID)
    {
        $category = Category::findOrFail($categoryID);
        $questions = $category->questions;
        return $questions;
    }

    /**
     * Gets averages of every category
     *
     * @return array containing category name and its average
     */
    public function getAverages() {
        $categories = Category::all();
        $averages = [];
        foreach ($categories as $category) {
            $answers = [];
            foreach ($category->questions as $question) {
                foreach ($question->answers as $answer) {
                    if (is_numeric($answer->text) && $answer !==null)
                    {
                        array_push($answers, $answer->text);
                    }
                }
            }

            $average = 0;
            $categoryName = '';
            try {
                $average = array_sum($answers) / count($answers);
                $categoryName = $category->name;
                array_push($averages, [
                    'category' => $categoryName,
                    'average' => $average
                ]);
            } catch (DivisionByZeroError $byZeroException) {
                continue;
            }
        }
        if (count($averages) == 0)
            return null;
        return $averages;
    }

}
