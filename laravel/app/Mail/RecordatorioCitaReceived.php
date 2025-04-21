<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioCitaReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Urgente - Recordatorio de cita';

    public $msg;

    public $time;

    public $type_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg, $time, $type_user)
    {
        $this->msg = $msg;
        $this->time = $time;
        $this->type_user = $type_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type_user == 'client') {
            return $this->view('email.mr-recordatorio-cita-cliente');
        }
        if ($this->type_user == 'doctor') {
            return $this->view('email.mr-recordatorio-cita-doctor');
        }
    }
}
