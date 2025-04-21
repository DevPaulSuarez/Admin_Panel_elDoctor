<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor en línea</title>
</head>
<body>
    <div>
        <h2>RECUPERAR CUENTA</h2>
    <h4>para recuperar tu cuenta haga click <a style="text-decoration: underline; font-weight: bold" href="http://{{ $_SERVER["HTTP_HOST"] }}/recuperar-acceso/{{ $msg->usuario_id }}/{{ $msg->token }}"><b>Aquí</b></a></h4>
        <p>Atentamente, <b>Doctor en línea</b></p>
    </div>
</body>
</html>