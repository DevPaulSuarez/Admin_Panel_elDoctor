<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EditMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Horario Actualizado';

    public $msg;

    public $time;
    
    public $type_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg, $type_user)
    {
        $this->msg = $msg;
        $this->type_user = $type_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type_user == 'client') {
            return $this->view('email.message-received-client-edit');
        }
        if($this->type_user == 'doctor') {
            return $this->view('email.message-received-doctor-edit');
        }
    }
}
