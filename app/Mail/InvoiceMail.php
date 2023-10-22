<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $attachmentPath;

    public function __construct($attachmentPath)
    {
        $this->attachmentPath = $attachmentPath;
    }

    public function build()
    {
        return $this
            ->view('mails.invoice_mail')
            ->attach($this->attachmentPath, [
                'as' => 'faktura.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
