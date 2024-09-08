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

// Obtener el id_usuario e id_complejo del GET
$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;
$id_complejo = isset($_GET['id_complejo']) ? intval($_GET['id_complejo']) : 0;

if ($id_usuario > 0) {
    // Consulta para obtener el id_persona asociado al id_usuario
    $query = "
        SELECT p.id_persona 
        FROM usuarios u 
        JOIN contacto c ON u.rela_contacto = c.id_contacto 
        JOIN persona p ON c.rela_persona = p.id_persona 
        WHERE u.id_usuario = ?
        LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener el id_persona
        $row = $result->fetch_assoc();
        $id_persona = $row['id_persona'];
    } else {
        die("No se encontró la persona asociada.");
    }

    // Consulta para obtener las membresías
    $queryMembresias = "SELECT id_membresia, descripcion_membresia FROM MEMBRESIA";
    $resultMembresias = $conn->query($queryMembresias);

} else {
    die("No se recibió un ID de usuario válido.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacerse Socio</title>
</head>
<body>

<h2>Hacerse Socio</h2>

<!-- Formulario para seleccionar la membresía y enviarlo a registrar_socio_3.php -->
<form action="registrar_socio_3.php" method="POST">
    <label for="membresia">Seleccionar Membresía:</label>
    <select name="membresia" id="membresia" required>
        <option value="">Selecciona una membresía</option>
        <?php while ($row = $resultMembresias->fetch_assoc()) { ?>
            <option value="<?php echo $row['id_membresia']; ?>">
                <?php echo $row['descripcion_membresia']; ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    <!-- Inputs ocultos para enviar id_persona e id_complejo -->
    <input type="hidden" name="id_persona" value="<?php echo $id_persona; ?>">
    <input type="hidden" name="id_complejo" value="<?php echo $id_complejo; ?>">

    <button type="submit">Hacerse Socio</button>
</form>

</body>
</html>

<?php
// Cerrar conexión a la base de datos
$conn->close();
?>
