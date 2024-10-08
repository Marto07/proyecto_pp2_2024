<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();
$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);
$id = $_GET['id_tipo_documento'];

//eliminar el producto
$sql = "UPDATE tipo_documento 
        	SET
        		estado = 0
        	WHERE id_tipo_documento = $id;";

//ejecutar la consulta o error
if ($conexion->query($sql)) {
	header("Location: tabla_tipo_documentos.php");
} else {
	echo "error al actualizar el registro: " . $conexion->error;
}
