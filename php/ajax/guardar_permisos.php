<?php
// guardar_permisos.php
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'nombre_base_datos');

$rol_id = $_POST['rol'];
$modulos = isset($_POST['modulos']) ? $_POST['modulos'] : [];

// Eliminar permisos actuales
$conexion->query("DELETE FROM permisos WHERE role_fk = $rol_id");

// Insertar nuevos permisos
foreach ($modulos as $modulo_id) {
    $conexion->query("INSERT INTO permisos (role_fk, modulo_fk) VALUES ($rol_id, $modulo_id)");
}

header('Location: gestion_permisos.php');
?>