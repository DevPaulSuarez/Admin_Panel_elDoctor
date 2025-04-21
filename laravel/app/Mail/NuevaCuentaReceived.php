<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaCuentaReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Nueva Cuenta';

    public $msg;

    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg, $password)
    {
        $this->msg = $msg;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.message-nueva-cuenta');
    }
}
