<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Doctor</title>
</head>
<body>
    <div>
        <p>Sr(a). <b>{{ $msg->name_client }} {{ $msg->lastname_client }}</b> su cita con el médico <b>{{ $msg->name_doctor }} {{ $msg->lastname_doctor }}</b> empieza en <b>{{ $time }} minutos</b></p>
        <p>Ingrese a la plataforma <a style="text-decoration: underline; font-weight: bold" href="https://eldoctor.pe/paciente/login">El Doctor</a>, por favor espere en la sala del doctor en linea para que el médico lo pueda contactar.</p>
        <p>Atentamente, <b>El Doctor</b></p>
    </div>
</body>
</html>