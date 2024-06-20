<?php 

require_once("../config/database/conexion.php");
$sql_perfil = "SELECT id_perfil,descripcion_perfil FROM perfil;";
$registros = $conexion->query($sql_perfil);
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>






    <form class="login-form" action="resgistro_usuario_aplicar_alta.php" method="POST">

        <h1>Registrar Usuario</h1>

        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="usuario" >
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="contrasena" >
        </div>

        <div class="form-group">

        	<label for="perfil">Perfil:</label>
			<select name="perfil" id="perfil">
				<option value="" disabled selected required>Seleccione un Perfil...</option>
				<?php foreach ($registros as $reg) { ?>
					<option value="<?php echo $reg['id_perfil']; ?>"><?php echo $reg['descripcion_perfil']; ?></option>
				<?php } ?>
			</select>
			
		</div>
			

        <button type="submit">Ingresar</button>

    </form>

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
            alert('El nombre de usuario debe tener almenos 5 caracteres. No utilice caracteres especiales');
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
            alert('La contraseña debe tener almenos 8 caracteres y 1 número.');
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