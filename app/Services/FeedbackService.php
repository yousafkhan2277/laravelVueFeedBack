<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Contracts\Pagination\Paginator;

class FeedbackService
{
    public function submitFeedback(array $data, int $userId): void
    {
        Feedback::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'user_id' => $userId,
        ]);
    }

    public function getFeedback(): Paginator
    {
        return Feedback::with(['user', 'comments.user', 'comments.replies.user'])->latest()->paginate(10);
    }
}
