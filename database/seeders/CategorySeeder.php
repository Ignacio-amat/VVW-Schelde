<?php

namespace Database\Seeders;

use App\Models\CategoriesQuestions;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->count(10)->create();
        $categories = Category::all();
        foreach ($categories as $category) {
            $questions = Question::all()->random(7);
            foreach ($questions as $question) {
                $category->questions()->attach($question);
            }
        }
    }
}
