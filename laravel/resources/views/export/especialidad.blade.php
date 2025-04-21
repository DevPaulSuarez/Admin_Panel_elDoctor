<table>
    <thead>
    <tr>
        <th>Nombre</th>
    </tr>
    </thead>
    <tbody>
    @foreach($especialidades as $especialidad)
        <tr>
            <td>{{ $especialidad->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
