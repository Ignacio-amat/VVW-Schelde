<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();

        return [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('password'),
            'profile_picture' => $this->faker->imageUrl(),
            'profile_picture_path' => 'storage/default.jpg', // Assuming the default profile picture is stored in the "storage" directory
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
