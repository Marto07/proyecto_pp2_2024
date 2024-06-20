<?php 
$idHora = $_POST['id_hora'];
$fecha = $_POST['fecha'];

$conexion = mysqli_connect('localhost','root','','reserva_con_chat');
$sqlInsert = "INSERT INTO reserva VALUES(NULL,'$fecha',1,$idHora);";

if($conexion->query($sqlInsert)) {

	header("Location: verReservas1.php");

} else{
	'gil';
}
?>

