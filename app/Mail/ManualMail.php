<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManualMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $data;
    public $subject;

    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->subject
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'mails.markdownmail',
            with: [
                'data' => $this->data,
            ]
        );
    }
}
