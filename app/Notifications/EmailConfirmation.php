<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailConfirmation extends Notification
{
    use Queueable;
    protected $email_token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email_token = '')
    {
        $this->email_token = $email_token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = $this->email_token ? $this->email_token : Auth::user()->email_token;
        return (new MailMessage)
            ->subject(env('APP_NAME') . ' Email Verification')
            ->line('Please click the button below to verify ' . env('APP_NAME') . ' email address.')
            ->action('Verify', route('look.verify.email', $token));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
