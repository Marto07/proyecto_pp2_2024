<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();
$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);



$descripcion 		= $_POST['descripcion'];
$localidad 			= $_POST['localidad'];

$sql = "INSERT INTO 
					barrio(descripcion_barrio, rela_localidad)
		VALUES
			('$descripcion', $localidad)";

if ($conexion->query($sql)) {
	header("Location: tablabarrios.php");
}
