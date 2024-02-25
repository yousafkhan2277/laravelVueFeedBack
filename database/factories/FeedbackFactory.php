<?php

namespace Database\Factories;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Feedback::class;
    public function definition(): array
    {
               
            return [
                'user_id' => User::factory(),
                'title' => $this->faker->sentence,
                'description' => $this->faker->paragraph,
                'category' => $this->faker->randomElement(['bug', 'feature', 'improvement']),
                
                
            ];
     
    }
}
