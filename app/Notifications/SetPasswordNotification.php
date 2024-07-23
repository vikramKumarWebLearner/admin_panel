<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetPasswordNotification extends Notification
{
    use Queueable;

    protected $setPasswordToken;

    public function __construct($setPasswordToken)
    {
        $this->setPasswordToken = $setPasswordToken;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $setPasswordUrl = url('/set-password/' . $this->setPasswordToken);

        return (new MailMessage)
            ->subject('Set Password Notification')
            ->line('You have been requested to set a password for your account.')
            ->line('Please click the button below to set your password.')
            ->action('Set Password', $setPasswordUrl)
            ->line('If you did not request this, no further action is required.');
    }
}