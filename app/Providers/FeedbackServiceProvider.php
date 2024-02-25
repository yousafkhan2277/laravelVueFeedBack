<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FeedbackService;

class FeedbackServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(FeedbackService::class, function ($app) {
            return new FeedbackService();
        });
    }
}

