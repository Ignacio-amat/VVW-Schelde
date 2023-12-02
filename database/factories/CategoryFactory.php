<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
                'description' => $this->faker->sentence(),
                'name' => $this->randomCategory(),
                'image' => $this->randomImage(),
            ];
    }

    private function randomImage() {
        $images = [
            "/assets/icons/categories/restaurant.png",
            "/assets/icons/categories/employee.png",
            "/assets/icons/categories/repair.png",
            "/assets/icons/categories/family.png",
            "/assets/icons/categories/marina.png",
            "/assets/icons/categories/boat.png",
            "/assets/icons/categories/price.png",
            "/assets/icons/categories/food.png"
        ];
        return $images[$this->faker->numberBetween(0, 7)];
    }


    private function randomCategory(){
        $categories = [
            "Boat Care",
            "Docking",
            "Fueling",
            "Repairs",
            "Emergencies",
            "Security",
            "Rentals",
            "Lessons",
            "Events",
            "Supplies",
            "Waste Management",
            "Launching",
            "Cleaning",
            "Electronics",
            "Insurance",
            "Sales",
            "Upholstery",
            "Restaurant",
            "Water Sports",
            "Conservation"
        ];

        return $categories[$this->faker->numberBetween(0, count($categories)-1)];
    }
}
