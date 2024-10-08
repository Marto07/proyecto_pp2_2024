<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();
$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);

$modulo 		= $_POST['modulo'];
$perfil 			= $_POST['perfil'];

$sql = "INSERT INTO 
					asignacion_perfil_modulo(rela_modulo, rela_perfil)
		VALUES
			($modulo, $perfil)";

if ($conexion->query($sql)) {
	header("Location: tablaAsignacionPerfilModulo.php");
}
