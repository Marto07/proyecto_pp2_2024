<?php
// obtener_permisos.php
require_once("../../config/database/conexion.php");

$id_perfil = $_GET['id_perfil'];
$permisos_result = $conexion->query("SELECT rela_modulo FROM asignacion_perfil_modulo WHERE rela_perfil = $id_perfil");

$permisos = [];
while ($permiso = $permisos_result->fetch_assoc()) {
    $permisos[] = $permiso['rela_modulo'];
}

echo json_encode($permisos);
?>