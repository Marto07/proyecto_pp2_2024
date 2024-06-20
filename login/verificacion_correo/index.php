<!-- index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="register.php" method="post">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
