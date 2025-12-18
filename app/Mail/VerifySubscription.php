<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifySubscription extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationUrl;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($verificationUrl, $email)
    {
        $this->verificationUrl = $verificationUrl;
        $this->email = $email;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verify Your Subscription')
                    ->view('emails.verify-subscription');
    }
}
