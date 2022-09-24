<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $dataEmail;
    public $subject;
    public $markdown;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataEmail, $subject, $markdown)
    {
        $this->dataEmail = $dataEmail;
        $this->subject = $subject;
        $this->markdown = $markdown;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->markdown($this->markdown);
    }
}
