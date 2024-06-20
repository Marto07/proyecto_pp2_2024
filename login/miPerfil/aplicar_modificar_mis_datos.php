<?php 
	session_start();
	require_once("../../config/database/conexion.php");
	echo $_SESSION['usuario'];

	$usuario    = $_POST['usuario'];
	$contrasena = $_POST['contrasena_nueva'];

	$contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);


	$sql = "UPDATE usuario SET 
								nombre_usuario = '$usuario', 
								contrasena = '$contrasena_hasheada'
							WHERE 
								id_usuario = {$_SESSION['id_usuario']} ";

if($conexion->query($sql)) {
	header("Location: mis_datos.php");
}
?>