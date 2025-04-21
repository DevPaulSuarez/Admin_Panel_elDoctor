<table>
    <thead>
    <tr>
        <th>PACIENTE</th>
        @for ($i = 0; $i < $parametros->maxMedicos; $i++)
        <th>MEDICO {{ $i + 1 }}</th>
        @endfor
        @for ($i = 0; $i < $parametros->maxFechas; $i++)
        <th>FECHA {{ $i + 1 }}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach($monitoreosPaciente as $monitoreoPaciente)
        <tr>
            <td>{{ $monitoreoPaciente->paciente }}</td>
            @foreach ($monitoreoPaciente->medicos as $medico)
            <td>{{ $medico->nombre }}</td>
            @endforeach
            @foreach ($monitoreoPaciente->fechas as $fecha)
            <td>{{ $fecha }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>