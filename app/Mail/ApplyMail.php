<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $subject;

    public $email;

    public $message;

    public $procedure;

    public function __construct($email, $procedure, $message, $subject)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->procedure = $procedure;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $date = Carbon::now('Europe/Moscow')->format('d.m.Y H:i');
        $id = $this->procedure['id'];
        $subject = $this->subject;
        $title = $this->procedure['title'];
        $messages = $this->message;

        return $this->to($this->email)
            ->subject($subject)
            ->view('mail.apply.send', compact('date','id', 'title', 'messages'));

    }
}
