<?php 
require_once("../config/database/conexion.php");

$usuario 	= $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$perfil 	= $_POST['perfil'];

$contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario(nombre_usuario,contrasena, rela_perfil) VALUES('$usuario','$contrasena_hasheada', $perfil);";

if($conexion->query($sql)) {
	header("Location: Inicio_sesion.php");
}
?>
