<?php
require_once("./../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

$idDeporte = isset($_POST['id_deporte']) ? $_POST['id_deporte'] : '';

if ($idDeporte) {
    // Consulta para obtener formatos relacionados al deporte seleccionado
    $sql = "SELECT id_formato_deporte, descripcion_formato_deporte FROM formato_deporte WHERE rela_deporte = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idDeporte); // "i" indica que el parámetro es un entero
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Consulta para obtener todos los formatos
    $sql = "SELECT id_formato_deporte, descripcion_formato_deporte FROM formato_deporte";
    $result = $conexion->query($sql);
}

$options = '<option value="">Selecciona un Formato</option>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . htmlspecialchars($row["id_formato_deporte"]) . "'>" . htmlspecialchars($row["descripcion_formato_deporte"]) . "</option>";
    }
} else {
    $options .= "<option value=''>No hay formatos disponibles</option>";
}

echo $options;

$conexion->close();
