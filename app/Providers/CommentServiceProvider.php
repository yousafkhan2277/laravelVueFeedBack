<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CommentService;

class CommentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CommentService::class, function ($app) {
            return new CommentService();
        });
    }
}

