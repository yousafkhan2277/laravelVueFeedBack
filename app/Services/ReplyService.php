<?php 

namespace App\Services;

use App\Models\Comment;
use App\Models\Reply;

class ReplyService
{
    public function submitReply(array $data, int $userId, int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        $reply = new Reply();
        $reply->content = $data['content'];
        $reply->user_id = $userId;
        $comment->replies()->save($reply);
    }
}
