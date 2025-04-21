<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Doctor</title>
</head>
<body>
    <div>
        <p>Dr(a). <b>{{ $msg->name_doctor }} {{ $msg->lastname_doctor }}</b> la cita con su paciente <b>{{ $msg->name_client }} {{ $msg->lastname_client }}</b> empieza en <b>{{ $time }} minutos</b></p>
        <p>Ingrese a la plataforma <a style="text-decoration: underline; font-weight: bold" href="https://eldoctor.pe/medico/login">El Doctor</a> e inicie sesión</p>
        <p>Atentamente, <b>El Doctor</b></p>
    </div>
</body>
</html>