<?php

namespace Syntech\Notifier;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Debug\ExceptionHandler;
class LaravelErrorNotifierServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register any bindings or services
    }

    public function boot()
    {
        $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler')
        ->reportable(function (\Throwable $exception) {
            Log::channel('email')->error('An error occurred', ['exception' => $exception]);
        });

    $this->publishes([
        __DIR__ . '/../config/error-notifier.php' => config_path('error-notifier.php'),
    ], 'config');

    if ($this->app->runningInConsole()) {
        $this->commands([
            // Add any package commands here
        ]);

    }



        // Log::channel('email')->error('An error occurred', ['exception' => '$exception']);

        // $this->publishes([
        //     __DIR__ . '/../config/error-notifier.php' => config_path('error-notifier.php'),
        // ], 'config');

        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         // Add any package commands here
        //     ]);
        // }
    }
}
