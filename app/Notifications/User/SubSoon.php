<?php

namespace App\Notifications\User;

use Carbon\Carbon;
use App\Mail\SubSoon as SubSoonMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubSoon extends Notification implements ShouldQueue
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $now = Carbon::now();
        $expirationDate = Carbon::parse($notifiable->activation_date)->addDays($notifiable->periode);
        $diff = $expirationDate->diffInDays($now);

        $data = [
            'plan_name' => $notifiable->plan()->get()[0]->name,
            'remain' => $diff,
        ];

        return (new SubSoonMail($data))
                    ->subject('ADM Premium va bientôt expirer!')
                    ->to($notifiable->user()->get()[0]->email);
    }

    public function toDatabase($notifiable)
    {
        return [
            'state' => 'soon',
            'user_id' => $notifiable->user_id,
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
