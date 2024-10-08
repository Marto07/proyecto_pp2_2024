<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();
$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);

$descripcion 		= $_POST['descripcion'];
$beneficio          = $_POST['beneficio'];

$sql = "INSERT INTO 
					membresia(beneficio_membresia, descripcion_membresia)
		VALUES
			('{$beneficio}','{$descripcion}')";

if ($conexion->query($sql)) {
	header("Location: tablaMembresia.php");
}
