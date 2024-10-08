<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();

$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);

$id = $_GET['id_localidad'];

//eliminar el producto
$sql = "UPDATE localidad 
        	SET
        		estado = 0
        	WHERE id_localidad = $id;";

//ejecutar la consulta o error
if ($conexion->query($sql)) {
	header("Location: tablalocalidades.php");
} else {
	echo "error al actualizar el registro: " . $conexion->error;
}
