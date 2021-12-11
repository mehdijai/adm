<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportForms extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $from_name;
    public $from_email;
    public $message;
    public $subject;
    public $ticket_id;

    public function __construct($request)
    {
        $this->from_name = $request['from_name'];
        $this->from_email = $request['from_email'];
        $this->message = $request['message'];
        $this->subject = $request['subject'];
        $this->ticket_id = $request['ticket_id'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Support: ' . $this->subject)->markdown('mails.support-form');
    }
}
