<?php

namespace App\Notifications\Verify;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerify extends Notification
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
    return (new MailMessage)
    ->from(config('mail.from.address'), config('mail.from.name'))
    ->subject(__('Email verification'))
    ->view('auth.email.email-verify', ['info' => $this->info]);
  }
}
