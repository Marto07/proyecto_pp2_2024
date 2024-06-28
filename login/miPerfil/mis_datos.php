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

    $sql = "SELECT
    			persona.nombre,
    			persona.apellido,
    			documento.descripcion_documento,
    			sexo.descripcion_sexo
    		FROM
    			persona 
    		JOIN 
    			contacto
    		ON
    			contacto.rela_persona = persona.id_persona
            JOIN 
    			documento
    		ON
    			persona.rela_documento = documento.id_documento
    		JOIN
    			sexo
    		ON
    			persona.rela_sexo = sexo.id_sexo
    		WHERE
				contacto.descripcion_contacto = ?
    		";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $_SESSION['email']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $datos_personales = $resultado->fetch_assoc();

    /*if($datos_personales) {

    	$nombre 	= $datos_personales['nombre'];
    	$apellido 	= $datos_personales['apellido'];
    	$documento 	= $datos_personales['descripcion_documento'];
    	$sexo 		= $datos_personales['descripcion_sexo'];

    }*/

    $_SESSION['datos_personales'] = $datos_personales;

    $stmt->close();
    $conexion->close();

 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de Usuario</title>
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


	<form>
		<h1>Datos de Usuario</h1>

		

		<fieldset>
			<legend align="center">Informacion Personal</legend>

			<div class="modificar">
				<a href="modificar_mis_datos.php?datos_personales"><img src="../../assets/icons/editar_azul.png"></a>
				<br>
			</div>

			<label for="nombre">nombre:</label>
			<h3 name="nombre"><?php echo $_SESSION['datos_personales']['nombre']; ?></h3>
			<br>

			<label for="apellido">apellido:</label>
			<h3 name="apellido"><?php echo $_SESSION['datos_personales']['apellido']; ?></h3>
			<br>

			<label for="dni">dni:</label>
			<h3 name="dni"><?php echo $_SESSION['datos_personales']['descripcion_documento']; ?></h3>
			<br>

			<label for="sexo">sexo:</label>
			<h3 name="sexo"><?php echo $_SESSION['datos_personales']['descripcion_sexo']; ?></h3>
			<br>

		</fieldset>

		<fieldset>
			<legend align="center">Datos del Usuario</legend>

			<div class="modificar">
				<a href="modificar_mis_datos.php?datos_de_usuario"><img src="../../assets/icons/editar_azul.png"></a>
				<br>
			</div>

			<label for="email">Email:</label>
			<h3 name="email"><?php echo $_SESSION['email']; ?></h3>
			<br>

			<label for="usuario">Usuario:</label>
			<h3 name="usuario"><?php echo $_SESSION['usuario']; ?></h3>
			<br>

			<label for="perfil">Perfil:</label>
			<h3 name="perfil"><?php echo $_SESSION['perfil']; ?></h3>
			<br>

		</fieldset>

		<div class="modificar" style="text-align: center; margin: 10px">
			<a href="cambiar_contrasena.php" >Cambiar contrase&ntilde;a</a>
			<br>
		</div>


	</form>


</body>
</html>