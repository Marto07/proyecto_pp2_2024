<?php   
    require_once("../../config/database/conexion.php");
    session_start();

    if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_perfil'])) {
        header("Location: ../../error403.php");
        exit();
    }

    $modulo = "Personas";

    $sql_acceso = "SELECT COUNT(*) AS tiene_acceso
                    FROM 
                        asignacion_perfil_modulo asp
                    JOIN 
                        perfil p 
                    ON 
                        asp.rela_perfil = p.id_perfil
                    JOIN 
                        modulo m ON asp.rela_modulo = m.id_modulo
                    WHERE 
                        p.descripcion_perfil 
                    LIKE 
                        '{$_SESSION['perfil']}' 
                    AND 
                        m.descripcion_modulo 
                    LIKE 
                        '{$modulo}'";

    $resultado = $conexion->query($sql_acceso);

    if ($reg = $resultado->fetch_assoc()) {
        if ($reg['tiene_acceso'] == 0) {
            header("Location: ../../error403.php");
            exit();
        }
    }

    if(isset($_GET['datos_personales'])) {
    	$formulario = 

    		'<form action="aplicar_modificar_mis_datos.php" method="POST">
				<h1>Modificar mis Datos</h1>
				<input type="hidden" name="tipo_formulario" value="datos_personales">
	    		<label for="nombre">nombre:</label>
				<input type="text" id="username" name="nombre" value="' . $_SESSION['datos_personales']['nombre'] . '">
				<br>

				<label for="apellido">apellido:</label>
				<input type="text" id="username" name="apellido" value="' . $_SESSION['datos_personales']['apellido'] .'">
				<br>

				<label for="documento">documento:</label>
				<input type="text" id="username" name="documento" value="' . $_SESSION['datos_personales']['descripcion_documento'] . '">
				<br>

				<label for="sexo">sexo:</label>
				<input type="text" id="username" name="sexo" value="' . $_SESSION['datos_personales']['descripcion_sexo'] . '">
				<br>
				<button type="submit">Enviar</button>
			</form>';
    }

    if(isset($_GET['datos_de_usuario'])) {
    	$formulario = 
    		'<form action="aplicar_modificar_mis_datos.php" method="POST">
				<h1>Modificar mis Datos</h1>
				<input type="hidden" name="tipo_formulario" value="datos_de_usuario">

				<label for="email">E-mail:</label>
				<input type="text" id="email" name="email" value="' . $_SESSION['email'] .'">
				<br>

	    		<label for="username">Usuario:</label>
				<input type="text" id="username" name="username" value="' . $_SESSION['usuario'] . '">
				<br>

				
				<button type="submit">Enviar</button>
			</form>';
    }


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modificar Usuario</title>
	<style type="text/css">
		
		body {
			background-color: #F1F1F1;
			padding:0;
			margin:0;
			font-family: arial;
		}

		form {
			background-color: #f7f7f7;
		  	border: 1px solid #ccc;
		  	border-radius: 10px;
		  	box-shadow: 2px 2px 20px #AFAFAF;
		  	margin: 0px auto;
		  	margin-top: 15vh;
		  	margin-bottom: 20px;
		  	padding: 20px;
		  	width: 400px;
		}

		form h1 {
			text-align: center;
		}	

		form .modificar {
			text-align: right;
		}

		form img {
			width: 40px;
		}

		form h3 {
			display: inline-block;
		}

		/* Estilos para los input de tipo "text" */
		input[type="text"] {
		  background-color: #f7f7f7;
		  border: 1px solid #d2d2d2;
		  padding: 10px;
		  border-radius: 5px;
		  width: 95%;
		  margin-bottom: 10px;
		}

		input[type="text"]:focus {
		  border-color: #8BC34A;
		  box-shadow: 0px 0px 10px rgba(138, 195, 74, 0.2);
		}

		/* Estilos para el botón de tipo "submit" */
		button[type="submit"] {
		  background-color: #8BC34A;
		  color: #fff;
		  border: none;
		  padding: 10px 20px;
		  border-radius: 5px;
		}

		button[type="submit"]:hover {
		  background-color: #66D9EF;
		}

		button[type="submit"]:active {
		  background-color: #4CAF50;
		}

		.back-button {
            background-color: #a8e6cf;
            color: #3d9970;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background-color: #79b8a0;
            color: white;
        }
	</style>
</head>
<body>
<a class="back-button" href="../../index_tincho.php">Volver</a>



		<?php echo $formulario; ?>

		

	<?php if(isset($_GET["error"])) { ?>

          <?php if($_GET['error'] == '1') { ?>
            
            <span style="text-align: center; display: block;color:white; background-color:#FF4500; font-size: 25px;">
                error: 1
            </span>

        <?php } else { ?>
            <span style="text-align: center; display: block;color:white; background-color:#FF4500; font-size: 25px;">
              error: 2 Contraseñas no coinciden
            </span>
          <?php } ?>
        <?php }?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
	$(document).ready(function() {

	    $('form').on('submit', function(event) {

	      //obtenemos variables para operar la validacion
	        var usuarioInput    = $('#username'); 
	        

	        //ocultamos por defecto los span PREVIO a su validacion

	        var usuario = usuarioInput.val();
	       

	        var regexusuario    = /^(?=.*[a-zA-Z])[a-zA-Z\d]{5,}$/;
	        
/*
	        if (!regexusuario.test(usuario)) {
	            event.preventDefault();
	            usuarioInput.css('border', '2px solid #FF4500');
	           
	    
	            alert('Almenos 5 caracteres. No utilice caracteres especiales');
	        } else {
	            usuarioInput.css('border', '2px solid green');
	           
	        }*/

	        
	    });
	});
</script>
</body>
</html>