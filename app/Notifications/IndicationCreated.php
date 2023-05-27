<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class IndicationCreated extends Notification
{
    use Queueable;

    private $company;
    /**
     * Create a new notification instance.
     */
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Indicação Recebida')
                    ->greeting('Olá, ' . Str::words($notifiable->name, 1, ''))
                    ->line('Uma indicação acaba de ser feita no sistema para a empresa '. $this->company->corporate_name .' e espera pela criação de um orçamento.')
                    ->line('Não deixe o cliente esperando. Clique no botão abaixo para obter mais informações e entre em contato com a empresa.')
                    ->action('Criar Orçamento', route('admin.indications.budget.create', $this->company->id));
    }
}
