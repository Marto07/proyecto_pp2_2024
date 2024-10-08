<?php
require_once("../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
session_start();

if (isset($_GET['id_complejo'])) {
    $id_complejo = $_GET['id_complejo'];
} else {
    echo "ha ocurrido un error :(";
    die;
}

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
} else {
    $id_usuario = 8;
}

$query_complejo = "SELECT * FROM complejo WHERE id_complejo = ? AND estado IN(1)";
$stmt = $conexion->prepare($query_complejo);
$stmt->bind_param("i", $id_complejo);
$stmt->execute();
$registros = $stmt->get_result();

foreach ($registros as $reg) {
    $descripcion_complejo = $reg['descripcion_complejo'];
    $fecha_alta = $reg['fecha_alta'];
}

$query_sucursal = "SELECT * FROM sucursal WHERE rela_complejo = ? AND estado IN(1)";
$stmt = $conexion->prepare($query_sucursal);
$stmt->bind_param("i", $id_complejo);
$stmt->execute();
$registros_sucursal = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/index.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'modules/Complejos/indexComplejo/css/indexComplejos.css' ?>">
</head>

<body>
    <div class="container">
        <header>
            <?php include(RUTA . 'modules/header/tituloWeb/php/tituloWeb.php'); ?>
            <?php include(RUTA . 'modules/header/filtroBusqueda/php/filtroBusqueda.php'); ?>
            <?php include(RUTA . 'modules/header/btnPerfil/php/btnPerfil.php'); ?>
        </header>
        <main>
            <?php include(RUTA . 'modules/asideMenu/php/asideMenu.php'); ?>
            <div class="indexComplejo">
                <div class="complejocontainer">
                    <div class="complejoImg"></div>
                    <div class="complejoDescripcion">
                        <h3><?php echo $descripcion_complejo; ?></h3>
                        <h3>Fecha de Creacion: <?php echo $fecha_alta; ?></h3>
                        <a href="hacerse_socio.php?id_usuario=<?php echo $id_usuario; ?>&id_complejo=<?php echo $id_complejo; ?>">Hazte Socios!</a>
                    </div>
                    <div class="complejoSucursales">
                        <?php foreach ($registros_sucursal as $reg) : ?>
                            <div class="complejoSucursal" id="<?php echo $reg['id_sucursal']; ?>">
                                <h3><?php echo $reg['descripcion_sucursal']; ?></h3>
                                <h5><?php echo $reg['direccion']; ?></h5>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="altas" align="center">
                        <a href="<?php echo BASE_URL . "php/socio/tabla_socios.php?id_complejo=$id_complejo"; ?>">Gestionar Socios</a>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <h2>footer</h2>
        </footer>
    </div>
    <script src="<?php echo BASE_URL . 'js/jquery-3.7.1.min.js'; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/ajaxDeportes.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/fechaFlatpickr.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/btnPerfil/js/btnPerfil.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/asideMenu/js/menuAside.js'; ?>"></script>
    <script>
        $(document).ready(function() {
            $('.complejoSucursal').on('click', function() {
                let idSucursal = $(this).attr("id");
                alert(idSucursal);
                window.location.href = "<?php echo BASE_URL; ?>php/sucursales/sucursal.php" + "?id_sucursal=" + idSucursal;
            });
        }); ///document ready
    </script>

</body>

</html>