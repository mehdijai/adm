<?php

namespace App\Notifications\User;

use App\Mail\SubExpired as SubExpiredMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubExpired extends Notification implements ShouldQueue
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
        $data = [
            'plan_name' => $notifiable->plan()->get()[0]->name,
        ];

        return (new SubExpiredMail($data))
                    ->subject('ADM Premium expiré!')
                    ->to($notifiable->user()->get()[0]->email);
    }

    public function toDatabase($subs)
    {
        return [
            'state' => 'expired',
            'plan' => $subs->plan()->get()[0]->name,
            'periode' => $subs->periode,
            'montant' => $subs->montant,
            'vehs_count' => count(json_decode($subs->vehicules_ids)),
            'exp_date' => $subs->expiration_date,
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
