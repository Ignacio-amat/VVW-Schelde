<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visits = Visit::all('id');
        $questions = Question::all('id');
        foreach ($visits as $visit_id) {
            foreach ($questions as $question_id) {
                Answer::factory()->create(['visit_id' => $visit_id, 'question_id' => $question_id]);
            }
        }
    }
}
