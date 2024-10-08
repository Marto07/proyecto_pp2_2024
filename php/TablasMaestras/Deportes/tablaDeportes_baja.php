<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();
$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);


$id = $_GET['id_deporte'];

//eliminar el producto
$sql = "UPDATE deporte 
        	SET
        		estado = 0
        	WHERE id_deporte = $id;";

//ejecutar la consulta o error
if ($conexion->query($sql)) {
	header("Location: tablaDeportes.php");
} else {
	echo "error al actualizar el registro: " . $conexion->error;
}
