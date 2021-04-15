<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;  // Para poder incluir HTML en los e-mails

class SignupActivate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $url = url('/api/auth/signup/activate/'.$notifiable->activation_token);
        return (new MailMessage)
            ->subject('Confirma el teu compte')
            ->greeting('Hola')
            ->line('Benvingut a la Borsa de treball IES Jaume I!')
            ->line('Abans de continuar, has d\'activar el teu compte per poder iniciar sessió.')
            ->action('Activa el teu compte', url($url))
            ->line(new HtmlString('ATENCIÓ: en activar el teu compte estas acceptant la <a href="https://borsatreball.cipfpbatoi.es/privacitat">Política de privacitat</a> de la Borsa de treball i donant la teua conformitat a que el CIP FP Batoi realitze el tractament de les teues dades personals segons els terminis i condicions allí indicades.'))
            ->line('Moltes gràcies per utilitzar la nostra aplicació!');
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
