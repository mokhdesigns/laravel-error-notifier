<?php

namespace SyntechNotifier\LaravelErrorNotifier\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Notification;
use YourVendor\LaravelErrorNotifier\Notifications\ErrorOccurred;

class CustomHandler extends AbstractProcessingHandler
{
    protected function write(array $record): void
    {
        Notification::route('mail', config('error-notifier.email'))
            ->notify(new ErrorOccurred($record['context']['exception']));
    }
}
