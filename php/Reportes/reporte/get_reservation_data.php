<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

// $period = $_GET['period'];
$period = isset($_GET['period']) ? $_GET['period'] : '';

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

$timeFilter = "";
if ($period == 'custom' && $startDate && $endDate) {
    $timeFilter = "AND r.fecha_reserva >= '$startDate' AND r.fecha_reserva <= '$endDate'";
} else {
    switch ($period) {
        case 'day':
            $interval = 'INTERVAL 1 DAY';
            break;
        case 'week':
            $interval = 'INTERVAL 1 WEEK';
            break;
        case 'month':
            $interval = 'INTERVAL 1 MONTH';
            break;
        case 'year':
            $interval = 'INTERVAL 1 YEAR';
            break;
        default:
            $interval = 'INTERVAL 1 WEEK';
            break;
    }
    $timeFilter = "AND r.fecha_reserva >= DATE_SUB(CURDATE(), $interval)";
}

$query = "SELECT * ,z.descripcion_zona AS cancha, 
             h.horario_inicio,  
            COUNT(r.id_reserva) AS total_reservas 
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
            WHERE 1=1 $timeFilter
            GROUP BY cancha, h.horario_inicio
            ORDER BY total_reservas DESC";



$result = $conexion->query($query);

$data = [
    'hours' => ['labels' => [], 'values' => []],
    'courts' => ['labels' => [], 'values' => []],
    'reservations' => [] // Añadimos aquí los datos de las reservas
];

while ($row = $result->fetch_assoc()) {
    // Para los gráficos
    $data['hours']['labels'][] = $row['horario_inicio'];
    $data['hours']['values'][] = $row['total_reservas'];
    $data['courts']['labels'][] = $row['cancha'];
    $data['courts']['values'][] = $row['total_reservas'];

    // Para la tabla de reservas
    $data['reservations'][] = [
        'court' => $row['cancha'],
        'date' => $row['fecha_reserva'],
        'time' => $row['horario_inicio'],
        'id' => $row['horario_fin'],
        'sport' => $row['descripcion_deporte'],
        'status' => $row['descripcion_estado_reserva'] // Asegúrate de que este campo esté en la consulta SQL
    ];
}

echo json_encode($data);
