<?php
namespace Syntech\Notifier\Logging;

use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Notification;
use Syntech\Notifier\Notifications\ErrorOccurred;

class CustomHandler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        try {

            $this->sendEmail($record);

        } catch (\Exception $e) {

            $this->logError($e);
        }

    }

    public function __invoke(array $config): Logger
    {
        $logger = new Logger('custom');
        $logger->pushHandler(new self());

        return $logger;
    }

    private function sendEmail(LogRecord $record): void
    {
        Notification::route('mail', config('error-notifier.email'))
        ->notify(new ErrorOccurred($record['context']['exception']));
    }

    private function logError(\Exception $e): void
    {
         Log::error($e->getMessage());

    }
}
