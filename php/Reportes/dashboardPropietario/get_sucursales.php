<?php
require_once("./../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

$idComplejo = isset($_POST['id_complejo']) ? $_POST['id_complejo'] : '';

if ($idComplejo) {
    // Consulta para obtener sucursales relacionadas al complejo seleccionado
    $sql = "SELECT id_sucursal, descripcion_sucursal FROM sucursal WHERE rela_complejo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idComplejo); // "i" indica que el parámetro es un entero
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Consulta para obtener todas las sucursales
    $sql = "SELECT id_sucursal, descripcion_sucursal FROM sucursal";
    $result = $conexion->query($sql);
}

$options = '<option value="">Selecciona una sucursal</option>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . htmlspecialchars($row["id_sucursal"]) . "'>" . htmlspecialchars($row["descripcion_sucursal"]) . "</option>";
    }
} else {
    $options .= "<option value=''>No hay sucursales disponibles</option>";
}

echo $options;

$conexion->close();
