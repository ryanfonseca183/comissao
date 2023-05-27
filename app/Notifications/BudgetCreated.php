<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class BudgetCreated extends Notification
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
                    ->subject('Orçamento Criado')
                    ->greeting('Olá, ' . Str::words($notifiable->name, 1, ''))
                    ->line('A indicação para a empresa '.$this->company->corporate_name.', sobre o serviço de '.$this->company->service->name.', foi analisada e acaba de ser orçada no sistema.')
                    ->line('Caso o orçamento seja aprovado, voce poderá ver os valores à receber de comissão no painel de controle.')
                    ->line('Para obter mais detalhes sobre a indicação, clique no botão abaixo.')
                    ->action('Ver indicação', route('indications.show', $this->company->id));
    }
}
