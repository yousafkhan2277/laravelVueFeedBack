<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ReplyService;

class ReplyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReplyService::class, function ($app) {
            return new ReplyService();
        });
    }
}

