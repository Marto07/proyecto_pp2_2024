<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();

$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);

$id = $_GET['id_estado_reserva'];

//eliminar el producto
$sql = "UPDATE estado_reserva 
        	SET
        		estado = 0
        	WHERE id_estado_reserva = $id;";

//ejecutar la consulta o error
if ($conexion->query($sql)) {
	header("Location: tablaestadoreserva.php");
} else {
	echo "error al actualizar el registro: " . $conexion->error;
}
