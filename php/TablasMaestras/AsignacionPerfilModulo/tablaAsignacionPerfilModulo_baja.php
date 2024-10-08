<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();
$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);


$id = $_GET['id_asignacion_perfil_modulo'];

//eliminar el producto
$sql = "DELETE FROM asignacion_perfil_modulo 
        	WHERE id_asignacion_perfil_modulo = $id;";

//ejecutar la consulta o error
if ($conexion->query($sql)) {
    header("Location: tablaAsignacionPerfilModulo.php");
} else {
    echo "error al actualizar el registro: " . $conexion->error;
}
