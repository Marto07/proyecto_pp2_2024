<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Configurar conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=proyecto_pp2';
$usuario = 'root';
$contrasena = '';

try {
    $pdo = new PDO($dsn, $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nombre     = $_POST['nombre'];
        $apellido   = $_POST['apellido'];
        $dni        = $_POST['dni'];
        $sexo       = $_POST['sexo'];
        $username   = $_POST['username'];
        $email      = $_POST['email'];
        $password   = $_POST['password'];
        $contrasena_hasheada = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(16)); // Genera un token único
        $expiry = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        //Insertar documento
        $stmt = $pdo->prepare("INSERT INTO documento (descripcion_documento,rela_tipo_documento) VALUES ( ?, ?)");
        $stmt->execute([$dni, 1]);
        $id_documento = $pdo->lastInsertId();

        //Insertar en persona
        $stmt = $pdo->prepare("INSERT INTO persona (nombre, apellido, rela_documento,rela_sexo) VALUES (?, ?, ?,?)");
        $stmt->execute([$nombre, $apellido, $id_documento, $sexo]);
        $id_persona = $pdo->lastInsertId();


        //Insertar en contacto
        $stmt = $pdo->prepare("INSERT INTO contacto (descripcion_contacto,rela_persona,rela_tipo_contacto) VALUES (?, ?, ?)");
        $stmt->execute([$email, $id_persona, 1]);
        $id_contacto = $pdo->lastInsertId();

        // Insertar el usuario
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password,token,expiry,rela_contacto, rela_perfil) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $contrasena_hasheada,$token, $expiry,$id_contacto, 1]);

        // Enviar correo de verificación
        $verification_link = "http://localhost/proyecto_pp2_2024/login/verificacion_correo/verify.php?email=$email&token=$token";
        $subject = '<h1>Verificación de Correo Electr&oacute;nico<h1>';
        $message = "<h2>Hola $username, haz clic en el siguiente enlace para verificar tu correo electr&oacute;nico: $verification_link"."</h2>";

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Cambia al servidor SMTP que uses
        $mail->SMTPAuth = true;
        $mail->Username = 'maurinprueba@gmail.com'; // Cambia al correo desde el que enviarás el mensaje
        $mail->Password = 'xzpdakudwjcsyhci'; // Cambia a la contraseña del correo
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('maurinprueba@gmail.com', 'BestSports');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        header("Location: ../inicio_sesion.php?correo_enviado");
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}";
}
?>
