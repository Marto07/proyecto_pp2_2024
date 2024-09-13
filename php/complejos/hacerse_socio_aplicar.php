<?php
session_start(); // Asegúrate de tener la sesión iniciada

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "proyecto_pp2"; 

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los valores del POST
$id_persona = isset($_POST['id_persona']) ? intval($_POST['id_persona']) : 0;
$id_complejo = isset($_POST['id_complejo']) ? intval($_POST['id_complejo']) : 0;
$id_membresia = isset($_POST['membresia']) ? intval($_POST['membresia']) : 0;

if ($id_persona > 0 && $id_complejo > 0 && $id_membresia > 0) {
    // Insertar el registro de membresía (esto asume que tienes una tabla para almacenar esta relación)
    $query = "
        INSERT INTO socio (rela_persona, rela_complejo, rela_membresia) 
        VALUES ($id_persona, $id_complejo, $id_membresia)";
    echo $query; die;
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $id_persona, $id_complejo, $id_membresia);

    if ($stmt->execute()) {
        echo "¡Registro exitoso! La persona ahora es socio del complejo.";
    } else {
        echo "Error al registrar al socio: " . $conn->error;
    }
} else {
    echo "Datos inválidos. No se pudo completar el registro.";
}

// Cerrar conexión a la base de datos
$conn->close();
?>
