<?php
header('Content-Type: application/json');
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

// Obtener los parámetros de filtro
$complejo = $_GET['complejo'] ?? '';
$sucursal = $_GET['sucursal'] ?? '';
$deporte = $_GET['deporte'] ?? '';
$formato = $_GET['formato'] ?? '';
$estadoReserva = $_GET['estadoReserva'] ?? '';
$fechaRango = $_GET['fechaRango'] ?? '';

// Construir la consulta SQL con filtros
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

// Agregar condiciones en función de los filtros
if ($complejo) $sql .= " AND c.id_complejo = '$complejo'";
if ($sucursal) $sql .= " AND s.id_sucursal = '$sucursal'";
if ($deporte) $sql .= " AND d.id_deporte = '$deporte'";
if ($formato) $sql .= " AND fd.id_formato_deporte = '$formato'";
if ($estadoReserva) $sql .= " AND er.id_estado_reserva = '$estadoReserva'";
if ($fechaRango) {
    [$start, $end] = explode(' - ', $fechaRango);
    $sql .= " AND r.fecha_reserva BETWEEN '$start' AND '$end'";
}

$result = $conexion->query($sql);
$reservas = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($reservas);
