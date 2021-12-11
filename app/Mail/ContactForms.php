<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForms extends Mailable implements ShouldQueue
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

    public function __construct($request)
    {
        $this->from_name = $request['name'];
        $this->from_email = $request['email'];
        $this->message = $request['message'];
        $this->subject = $request['subject'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ADM: Contact form')->markdown('mails.contact-form');
    }
}
