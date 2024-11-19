<?php
require_once("../dashboard/api_reservas.php");
require_once(RUTA . "config/database/conexion.php");

$complejo = $_GET['complejo'] ?? null;
$sucursal = $_GET['sucursal'] ?? null;
$deporte = $_GET['deporte'] ?? null;
$tipoDeporte = $_GET['tipoDeporte'] ?? null;
$estadoReserva = $_GET['estadoReserva'] ?? null;
$fechaInicio = $_GET['fechaInicio'] ?? null;
$fechaFin = $_GET['fechaFin'] ?? null;

// Consulta principal para obtener reservas
$sql = "SELECT *
        FROM complejo c
        JOIN sucursal s ON s.rela_complejo = c.id_complejo
        JOIN zona z ON z.rela_sucursal = s.id_sucursal
        JOIN estado_zona ez ON z.rela_estado_zona = ez.id_estado_zona
        JOIN servicio sr ON z.rela_servicio = sr.id_servicio
        JOIN tipo_terreno tt ON z.rela_tipo_terreno = tt.id_tipo_terreno
        JOIN formato_deporte fd ON z.rela_formato_deporte = fd.id_formato_deporte
        JOIN deporte d ON fd.rela_deporte = d.id_deporte
        JOIN reserva r ON r.rela_zona = z.id_zona
        JOIN estado_reserva er ON r.rela_estado_reserva = er.id_estado_reserva
        JOIN horario h ON r.rela_horario = h.id_horario
        WHERE 1=1";

$params = [];
$types = "";

// Añadir filtros opcionales
if ($complejo) {
    $sql .= " AND c.id_complejo = ?";
    $types .= "i";
    $params[] = $complejo;
}
if ($sucursal) {
    $sql .= " AND s.id_sucursal = ?";
    $types .= "i";
    $params[] = $sucursal;
}
if ($deporte) {
    $sql .= " AND d.id_deporte = ?";
    $types .= "i";
    $params[] = $deporte;
}
if ($tipoDeporte) {
    $sql .= " AND fd.id_formato_deporte = ?";
    $types .= "i";
    $params[] = $tipoDeporte;
}
if ($estadoReserva) {
    $sql .= " AND er.id_estado_reserva = ?";
    $types .= "i";
    $params[] = $estadoReserva;
}
if ($fechaInicio) {
    $sql .= " AND r.fecha_reserva >= ?";
    $types .= "s";
    $params[] = $fechaInicio;
}
if ($fechaFin) {
    $sql .= " AND r.fecha_reserva <= ?";
    $types .= "s";
    $params[] = $fechaFin;
}

$stmt = $conexion->prepare($sql);

// Condición para verificar si existen parámetros antes de llamarlo
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['sucursal'] . ' - ' . $row['deporte']; // Combina sucursal y deporte
    $data[] = $row['cantidad'];
}
