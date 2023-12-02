<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerChoice;
use App\Models\CategoriesQuestions;
use App\Models\Category;
use App\Models\CategoryContent;
use App\Models\ConditionalQuestion;
use App\Models\Question;
use App\Models\SurveyQuestion;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\AnswerChoiceController;
use function MongoDB\BSON\toJSON;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::all();
        $categories = Category::all();
        return view('questions.index', compact('questions', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all()->sortBy('text');
        return view('questions.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|string',
            'type' => 'required|in:Text,RadioBool,RadioGrade,Radio,Checkbox',
            'options' => 'required_if:type,Radio,Checkbox|array',
            'options.*' => 'string|min:1',
        ], [
            'options' => 'At least one option is required',
        ]);

        $question = new Question();
        $question->text = $validatedData['text'];
        $question->type = $validatedData['type'];
        $question->in_survey = false;
        $question->save();

        if ($question->type === 'RadioBool' || $question->type === 'RadioGrade') {
            $followUps = $request->input('followUps');
            if ($followUps) {
                $this->updateConditionals($question, $followUps);
            }
        }

        if ($question->type === 'Radio' || $question->type === 'Checkbox') {
            $options = $validatedData['options'];
            $this->updateAnswerChoices($question->id, $options);
        }
        return redirect(route('questions.index'))->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $excludedQuestions = [];
        $excludedQuestions[] = $question->id;
        $followUpQuestions = [];
        if ($question->type == 'RadioBool' || $question->type == 'RadioGrade') {
            $conditionals = ConditionalQuestion::where('question_id', $question->id)->get();
            foreach ($conditionals as $conditional) {
                $conQuestion = Question::findOrFail($conditional->conditional_question_id);
                $excludedQuestions[] = $conditional->conditional_question_id;
                $followUpQuestions[] = [
                    'question' => $conQuestion,
                    'condition' => $conditional->condition
                ];
            }
        }
        $searchableQuestions = Question::whereNotIn('id', $excludedQuestions)->get();

        return view('questions.edit', compact('question', 'searchableQuestions', 'followUpQuestions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validatedData = $request->validate([
            'text' => 'required|string',
            'type' => 'required|in:Text,RadioBool,RadioGrade,Radio,Checkbox',
            'options' => 'required_if:type,Radio,Checkbox|array',
            'options.*' => 'string|min:1',
        ], [
            'options' => 'At least one option is required',
        ]);

        $question->text = $request->input('text');
        $question->type = $request->input('type');
        $question->save();

        ConditionalQuestion::where('question_id', $question->id)->delete();
        if ($question->type === 'RadioBool' || $question->type === 'RadioGrade') {
            $followUps = $request->input('followUps');
            if ($followUps) {
                $this->updateConditionals($question, $followUps);
            }
        }

        if ($question->type === 'Radio' || $question->type === 'Checkbox') {
            $options = $request->input('options');
            $this->updateAnswerChoices($question->id, $options);
        }

        return redirect(route('questions.index'))->with('success', 'Question updated successfully.');

    }

    /**
     * Generates the conditional question entries in the table based on passed data
     */
    public function updateConditionals(Question $question, $followUps) {
        foreach ($followUps as $followUp) {
            $followUpQuestion = Question::findOrFail($followUp['questionId']);
            $followUpQuestion->in_survey = $question->in_survey;
            $conditionalQuestion = new ConditionalQuestion();
            $conditionalQuestion->question_id = $question->id;
            $conditionalQuestion->conditional_question_id = $followUp['questionId'];
            $conditionalQuestion->condition = $followUp['condition'];
            $conditionalQuestion->save();
        }
    }
    /**
     * Updates the answer options for question
     */
    public function updateAnswerChoices($questionId, $options)
    {
        // Delete existing answer choices for the question
        AnswerChoice::where('question_id', $questionId)->delete();

        // Create new answer choices from the options
        foreach ($options as $option) {
            $answerChoice = new AnswerChoice;
            $answerChoice->question_id = $questionId;
            $answerChoice->choice_text = $option;
            $answerChoice->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {

    }

    //API CALLS
    //-------------------
    /**
     * Handles api call
     * @return Question collection af all questions
     */
    public function getQuestions()
    {
        return Question::all()->toJson();
    }

    /**
     * gets question with the specified ID
     * @param $id
     * @return Question
     */
    public function getQuestion($id)
    {
        return Question::findOrFail($id);
    }

    /**
     * Get question with its answers
     *
     * @param $id
     * @return JSON file of questions with answers
     */
    public function getQuestionWithAnswers($id)
    {
        $questions = Question::findOrFail($id)->toJson();
        $answers = Answer::all()->where('question_id', 'IS', $id)->toJson();
            $questionsWithAnswersJson = json_encode(array_merge(json_decode($questions, true), json_decode($answers, true)), JSON_PRETTY_PRINT);
        return $questionsWithAnswersJson;
    }

    /**
     * Gets the answers to the question with the specified ID
     *
     * @param $questionID
     * @return array of answers in text form
     */
    public function getAnswersOfQuestion($questionID)
    {
        $answersAndDates = [];
        $question = Question::findOrFail($questionID);
        $answers = $question->answers;

        foreach ($answers as $answer) {
            array_push($answersAndDates, [
                'text' => $answer->text,
                'date' => strstr($answer->visit->created_at, ' ', true)
            ]);
        }

        return $answersAndDates;
    }

}
