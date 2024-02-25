<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class CommentService
{
    public function submitComment(array $data, int $userId, int $feedbackId): void
    {
        Comment::create([
            'content' => $data['content'],
            'user_id' => $userId,
            'feedback_id' => $feedbackId,
        ]);
    }

    public function getComments(int $feedbackId): Paginator
    {
        return Comment::with('user')->where('feedback_id', $feedbackId)->paginate(10);
    }

    public function getUsers(string $query): Collection
    {
        return User::where('name', 'like', '%' . $query . '%')->get();
    }
}
