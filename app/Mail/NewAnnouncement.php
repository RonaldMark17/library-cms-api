<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Announcement;

class NewAnnouncement extends Mailable
{
    use Queueable, SerializesModels;

    public $announcement;
    public $unsubscribeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Announcement $announcement, $unsubscribeUrl)
    {
        $this->announcement = $announcement;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Library Announcement')
                    ->view('emails.new-announcement');
    }
}
