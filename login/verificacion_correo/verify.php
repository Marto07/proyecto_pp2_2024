<?php

require 'vendor/autoload.php';

// Configurar conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=proyecto_pp2';
$usuario = 'root';
$contrasena = '';

try {
    $pdo = new PDO($dsn, $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['email']) && isset($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        // Verificar el token en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM usuarios u JOIN contacto c ON u.rela_contacto = c.id_contacto WHERE c.descripcion_contacto = ? AND u.token = ? AND expiry > NOW()");
        $stmt->execute([$email, $token]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Actualizar estado del usuario a 'verificado'
            $stmt = $pdo->prepare("UPDATE usuarios u
                                    JOIN contacto c ON u.rela_contacto = c.id_contacto
                                    SET u.estado = 'verificado',
                                    u.token = NULL, u.expiry = NULL
                                    WHERE c.descripcion_contacto = ?");
            $stmt->execute([$email]);

            header("Location: ../inicio_sesion.php?correo_verificado");
            exit();
        } else {
            $stmt = $pdo->prepare("SELECT username FROM usuarios u
                                    JOIN contacto c ON u.rela_contacto = c.id_contacto
                                    WHERE c.descripcion_contacto = ?");
            $stmt->execute([$email]);
            $reg = $stmt->fetch(PDO::FETCH_ASSOC);

            if($reg) {
                $username = $reg['username'];
                echo "Token inválido, expirado o correo electrónico no encontrado. <br> <a href='../inicio_sesion.php?verificacion_expirada&email={$email}&username={$username}'>Volver al login</a>";
            }
        }
    } else {
        echo 'Parámetros insuficientes para la verificación.';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
