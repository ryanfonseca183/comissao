<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetPassword extends Notification
{
    use Queueable;

    private string $url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
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
            ->greeting('Olá')
            ->subject(config('app.name'). ' - Finalizar Cadastro')
            ->line('Você está recebendo esta notificação porque uma conta com este e-mail foi criada. Para obter acesso, clique no botão abaixo e cadastre a senha.')
            ->action('Cadastrar Senha', $this->url)
            ->line('O link de cadastro irá expirar em 24 horas.');
    }
}
