<table>
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Médico</th>
        <th>Paciente</th>
        <th>Puntuacion del servicio de la plataforma</th>
        <th>Sugerencia de la plataforma</th>
        <th>Puntuacion de la atencion del medico</th>
        <th>Opinión al medico</th>
        <th>Intentos de conexión</th>
        <th>Tiempo de conexión</th>
    </tr>
    </thead>
    <tbody>
    @foreach($encuestas as $encuesta)
        <tr>
            <td>{{ $encuesta->fecha }}</td>
            <td>{{ $encuesta->medico }}</td>
            <td>{{ $encuesta->paciente }}</td>
            <td>{{ $encuesta->puntuacion_servicio_plataforma }}</td>
            <td>{{ $encuesta->sugerencia_plataforma }}</td>
            <td>{{ $encuesta->puntuacion_atencion_medico }}</td>
            <td>{{ $encuesta->opinion_medico }}</td>
            <td>{{ $encuesta->times_video_connected }}</td>
            <td>{{ $encuesta->time_video_connected }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
