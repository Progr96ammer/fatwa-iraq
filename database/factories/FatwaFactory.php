<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fatwa>
 */
class FatwaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'user_id' => 1, // سيتم تحديثه في Seeder
        'sheikh_id' => null,
        'question' => $this->faker->sentence,
        'answer' => null,
        'status' => 'pending', // or 'answered'
    ];
    }
}
