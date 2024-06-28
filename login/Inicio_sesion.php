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
                <label for="email">Correo Electronico</label>
                <input type="text" id="email" name="email" >
                <span>Error Correo</span>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" id="password" name="password" >
                <span>Contraseña incorrecta</span>
            </div>

            <div style="text-align: center;">
                <span id="mensaje-error"></span>    
            </div>

            <button type="submit">Ingresar</button>

            <div style="text-align: center;">
                <a href="recuperar_contrasena/formulario_recuperacion.php">¿Olvidaste tu contraseña?</a>
            </div>

        </form>

        <?php if(isset($_GET["error"])) { ?>

          <?php if($_GET['error'] == '1') { ?>
            
            <span style="text-align: center; display: block;color:white; background-color:#FF4500; font-size: 25px;">
                Error: Correo Electronico Incorrecto o no verificado
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
    var spanerror = $('#mensaje-error');
    spanerror.hide();

    <?php 
        if (isset($_GET['correo_enviado'])) { ?>
            spanerror.css({
                'display'           : 'inline-block',
                'background-color'  : '#6EFF6B',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
        });
        spanerror.html('Verifique su Email');
    <?php } else if (isset($_GET['correo_verificado'])) {?>
        spanerror.css({
                'display'           : 'inline-block',
                'background-color'  : '#6EFF6B',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
        });
        spanerror.html('Email Verificado');
    <?php } ?>


    //inicializamos los span para ocultarlos
    var spanemail       = $('span:eq(0)');
    var spancontrasena  = $('span:eq(1)');

    spanemail     .hide();
    spancontrasena  .hide();

    $('form').on('submit', function(event) {
      //obtenemos variables para operar la validacion
        var emailInput    = $('#email'); 
        var contrasenaInput = $('#password');

        //ocultamos por defecto los span PREVIO a su validacion

        var email = emailInput.val();
        var contrasena = contrasenaInput.val();

        //expresiones regulares
        var regexemail      = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        var regexcontrasena = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

        //testeamos el email
        if (!regexemail.test(email)) {
            //si da incorrecto
            event.preventDefault();
            emailInput.css('border', '2px solid #FF4500');
            spanemail.css({
                'display'           : 'inline-block',
                'background-color'  : '#FF4500',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
            });
            spanemail.html('email Invalido.');
            alert('Almenos 5 caracteres. No utilice caracteres especiales');

        } else {
            //si da correcto
            emailInput.css('border', '2px solid green');
            spanemail.css({
                'display'           : 'inline-block',
                'background-color'  : 'green',
                'margin'            : '10px',
                'color'             : 'white',
                'padding'           : '10px'
            });
            spanemail.html('Ok.');
        }

        //testeamos la contraseña
        if (!regexcontrasena.test(contrasena)) {
            //si da incorrecto
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
            //si da correcto
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

