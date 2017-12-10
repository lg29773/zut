<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class simple extends Mailable
{
    use Queueable, SerializesModels;
    public $tresc,$email,$tytul;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tresc,$email,$tytul)
    {
        $this->tresc = $tresc;
        $this->email = $email;
        $this->tytul = $tytul;

    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $address = 'grzegorz@luptowski.pl';
        $name = 'Grzegorz Luptowski';
        $subject = $this->tytul;

        return $this->view('emails.hello')
            ->from($address, $name)
            ->subject($subject)->with($this->tresc);

    }
}
