<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\Comment;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all feedback items
        $feedbackItems = Feedback::all();
        foreach ($feedbackItems as $feedback) {
            // Create a comment for each feedback item
            $user = User::inRandomOrder()->first();
            $commentContent = 'This is a comment mentioning @' . $user->name;
            $feedback->comments()->create([
                'user_id' => $user->id,
                'content' => $commentContent
            ]);
        }
    }
}
