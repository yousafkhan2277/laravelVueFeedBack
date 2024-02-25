<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Routes for feedback
    Route::post('/feedback', [FeedbackController::class, 'submitFeedback']);
    Route::get('/feedback', [FeedbackController::class, 'getFeedback']);

    // Routes for comments
    Route::post('/feedback/{feedbackId}/comments', [CommentController::class, 'submitComment']);
    Route::get('/feedback/{feedbackId}/comments', [CommentController::class, 'getComments']);
    Route::get('/users', [CommentController::class, 'getUsers']);
    Route::post('/feedback/{feedbackId}/comments/{commentId}/replies', [ReplyController::class,'submitReply']);

});

