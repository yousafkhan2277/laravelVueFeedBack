<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function submitComment(CommentRequest $request, $feedbackId): JsonResponse
    {
        $this->commentService->submitComment($request->validated(), auth()->id(), $feedbackId);
        return response()->json(['message' => 'Comment submitted successfully'], 201);
    }

    public function getComments($feedbackId): JsonResponse
    {
        $comments = $this->commentService->getComments($feedbackId);
        return response()->json($comments);
    }

    public function getUsers(Request $request): JsonResponse
    {
        $query = $request->query('query');
        $users = $this->commentService->getUsers($query);
        return response()->json($users);
    }
}
