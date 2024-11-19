<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "libs/fpdf/fpdf.php");

function getRemoteData($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    }

    curl_close($ch);
    return $output;
}

// Asumiendo que el archivo `get_reservation_data.php` devuelve datos en formato JSON
$jsonData = file_get_contents('http://localhost/proyecto_pp2_2024/php/Reportes/reporte/get_reservation_data.php?period=year');
$data = json_decode($jsonData, true);

// Verifica si `$data['reservations']` existe y es un array
if (!isset($data['reservations']) || !is_array($data['reservations'])) {
    die("Error: No se han recuperado datos de reservas.");
}

// Inicializar FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título del reporte
$pdf->Cell(0, 10, 'Reporte de Reservas', 0, 1, 'C');
$pdf->Ln(10);

// Añadir tabla de reservas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, 'Cancha', 1);
$pdf->Cell(30, 10, 'Fecha', 1);
$pdf->Cell(30, 10, 'Hora Inicio', 1);
$pdf->Cell(30, 10, 'Hora Fin', 1);
$pdf->Cell(30, 10, 'Deporte', 1);
$pdf->Cell(30, 10, 'Estado', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

// Verificar si hay datos de reservas
if (!empty($data['reservations'])) {
    foreach ($data['reservations'] as $reservation) {
        $pdf->Cell(30, 10, $reservation['court'], 1);
        $pdf->Cell(30, 10, $reservation['date'], 1);
        $pdf->Cell(30, 10, $reservation['time'], 1); // Cambiado de `time` a `time_start`
        $pdf->Cell(30, 10, $reservation['id'], 1); // Cambiado de `id` a `time_end`
        $pdf->Cell(30, 10, $reservation['sport'], 1);
        $pdf->Cell(30, 10, $reservation['status'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No hay datos de reservas disponibles.', 1, 1, 'C');
}

// Guardar el PDF
$pdf->Output('F', 'reporte_reservas.pdf');
echo "Reporte generado exitosamente: reporte_reservas.pdf";
