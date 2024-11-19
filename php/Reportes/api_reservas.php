<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sucursal = $_GET['sucursal'] ?? '';
$cancha = $_GET['cancha'] ?? '';
$fecha_desde = $_GET['fecha_desde'] ?? '';
$fecha_hasta = $_GET['fecha_hasta'] ?? '';
$estado = $_GET['estado'] ?? '';

$sql = "SELECT * FROM reservas WHERE 1=1";

if (!empty($sucursal)) {
    $sql .= " AND sucursal = '$sucursal'";
}
if (!empty($cancha)) {
    $sql .= " AND cancha = '$cancha'";
}
if (!empty($fecha_desde)) {
    $sql .= " AND fecha >= '$fecha_desde'";
}
if (!empty($fecha_hasta)) {
    $sql .= " AND fecha <= '$fecha_hasta'";
}
if (!empty($estado)) {
    $sql .= " AND estado = '$estado'";
}

$result = $conn->query($sql);
$reservas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
}

$conn->close();
echo json_encode($reservas);
