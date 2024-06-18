<?php

namespace Syntech\Notifier\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ErrorOccurred extends Notification
{
    use Queueable;

    protected $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Error Occurred in ' . config('app.name'))
            ->line('An error has occurred:')
            ->line($this->exception->getMessage())
            ->line('File: ' . $this->exception->getFile())
            ->line('Line: ' . $this->exception->getLine())
            ->line('Stack Trace:')
            ->line($this->exception->getTraceAsString())
            ->line('Please address this issue promptly.');
    }
}
