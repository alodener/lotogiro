<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GameProcessedNotification extends Notification
{
    use Queueable;

    public $user;

    public $bet;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $bet)
    {
        $this->user = $user;

        $this->bet = $bet;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // 
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
            'title' => 'Sua aposta #' . $this->bet->id . ' foi processada!',
            'description' => '',
            'url' => route('admin.bets.validate-games.edit', ['validate_game' => $this->bet->id]),
        ];
    }
}
