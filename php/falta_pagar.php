<?php  
// Consultamos la reserva por ID
$reserva_id = $_POST['reserva_id']; // o el ID que corresponda
$query = "SELECT monto_total, monto_pagado FROM reservas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $reserva_id);
$stmt->execute();
$result = $stmt->get_result();
$reserva = $result->fetch_assoc();

$monto_total = $reserva['monto_total'];
$monto_pagado = $reserva['monto_pagado'];

// Validamos si el monto pagado es igual al total
if ($monto_pagado >= $monto_total) {
    echo "Reserva completa. El cliente puede jugar.";
    // Actualizar el estado de asistencia en la tabla "control"
    $update_query = "UPDATE control SET asistencia = 1 WHERE reserva_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $reserva_id);
    $update_stmt->execute();
} else {
    $saldo_faltante = $monto_total - $monto_pagado;
    echo "Falta pagar $saldo_faltante para poder jugar.";
}
?>