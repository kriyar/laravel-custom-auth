<?php

namespace App\Notifications\Verify;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\NexmoMessage;

class PhoneVerify extends Notification
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
        return ['nexmo'];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        $sms_content = $this->info->code . ' ' . __('is your phone verification code. Please use it within 15 minutes. Thank you!');
        return (new NexmoMessage)
                    ->content($sms_content)
                    ->unicode();
    }
}
