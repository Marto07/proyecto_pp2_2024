<?php 
	session_start();
	require_once("../../config/database/conexion.php");
	
	if ($_GET['datos_personales']) {
		$nombre 	= $_POST['nombre'];
		$apellido 	= $_POST['apellido'];
		$dni 		= $_POST['documento'];
		$sexo 		= $_POST['sexo'];
	}

	if($_GET['datos_de_usuario']) {
		$email 		= $_POST['email'];
		$usuario	= $_POST['username'];
	}
	


	$sql = "UPDATE usuario SET 
								nombre_usuario = '$usuario', 
								contrasena = '$contrasena_hasheada'
							WHERE 
								id_usuario = {$_SESSION['id_usuario']} ";

if($conexion->query($sql)) {
	header("Location: mis_datos.php");
}
?>