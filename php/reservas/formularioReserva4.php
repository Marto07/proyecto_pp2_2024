<?php 
require_once('conexion.php');
$idHora = $_POST['id_hora'];
$fecha = $_POST['fecha'];
$cancha = $_POST['cancha'];
$usuario = $_POST['usuario'];


$sqlInsert = "INSERT INTO reserva(fecha_reserva,fecha_alta,rela_persona,rela_zona,
									rela_horario) 
				VALUES('$fecha',CURRENT_DATE(),$usuario,$cancha,$idHora);";

if($conexion->query($sqlInsert)) {

	header("Location: formularioReserva1.php");

} else{
	'ERROR DURANTE LA RESERVA';
}
?>