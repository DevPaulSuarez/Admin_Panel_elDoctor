<table>
    <thead>
    <tr>
        <th>ASUNTO</th>
        <th>PACIENTE</th>
        <th>MEDICO</th>
        <th>FECHA</th>
        <th>HORA</th>
        <th>FECHA DE CREACIÓN</th>
        <th>TIPO REGISTRADOR</th>
        <th>NOMBRE REGISTRADOR</th>
    </tr>
    </thead>
    <tbody>
    @foreach($citas as $cita)
        <tr>
            <td>{{ $cita->title }}</td>
            <td>{{ $cita->paciente }}</td>
            <td>{{ $cita->medico }}</td>
            <td>{{ $cita->date_at }}</td>
            <td>{{ $cita->time_at }}</td>
            <td>{{ $cita->fecha_creacion }}</td>
            <td>{{ $cita->tipo_usuario }}</td>
            <td>{{ $cita->registrador_nombre }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
