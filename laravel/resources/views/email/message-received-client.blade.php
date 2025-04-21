<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor en línea</title>
</head>
<body>
    <div>
        <h2>MODALIDAD: {{ $msg->modalidad }}</h2>
        <h3>ESPECIALIDAD: {{ $msg->especialidad }}</h3>
        <h3>MÉDICO: {{ $msg->medico_nombre }}</h3>
        <h3>FECHA: {{ $msg->fecha }}</h3>
        <h3>HORA: {{ $msg->hora }}</h3>
        <h3>MONTO: {{ $msg->monto }}</h3>
        <p>EL INGRESO A LA SALA SERÁ A LA HORA DE SU CITA.</p>
        <p>Ingrese a la plataforma <a style="text-decoration: underline; font-weight: bold" href="https://doctorenlinea.com.pe/">Doctor en línea</a> e inicie sesión</p>
        <p>Atentamente, <b>Doctor en línea</b></p>
    </div>
</body>
</html>