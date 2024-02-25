<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\User;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create 10 feedback items
        Feedback::factory()->count(10)->create()->each(function ($feedback) {
            // For each feedback item, associate a comment
            $user = User::inRandomOrder()->first();
            $commentContent = 'This is a comment mentioning @' . $user->username;
            $feedback->comments()->create([
                'user_id' => $user->id,
                'content' => $commentContent
            ]);
        });
    }
}
