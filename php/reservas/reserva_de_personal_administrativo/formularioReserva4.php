<?php 
require_once('../../../config/root_path.php');
require_once(RUTA.'config/database/db_functions/zonas.php');
$rela_horario 	= $_POST['id_horario'];
$fecha 			= $_POST['fecha'];
$rela_persona 	= $_POST['persona'];
$rela_zona 		= $_POST['cancha'];

// echo $rela_horario."<br>".$fecha."<br>".$rela_zona."<br>".$rela_persona;die;


if(insertarReserva($rela_horario, $fecha, $rela_zona, $rela_persona)) {
	header("Location: formularioReserva1.php");
} else {
	echo "error en la reserva";
	echo "<a href='formularioReserva1.php'>Volver</a>";
}
?>

