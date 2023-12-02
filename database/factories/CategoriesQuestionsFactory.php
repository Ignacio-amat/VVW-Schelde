<?php

namespace Database\Factories;

use App\Models\CategoriesQuestions;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CategoriesQuestions>
 */
class CategoriesQuestionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::all()->random()->id,
            'question_id' => Question::all()->random()->id,
        ];
    }
}
