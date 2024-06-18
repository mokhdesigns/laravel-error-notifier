<?php
namespace Syntech\Notifier\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Notification;
use Syntech\Notifier\Notifications\ErrorOccurred;

class CustomHandler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        Notification::route('mail', config('error-notifier.email'))
        ->notify(new ErrorOccurred($record['context']['exception']));
    }

    public function __invoke(array $config): Logger
    {
        $logger = new Logger('custom');
        $logger->pushHandler(new self());

        return $logger;
    }
}
