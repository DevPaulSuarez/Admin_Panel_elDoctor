<table>
    <thead>
    <tr>
        <th>APELLIDOS</th>
        <th>NOMBRES</th>
        <th>DIRECCIÓN</th>
        <th>EMAIL</th>
        <th>TELÉFONO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pacientes as $paciente)
        <tr>
            <td>{{ $paciente->lastname }}</td>
            <td>{{ $paciente->name }}</td>
            <td>{{ $paciente->address }}</td>
            <td>{{ $paciente->email }}</td>
            <td>{{ $paciente->phone }}</td>
        </tr>
    @endforeach
    </tbody>
</table>