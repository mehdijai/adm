<?php

namespace App\Notifications\User;

use App\Models\Setting;
use App\Mail\AdmPremium;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewSubs extends Notification implements ShouldQueue
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
    public function toMail($subs)
    {   
        $cnt = Setting::getContact(['whatsapp_link', 'email_premium']);

        $data = [
            'plan_name' => $subs->plan()->get()[0]->name,
            'periode' => $subs->periode,
            'vehs_count' => count(json_decode($subs->vehicules_ids)),
            'wa' => $cnt['whatsapp_link'],
            'email' => 'mailto:' . $cnt['email_premium'],
        ];

        return (new AdmPremium($data))
                    ->subject('Inscription ADM Premium')
                    ->to($subs->user()->get()[0]->email);
    }

    public function toDatabase($subs)
    {
        return [
            'state' => 'new',
            'user_id' => $subs->user_id,
            'plan' => $subs->plan()->get()[0]->name,
            'periode' => $subs->periode,
            'montant' => $subs->montant,
            'vehs_count' => count(json_decode($subs->vehicules_ids))
        ];
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
