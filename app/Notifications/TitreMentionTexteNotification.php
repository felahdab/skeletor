<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class TitreMentionTexteNotification extends Notification // implements ShouldQueue
{
    use Queueable;

    public $titre = "";
    public $texte = "";
    public $mention="";

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    public function withTitre($title="")
    {
        $this->titre=$title;
        return $this;
    }

    public function withTexte($texte="")
    {
        $this->texte=$texte;
        return $this;
    }

    public function withMention($mention="")
    {
        $this->mention=$mention;
        return $this;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'titre' => $this->titre,
            'texte' => $this->texte,
            'mention' => $this->mention,
            'gdh' => Carbon::now()
        ];
    }
}
