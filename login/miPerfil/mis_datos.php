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


    //VALIDACION DE PERMISOS SIN BASE DE DATOS
    /*$perfiles_permitidos = ['administrador', 'Personal Administrativo'];
    if (!in_array($_SESSION['perfil'], $perfiles_permitidos)) {
        echo "Acceso denegado. No tienes permiso para acceder a esta página.";
        exit();
    }*/
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

		<div class="modificar">
			<a href="modificar_mis_datos.php"><img src="../../assets/icons/editar_amarillo.png"></a>
			<br>
		</div>

		<label for="usuario">Usuario:</label>
		<h3 name="usuario"><?php echo $_SESSION['usuario']; ?></h3>
		<br>

		<label for="perfil">Perfil:</label>
		<h3 name="perfil"><?php echo $_SESSION['perfil']; ?></h3>
		<br>

		<label for="contrasena">Contraseña:</label>
		<h3 name="contrasena">*********</h3>
		<br>


	</form>


</body>
</html>