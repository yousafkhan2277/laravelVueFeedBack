<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Services\FeedbackService;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    private $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function submitFeedback(FeedbackRequest $request): JsonResponse
    {
        $this->feedbackService->submitFeedback($request->validated(), auth()->id());
        return response()->json(['message' => 'Feedback submitted successfully'], 201);
    }

    public function getFeedback(): JsonResponse
    {
        $feedback = $this->feedbackService->getFeedback();
        return response()->json($feedback);
    }
}
