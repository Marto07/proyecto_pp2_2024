<?php 

$conexion = mysqli_connect("localhost","root","","sistema_simple");

$usuario 	= $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$perfil 	= $_POST['perfil'];

$sql = "INSERT INTO usuario(nombre_usuario,contrasena, rela_perfil) VALUES('$usuario','$contrasena', $perfil);";

if($conexion->query($sql)) {
	header("Location: formularioReserva0.php");
}
?>