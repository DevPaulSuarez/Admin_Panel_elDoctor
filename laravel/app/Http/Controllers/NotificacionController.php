<?php

namespace App\Http\Controllers;

use App\Mail\RecordatorioCitaReceived;
use App\Models\Reservacion;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;

class NotificacionController extends Controller
{
    public function sendingAppointmentReminderEmails()
    {
        $minute = 5;
        $reservaciones = Reservacion::select("reservation.time_at", "b.email as email_client", "b.name as name_client", "b.lastname as lastname_client", "b.celular_codigo_pais as celular_codigo_pais_cliente", "b.phone as telefono_cliente", "c.email as email_doctor", "c.name as name_doctor", "c.lastname as lastname_doctor", "c.celular_codigo_pais as celular_codigo_pais_doctor", "c.phone as telefono_doctor")
            ->join('pacient as b', 'reservation.pacient_id', '=', 'b.id')
            ->join('medic as c', 'reservation.medic_id', '=', 'c.id')
            ->where("reservation.status_id", "=", 1)
            ->where("reservation.date_at","=",date("Y-m-d"))
            ->where("reservation.time_at","=",date("H:i:00",strtotime(date("H:i:00"))+$minute*60))
            ->orderBy('reservation.time_at', 'asc')
            ->get();

        foreach ($reservaciones as $reservacion) {
            Mail::to($reservacion->email_client)->send(new RecordatorioCitaReceived($reservacion, $minute, 'client'));
            Mail::to($reservacion->email_doctor)->send(new RecordatorioCitaReceived($reservacion, $minute, 'doctor'));
            $client = new Client();
            $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
                'json' => [
                    'from' => '51959522200',
                    // 'from' => env('NUMERO_WHATSAPP'),
                    'to' => $reservacion->celular_codigo_pais_cliente . $reservacion->telefono_cliente,
                    'type' => 'text',
                    'body' => 'Buen día, falta 5 min para su cita, ingrese a la plataforma por favor https://eldoctor.pe/paciente/login, por favor espere en la sala del doctor en linea para que el médico lo pueda contactar.  Atte. El Doctor.'
                ]
            ]);
            $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
                'json' => [
                    'from' => '51959522200',
                    // 'from' => env('NUMERO_WHATSAPP'),
                    'to' => $reservacion->celular_codigo_pais_doctor . $reservacion->telefono_doctor,
                    'type' => 'text',
                    'body' => 'Buen día, falta 5 min para la cita, ingrese a la plataforma por favor https://eldoctor.pe/medico/login, Atte. El Doctor.'
                ]
            ]);
        }

        return 'Enviando correos de recordatorio de citas';
    }
}
