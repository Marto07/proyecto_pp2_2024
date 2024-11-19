<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

// Parámetros de la solicitud
$period = isset($_GET['period']) ? $_GET['period'] : 'week';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = isset($_GET['recordsPerPage']) ? (int)$_GET['recordsPerPage'] : 10;
$offset = ($page - 1) * $recordsPerPage;

// Configuración de filtros de fechas
$whereClause = '';
$params = [];

if ($period === 'custom' && $startDate && $endDate) {
    $whereClause = 'WHERE fecha_reserva BETWEEN :startDate AND :endDate';
    $params[':startDate'] = $startDate;
    $params[':endDate'] = $endDate;
} else {
    switch ($period) {
        case 'day':
            $whereClause = 'WHERE fecha_reserva = CURDATE()';
            break;
        case 'week':
            $whereClause = 'WHERE YEARWEEK(fecha_reserva, 1) = YEARWEEK(CURDATE(), 1)';
            break;
        case 'month':
            $whereClause = 'WHERE MONTH(fecha_reserva) = MONTH(CURDATE()) AND YEAR(fecha_reserva) = YEAR(CURDATE())';
            break;
        case 'year':
            $whereClause = 'WHERE YEAR(fecha_reserva) = YEAR(CURDATE())';
            break;
    }
}

// Consulta para los datos de la tabla
// Prepara la consulta
$query = "SELECT descripcion_sucursal, descripcion_zona, fecha_reserva, horario_inicio, horario_fin, descripcion_deporte, descripcion_estado_reserva
            FROM reserva r
            JOIN estado_reserva er ON r.rela_estado_reserva = er.id_estado_reserva
            JOIN horario h ON r.rela_horario = h.id_horario
            JOIN zona z ON r.rela_zona = z.id_zona
            JOIN formato_deporte fd ON z.rela_formato_deporte = fd.id_formato_deporte
            JOIN deporte d ON fd.rela_deporte = d.id_deporte
            JOIN sucursal s ON z.rela_sucursal = s.id_sucursal
            $whereClause
            ORDER BY fecha_reserva, horario_inicio
            LIMIT ?, ?";

$stmt = $conexion->prepare($query);
$stmt->bind_param('ii', $offset, $recordsPerPage); // Ajusta los parámetros de paginación
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}
$stmt->close();

// Consulta para el gráfico de reservas por día de la semana
$queryDays = "
    SELECT DAYNAME(fecha_reserva) as dia, COUNT(*) as total
    FROM reserva
    $whereClause
    GROUP BY dia
    ORDER BY FIELD(dia, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";

$stmtDays = $conexion->prepare($queryDays);
$stmtDays->execute();
$resultDays = $stmtDays->get_result();

$daysData = [];
while ($row = $resultDays->fetch_assoc()) {
    $daysData[] = $row;
}
$stmtDays->close();

// Consulta para el gráfico de canchas más reservadas por horario
$queryCourts = "
    SELECT descripcion_zona as cancha, COUNT(*) as total
    FROM reserva r
    JOIN zona z ON r.rela_zona = z.id_zona
    $whereClause
    GROUP BY cancha
    ORDER BY total DESC
    LIMIT 5";

$stmtCourts = $conexion->prepare($queryCourts);
$stmtCourts->execute();
$resultCourts = $stmtCourts->get_result();

$courtsData = [];
while ($row = $resultCourts->fetch_assoc()) {
    $courtsData[] = $row;
}
$stmtCourts->close();

// Consulta para contar el total de registros
$queryCount = "
    SELECT COUNT(*) as total
    FROM reserva
    $whereClause";

$stmtCount = $conexion->prepare($queryCount);
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$totalRecords = $resultCount->fetch_assoc()['total'];
$hasMorePages = $totalRecords > $page * $recordsPerPage;
$stmtCount->close();

// Formatear la respuesta
$response = [
    'reservations' => $reservations,
    'days' => [
        'labels' => array_column($daysData, 'dia'),
        'values' => array_column($daysData, 'total')
    ],
    'courts' => [
        'labels' => array_column($courtsData, 'cancha'),
        'values' => array_column($courtsData, 'total')
    ],
    'hasMorePages' => $hasMorePages
];

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
