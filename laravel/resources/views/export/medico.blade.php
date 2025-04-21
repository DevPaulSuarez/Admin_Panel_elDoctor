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
    @foreach($medicos as $medico)
        <tr>
            <td>{{ $medico->apellidos }}</td>
            <td>{{ $medico->nombres }}</td>
            <td>{{ $medico->direccion }}</td>
            <td>{{ $medico->email }}</td>
            <td>{{ $medico->telefono }}</td>
        </tr>
    @endforeach
    </tbody>
</table>