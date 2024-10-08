<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();

$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);

$descripcion 		= $_POST['descripcion'];
$provincia 			= $_POST['provincia'];

$sql = "INSERT INTO 
					localidad(descripcion_localidad, rela_provincia)
		VALUES
			('$descripcion', $provincia)";

if ($conexion->query($sql)) {
	header("Location: tablalocalidades.php");
}
