<?php 
require_once('../../config/database/conexion.php');
$idHora = $_POST['id_hora'];
$fecha = $_POST['fecha'];
$cancha = $_POST['cancha'];
$persona = $_POST['persona'];


$sqlInsert = "INSERT INTO reserva(fecha_reserva,fecha_alta,rela_estado_reserva,rela_persona,rela_zona,
									rela_perfil_reserva,rela_horario) 
				VALUES('$fecha',CURRENT_DATE(),1,$persona,$cancha,1,$idHora);";

if($conexion->query($sqlInsert)) {

	header("Location: formularioReserva1.php");

} else{
	'ERROR DURANTE LA RESERVA';
}
?>