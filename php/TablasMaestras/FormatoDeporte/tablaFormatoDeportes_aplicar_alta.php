<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();

$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);

$descripcion 		= $_POST['descripcion'];
$deporte 			= $_POST['deporte'];

$sql = "INSERT INTO 
					formato_deporte(descripcion_formato_deporte, rela_deporte)
		VALUES
			('$descripcion', $deporte)";

if ($conexion->query($sql)) {
	header("Location: tablaFormatoDeportes.php");
}
