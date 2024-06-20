<?php 
require_once("../config/database/conexion.php");

$usuario 	= $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios(username,password,token, estado) VALUES('$usuario','$contrasena_hasheada', 2);";

if($conexion->query($sql)) {
	header("Location: Inicio_sesion.php");
}
?>
