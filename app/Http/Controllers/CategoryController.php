<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\CategoriesQuestions;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function SebastianBergmann\CodeCoverage\TestFixture\g;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('categories.create');
    }

    //this will store data that were filled in form number 1 into the session
    //so that those data can be retrieved in step two from
    public function createTwo(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $request->session()->put('name', $request->input('name'));
        $request->session()->put('description', $request->input('description'));
        $request->session()->put('image', $request->input('image'));

        $name = $request->input('name');
        $image = $request->input('image');
        $questions = Question::all();

        return view('categories.create-two', compact('questions', 'name', 'image'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $questions = $request->get('categoryQuestions');
        $category = new Category();
        $category->name = $request->session()->get('name');
        $category->description = $request->session()->get('description');
        $category->image = $request->session()->get('image');
        $category->save();
        if ($questions) {
            foreach ($questions as $question) {
                $category->questions()->attach($question);
            }
        }

        $request->session()->forget('name');
        $request->session()->forget('description');
        $request->session()->forget('image');

        flash()->addSuccess('New category has been added.');
        return redirect(route('categories.index'));
    }
    /**
     * Show the form for editing the category.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Edit the list of question inside the category
     */
    public function editTwo(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $request->session()->put('name', $request->input('name'));
        $request->session()->put('description', $request->input('description'));
        $request->session()->put('image', $request->input('image'));

        $name = $request->input('name');
        $image = $request->input('image');

        $categoryQuestions = $category->questions;
        $categoryId = $category->id;
        $otherQuestions = Question::whereDoesntHave('categories', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->get();

        return view('categories.edit-two', compact('category', 'categoryQuestions', 'otherQuestions', 'name', 'image'));

    }

    public function update(Request $request, Category $category) {
        $questions = $request->get('categoryQuestions');
        $category->name = $request->session()->get('name');
        $category->description = $request->session()->get('description');
        $category->image = $request->session()->get('image');
        $category->save();

        $category->questions()->detach();
        if ($questions) {
            foreach ($questions as $question) {
                $category->questions()->attach($question);
            }
        }

        $request->session()->forget('name');
        $request->session()->forget('description');
        $request->session()->forget('image');

        flash()->addSuccess('Your changes have been added.');
        return redirect(route('categories.index'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect('/categories/');
    }


    public function getAnswerData($idOfQuestion)
    {
        $answersAndDates = [];
        $question = Question::findOrFail($idOfQuestion);
        $answers = $question->answers;

        foreach ($answers as $answer) {
            array_push($answersAndDates, [
                'text' => $answer->text,
                'date' => strstr($answer->visit->created_at, ' ', true)
            ]);
        }

        return $answersAndDates;
    }

    public function getCategoryData($catID) {
        $category = Category::findOrFail($catID);

        $questionData = [];
        foreach ($category->questions as $question) {
            if($question !== null){
                array_push($questionData, [
                    'title' => $question->text,
                    'type' => $question->type,
                    'answers' => $this->getAnswerData($question->id)
                ]);
            }
        }
        $categoryData = [
            'name' => $category->name,
            'description' => $category->description,
            'questions' => $questionData
        ];
        return $categoryData;
    }
}
