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
        // return (new MailMessage)
        //     ->subject('Error Occurred in ' . config('app.name'))
        //     ->line('An error has occurred:')
        //     ->line($this->exception->getMessage())
        //     ->line('File: ' . $this->exception->getFile())
        //     ->line('Line: ' . $this->exception->getLine())
        //     ->line('Stack Trace:')
        //     ->line($this->exception->getTraceAsString())
        //     ->line('Please address this issue promptly.');


        $guards = array_keys(config('auth.guards'));

        $user = null;

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                $user = auth()->guard($guard)->user();
                break;
            }
        }

            $routeName = request()->route() ? request()->route()->getName() : 'N/A';
            $apiEndpoint = request()->fullUrl();
            $requestMethod = request()->method();
            $userAgent = request()->header('User-Agent');
            $ipAddress = request()->ip();
            $currentTime = now()->toDateTimeString();

            $mailMessage = (new MailMessage)
                ->subject('Error Occurred in ' . config('app.name'))
                ->line('An error has occurred:')
                ->line($this->exception->getMessage())
                ->line('File: ' . $this->exception->getFile())
                ->line('Line: ' . $this->exception->getLine())
                // ->line('Stack Trace:')
                // ->line($this->exception->getTraceAsString())
                ->line('Route Name: ' . $routeName)
                ->line('Endpoint: ' . $apiEndpoint)
                ->line('Request Method: ' . $requestMethod)
                ->line('User Agent: ' . $userAgent)
                ->line('IP Address: ' . $ipAddress)
                ->line('Occurred At: ' . $currentTime);

            if ($user) {
                $mailMessage->line('User: ' . $user->name . ' (' . $user->email . ')' . ' (' . $user->id . ')' . ' (' . $user->phone . ')');
            }

            return $mailMessage->line('Please address this issue promptly.');

    }
}
