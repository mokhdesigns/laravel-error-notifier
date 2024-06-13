<?php

namespace SyntechNotifier\LaravelErrorNotifier;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class LaravelErrorNotifierServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register any bindings or services
    }

    public function boot()
    {
        Log::channel('email')->error('An error occurred', ['exception' => $exception]);

        $this->publishes([
            __DIR__ . '/../config/error-notifier.php' => config_path('error-notifier.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                // Add any package commands here
            ]);
        }
    }
}
