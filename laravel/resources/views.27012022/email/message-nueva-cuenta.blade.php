<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Doctor</title>
</head>
<body>
    <div>
        <h2>Nuevo Usuario Registrado</h2>
        <h3>Nombre : {{ $msg->apellidos }} {{ $msg->nombres }}</h3>
        <h3>Correo : {{ $msg->email }}</h3>
        <h3>Su contraseña es : {{ $password }}</h3>
        <h3>Ingrese a <a href="https://doctor3.syslacsdev.com/">EL Doctor</a></h3>
        <p>Atentamente, <b>EL Doctor</b></p>
    </div>
</body>
</html>
