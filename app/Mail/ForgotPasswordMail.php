<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tokenData;

    public function __construct($user, $tokenData)
    {
        $this->user = $user;
        $this->tokenData  = $tokenData;
    }



    public function build()
    {
        return $this->subject('Pasword reset')
            ->view('emails.password-reset');
    }
}
