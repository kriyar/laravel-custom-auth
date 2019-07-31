<?php

namespace App\Notifications\Password;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class PassRequestReset extends Notification
{
    use Queueable;

    private $info;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (config('support.nexmo_sms_enabled') and !empty($this->info->phone_number)) {
          return ['nexmo'];
        } else {
          return ['mail'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject(__('Request password reset'))
            ->view('auth.email.password-request', ['info' => $this->info]);
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        $sms_content = $this->info->code . ' ' . __('is your verification code to reset password. Please use it within 15 minutes. Thank you!');
        return (new NexmoMessage)
                    ->content($sms_content)
                    ->unicode();
    }
}
