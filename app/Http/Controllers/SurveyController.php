<?php

namespace App\Http\Controllers;

use App\Models\ConditionalQuestion;
use App\Models\SurveyQuestion;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Question;
use App\Models\AnswerChoice;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionlist = Question::all()->sortBy('position');
        $answeroptions = AnswerChoice::all();
        $topiclist = SurveyQuestion::select('topic')->distinct()->get();
        $surveyquestions = SurveyQuestion::all();
        return view('survey.index', compact('questionlist', 'answeroptions', 'topiclist', 'surveyquestions'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = $this->surveyFormValidation();

        $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $questionlist = Question::all();
        $answeroptions = AnswerChoice::all();
        $visitObject = new Visit();
        $visitObject->key = 'abcde';
        $visitObject->ip  = '123.456.789.012';
        $visitObject->save();
        $visitID = $visitObject->id;
        foreach($questionlist as $question){
            if (SurveyQuestion::where('question_id', $question->id)->exists()){
                $AnswerEntry = new Answer();

                $questionID = $question->id;
                $questionType = $question->type;
                $questionText = $question->text;

                if ($questionType == 'Text'){
                    $questionIDTag = 'Text' . $questionID;
                    $reply = $request->$questionIDTag;

                    $AnswerEntry->visit_id = $visitID;
                    $AnswerEntry->question_id = $questionID;
                    $AnswerEntry->text = $reply;
                    $AnswerEntry->save();
                }

                else if ($questionType == 'Checkbox'){
                    $i = 0;
                    foreach ($answeroptions as $answeroption){
                        if ($answeroption->question_id == $questionID){
                            $AnswerEntry = new Answer();
                            $i++;
                            $questionIDTag = 'Checkbox-'. $questionID . '-' . $i;
                            $reply = $request->$questionIDTag;

                            $AnswerEntry->visit_id = $visitID;
                            $AnswerEntry->question_id = $questionID;
                            $AnswerEntry->text = $reply;
                            $AnswerEntry->save();
                        }
                    }
                }

                else if ($questionType == 'Radio'){
                    $i = 0;
                    $entered = false;
                    foreach ($answeroptions as $answeroption){
                        if ($answeroption->question_id == $questionID && $entered == false){
                            $i++;
                            $AnswerEntry = new Answer();
                            $answerIDTag = 'Radioinputanswer' . $i;
                            $questionIDTag = 'Radio' . $questionID;
                            $reply = $request->$questionIDTag;
                            $AnswerEntry->visit_id = $visitID;
                            $AnswerEntry->question_id = $questionID;
                            $AnswerEntry->text = $reply;
                            $AnswerEntry->save();
                            $entered = true;

                        }

                    }
                }

                else if ($questionType == 'RadioGrade'){
                    $AnswerEntry = new Answer();
                    $questionIDTag = 'Radio' . $questionID;
                    $reply = $request->$questionIDTag;

                    $AnswerEntry->visit_id = $visitID;
                    $AnswerEntry->question_id = $questionID;
                    $AnswerEntry->text = $reply;
                    $AnswerEntry->save();
                }

                else if ($questionType == 'RadioBool'){
                    $AnswerEntry = new Answer();
                    $questionIDTag = 'Radio' . $questionID;
                    $reply = $request->$questionIDTag;

                    $AnswerEntry->visit_id = $visitID;
                    $AnswerEntry->question_id = $questionID;
                    $AnswerEntry->text = $reply;
                    $AnswerEntry->save();
                }
            }

        }

//        dd ($request->all());
      return view('survey.completion');

    }


    /**
     * Returns the view where the users can create new topics and set the order of the questions,
     *
     * @return view
     */
    public function edit()
    {
        $topics = DB::table('survey_questions')
            ->orderBy('position')
            ->distinct()
            ->pluck('topic');

        $groupedQuestions = [];
        foreach ($topics as $topic) {
            // Retrieve the survey questions with the current topic
            $questions = DB::table('questions')
                ->join('survey_questions', 'questions.id', '=', 'survey_questions.question_id')
                ->where('survey_questions.topic', '=', $topic)
                ->orderBy('survey_questions.position')
                ->select('questions.*', 'survey_questions.is_Required')
                ->whereNotIn('questions.id', function ($query) {
                    $query->select('conditional_question_id')->from('conditional_questions');
                })
                ->get();

            $groupedQuestions[] = [
                'topic' => $topic,
                'questions' => $questions,
            ];
        }

        $unassignedQuestions = DB::table('questions')
            ->leftJoin('survey_questions', 'questions.id', '=', 'survey_questions.question_id')
            ->select('questions.*')
            ->whereNull('survey_questions.question_id')
            ->whereNotIn('questions.id', function ($query) {
                $query->select('conditional_question_id')->from('conditional_questions');
            })
            ->get();

        return view('survey.edit', compact('groupedQuestions', 'unassignedQuestions'));
    }

    /**
     * Updates the survey_questions table
     * @param Request $request
     * @return
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topics' => 'sometimes|array',
            'topics.*.title' => 'required|string|distinct',
            'topics.*.questions' => 'required|array|min:1',
            'topics.*.questions.*.id' => 'required|distinct|exists:questions,id',
            'topics.*.questions.*.content' => 'required|string',
            'topics.*.questions.*.is_required' => 'required|boolean',
        ], [
            'topics.*.title.required' => 'Topic name cannot be empty',
            'topics.*.title.distinct' => 'Topic names cannot repeat',
            'topics.*.questions.required' => 'Each topic must contain at least one question',
        ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();

            if (isset($failedRules['topics.questions.*.id']) ||
                isset($failedRules['topics.questions.*.content']) ||
                isset($failedRules['topics.questions.*.is_required'])
            ) {
                return redirect('/400');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $validatedData = $validator->validated();

        SurveyQuestion::truncate();
        DB::table('questions')->update(['in_survey' => false]);
        if (isset($validatedData['topics'])) {
            $topics = $validatedData['topics'];
            $this->setSurveyQuestions($topics);
        }
        return redirect(route('survey.edit'))->with('success', 'Survey arrangement updated successfully');
    }

    /**
     * Generates entries for the survey_questions table based on topics
     */
    public function setSurveyQuestions($topics) {
        $position = 0;

        foreach ($topics as $topic) {
            $title = $topic['title'];
            $questions = $topic['questions'];

            foreach ($questions as $question) {
                $newSurveyQuestion = new SurveyQuestion();
                $questionInSurvey = Question::findOrFail($question['id']);
                $questionInSurvey->in_survey = true;
                $questionInSurvey->save();
                $newSurveyQuestion->question_id = $question['id'];
                $newSurveyQuestion->is_required = $question['is_required'];
                $newSurveyQuestion->topic = $title;
                $newSurveyQuestion->position = $position;
                $newSurveyQuestion->save();
                $position += 1;
                $followingQuestions = ConditionalQuestion::where('question_id', $question['id'])->get();
                foreach ($followingQuestions as $followingQuestion) {
                    $fId = $followingQuestion->conditional_question_id;
                    $fQuestion = Question::findOrFail($fId);
                    $fQuestion->in_survey = true;
                    $fQuestion->save();
                    $surveyQuestion = new SurveyQuestion();
                    $surveyQuestion->question_id = $fId;
                    $surveyQuestion->topic = $title;
                    $surveyQuestion->position = $position;
                    $surveyQuestion->save();
                    $position += 1;
                }
            }
        }
    }

    public function getSurveyTopics(){
        return SurveyQuestion::all();
    }

    public function getConditionalQuestions(){
        return ConditionalQuestion::all();
    }

    public function getQuestionTypeById($questionId){
        $questions = Question::all();
        foreach ($questions as $question) {
            if($question->id == $questionId) {
                return $question->type;
            }
        }
        return null;
    }

    public function surveyFormValidation(){
        $questions = SurveyQuestion::where('is_Required', 1)->get();
        $rules = [];

        foreach ($questions as $question) {
            if ($this->getQuestionTypeById($question->question_id) === 'Text'){
                $rules['Text' . $question->question_id] = 'required';
            }
            else if ($this->getQuestionTypeById($question->question_id) === 'Checkbox'){
                $rules['Checkbox-' . $question->question_id . '-*'] = 'required';
            }
            else if ($this->getQuestionTypeById($question->question_id) === 'Radio'){
                $rules['Radio' . $question->question_id] = 'required';
            }
            else if ($this->getQuestionTypeById($question->question_id) === 'RadioGrade'){
                $rules['Radio' . $question->question_id] = 'required';
            }else if ($this->getQuestionTypeById($question->question_id) === 'RadioBool'){
                $rules['Radio' . $question->question_id] = 'required';
            }
        }
        return $rules;
    }

}


