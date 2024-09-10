<?php
session_start();
$_SESSION['id_usuario'] = 11;
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "proyecto_pp2";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Variables para almacenar la selección de complejo, sucursal y zonas
$selectedComplejo = $selectedSucursal = $selectedZona = "";

// Si se ha enviado el formulario (se seleccionó un complejo o sucursal)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['complejo'])) {
        $selectedComplejo = $_POST['complejo'];
        
        // Consulta para obtener sucursales basadas en el complejo seleccionado
        $querySucursal = $conn->prepare("SELECT id_sucursal, descripcion_sucursal FROM sucursal WHERE rela_complejo = ?");
        $querySucursal->bind_param("i", $selectedComplejo);
        $querySucursal->execute();
        $resultSucursal = $querySucursal->get_result();
    }

    if (isset($_POST['sucursal'])) {
        $selectedSucursal = $_POST['sucursal'];

        $a="SELECT id_zona, descripcion_zona, t.precio FROM ZONA z
                                        JOIN servicio s
                                        ON s.id_servicio = z.rela_servicio
                                        JOIN asignacion_tarifa_servicio ats
                                        ON  ats.rela_servicio = s.id_servicio
                                        JOIN tarifa t
                                        ON t.id_tarifa = ats.rela_tarifa
                                        LEFT JOIN 
                                            socio s ON s.rela_persona = p.id_persona 
                                            AND s.rela_sucursal = z.rela_sucursal
                                        JOIN persona p
                                        ON p.id_persona = s.rela_persona
                                        WHERE z.rela_sucursal = ?
                                        AND p.id_persona=15 ";

        $consulta_original="SELECT id_zona, descripcion_zona, t.precio FROM ZONA z
                                        JOIN servicio s
                                        ON s.id_servicio = z.rela_servicio
                                        JOIN asignacion_tarifa_servicio ats
                                        ON  ats.rela_servicio = s.id_servicio
                                        JOIN tarifa t
                                        ON t.id_tarifa = ats.rela_tarifa
                                        WHERE z.rela_sucursal = ?";                             
        // Consulta para obtener zonas basadas en la sucursal seleccionada
        $queryZona = $conn->prepare("SELECT 
                z.id_zona, 
                z.descripcion_zona, 
                t.precio,
                CASE 
                    -- Si la persona es socia, aplicar el descuento
                    WHEN so.id_socio IS NOT NULL THEN t.precio - (t.precio * (m.beneficio_membresia / 100))
                    -- Si no es socia, mantener el precio base
                    ELSE t.precio 
                END AS precio_total
            FROM 
                ZONA z
            JOIN 
                servicio s ON s.id_servicio = z.rela_servicio
            JOIN 
                asignacion_tarifa_servicio ats ON ats.rela_servicio = s.id_servicio
            JOIN 
                tarifa t ON t.id_tarifa = ats.rela_tarifa
            JOIN
                sucursal su ON z.rela_sucursal = su.id_sucursal
            LEFT JOIN 
                socio so ON so.rela_persona = ? AND so.rela_complejo = su.rela_complejo
            LEFT JOIN 
                membresia m ON so.rela_membresia = m.id_membresia
            WHERE 
                z.rela_sucursal = ?");
        $idPersona = 17;
        $queryZona->bind_param("ii", $idPersona,$selectedSucursal);
        $queryZona->execute();
        $resultZona = $queryZona->get_result();
    }
}

// Consulta inicial para obtener los complejos deportivos
$queryComplejo = "SELECT id_complejo, descripcion_complejo FROM complejo";
$resultComplejo = $conn->query($queryComplejo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Complejo, Sucursal y Zona</title>
</head>
<body>

<!-- Formulario para seleccionar el complejo -->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label for="complejo">Seleccionar Complejo Deportivo:</label>
    <select name="complejo" id="complejo" onchange="this.form.submit()">
        <option value="">Selecciona un complejo</option>
        <?php while ($row = $resultComplejo->fetch_assoc()) { ?>
            <option value="<?php echo $row['id_complejo']; ?>" <?php if ($selectedComplejo == $row['id_complejo']) echo 'selected'; ?>>
                <?php echo $row['descripcion_complejo']; ?>
            </option>
        <?php } ?>
    </select>
</form>

<?php if (!empty($selectedComplejo)) { ?>
    <!-- Botón para hacerse socio una vez que se selecciona un complejo -->
    <a href="hacerse_socio_2.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>&id_complejo=<?php echo $selectedComplejo; ?>" class="btn">
        Hacerse Socio
    </a>

    <!-- Formulario para seleccionar la sucursal -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="hidden" name="complejo" value="<?php echo $selectedComplejo; ?>">
        <label for="sucursal">Seleccionar Sucursal:</label>
        <select name="sucursal" id="sucursal" onchange="this.form.submit()">
            <option value="">Selecciona una sucursal</option>
            <?php while ($row = $resultSucursal->fetch_assoc()) { ?>
                <option value="<?php echo $row['id_sucursal']; ?>" <?php if ($selectedSucursal == $row['id_sucursal']) echo 'selected'; ?>>
                    <?php echo $row['descripcion_sucursal']; ?>
                </option>
            <?php } ?>
        </select>
    </form>
<?php } ?>

<?php if (!empty($selectedSucursal)) { ?>
    <!-- Mostrar las zonas relacionadas con la sucursal seleccionada -->
    <h2>Zonas Relacionadas:</h2>
    <ul>
        <?php while ($row = $resultZona->fetch_assoc()) { ?>
            <li><?php echo $row['descripcion_zona']. " - precio original: $". $row['precio']. " - Precio con descuento: $". $row['precio_total']; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

</body>
</html>

<?php
// Cerrar conexión a la base de datos
$conn->close();
?>
