<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Services\ReplyService;
use Illuminate\Http\JsonResponse;

class ReplyController extends Controller
{
    private $replyService;

    public function __construct(ReplyService $replyService)
    {
        $this->replyService = $replyService;
    }

    public function submitReply(ReplyRequest $request, $feedbackId, $commentId): JsonResponse
    {
        $this->replyService->submitReply($request->validated(), auth()->id(), $commentId);
        return response()->json(['message' => 'Reply submitted successfully']);
    }
}

