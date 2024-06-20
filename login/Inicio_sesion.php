<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="icons/pestaña.jpg">
  </head>
  <body>

    <div id="image">
        <a href="registro_usuario.php" style="background-color: gray">Crear Usuario</a>

        <form class="login-form" action="verificar_login.php" method="POST">

            <h1>Iniciar sesión</h1>

            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" >
                <span>Error Usuario</span>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" id="password" name="password" >
                <span>Contraseña incorrecta</span>
            </div>

            <button type="submit">Ingresar</button>

        </form>

        <?php if(isset($_GET["error"])) { ?>

          <?php if($_GET['error'] == '1') { ?>
            
            <span style="text-align: center; display: block;color:white; background-color:#FF4500; font-size: 25px;">
                Error: Usuario Incorrecto
            </span>

        <?php } else { ?>

            <span style="text-align: center; display: block;color:white; background-color:#FF4500; font-size: 25px;">
                Error: Contraseña incorrecta
            </span>
          <?php } ?>
        <?php }?>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {

    //inicializamos los pan para ocultarlos
    var spanUsuario      = $('span:eq(0)');
    var spancontrasena  = $('span:eq(1)');

    spanUsuario     .hide();
    spancontrasena  .hide();

    $('form').on('submit', function(event) {
      //obtenemos variables para operar la validacion
        var usuarioInput    = $('#username'); 
        var contrasenaInput = $('#password');

        //ocultamos por defecto los span PREVIO a su validacion

        var usuario = usuarioInput.val();
        var contrasena = contrasenaInput.val();

        var regexusuario    = /^(?=.*[a-zA-Z])[a-zA-Z\d]{5,}$/;
        var regexcontrasena = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

        if (!regexusuario.test(usuario)) {
            event.preventDefault();
            usuarioInput.css('border', '2px solid #FF4500');
            spanUsuario.css({
                'display'           : 'inline-block',
                'background-color'  : '#FF4500',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
            });
            spanUsuario.html('Usuario Invalido.');
            alert('Almenos 5 caracteres. No utilice caracteres especiales');
        } else {
            usuarioInput.css('border', '2px solid green');
            spanUsuario.css({
                'display'           : 'inline-block',
                'background-color'  : 'green',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
            });
            spanUsuario.html('Ok.');
        }

        if (!regexcontrasena.test(contrasena)) {
            event.preventDefault();
            contrasenaInput.css('border', '2px solid #FF4500');
            spancontrasena.css({
                'display'           : 'inline-block',
                'background-color'  : '#FF4500',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
            });
            spancontrasena.html('contrasena Invalida.');
            alert('Almenos 8 caracteres y 1 número.');
        } else {
            contrasenaInput.css('border', '2px solid green');
            spancontrasena.css({
                'display'           : 'inline-block',
                'background-color'  : 'green',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
            });
            spancontrasena.html('Ok.');
        }
    });
});
</script>
  </body>
</html>

