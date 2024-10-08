<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    die("NO hay SESION :(");
}
require_once("../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

$sql_persona = "SELECT id_persona, nombre, id_complejo, descripcion_complejo, complejo.fecha_alta, 
                (SELECT COUNT(*) FROM sucursal WHERE rela_complejo = complejo.id_complejo) AS total_sucursal
                FROM PERSONA
                JOIN asignacion_persona_complejo apc ON id_persona = apc.rela_persona
                JOIN complejo ON id_complejo = apc.rela_complejo
                JOIN contacto c ON id_persona = c.rela_persona
                JOIN usuarios u ON u.rela_contacto = c.id_contacto
                WHERE id_usuario = {$_SESSION['id_usuario']}";

if (isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];
    $condicional = " AND descripcion_complejo LIKE ?";
    $consulta = $sql_persona . $condicional;
    $parametro = "%" . $filtro . "%";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("s", $parametro);
    $stmt->execute();
    $registros = $stmt->get_result();
} else {
    $registros = $conexion->query($sql_persona);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/index.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'modules/Complejos/misComplejos/css/misComplejos.css' ?>">
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
            <div class="misComplejos">
                <div class="containerComplejo">
                    <h1>Mis Complejos</h1>
                    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="text" placeholder="Buscar Complejo..." name="filtro">
                    </form>
                    <?php if ($registros) { ?>
                        <?php foreach ($registros as $reg) : ?>
                            <div class="complejoEncontrado" valor="<?php echo $reg['id_complejo']; ?>">
                                <picture>
                                    <img src="" alt="icono">
                                </picture>
                                <h2><?php echo $reg['descripcion_complejo']; ?></h2>
                                <small>Creacion: <?php echo $reg['fecha_alta']; ?></small>
                                <p>Total de Sucursales: <?php echo $reg['total_sucursal']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="complejoEncontrado" valor="">
                            <picture>
                                <img src="" alt="icono">
                            </picture>
                            <h2><?php echo 'No se han encontrado Complejos ...'; ?></h2>
                            <small>Creacion: .........</small>
                            <p>*no se encuentra sucursales</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </main>
        <footer>
            footer
        </footer>
    </div>

    <script src="<?php echo BASE_URL . "libs/jquery-3.7.1.min.js"; ?>"></script>
    <script src="<?php echo BASE_URL . 'js/jquery-3.7.1.min.js'; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/ajaxDeportes.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/fechaFlatpickr.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/btnPerfil/js/btnPerfil.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/asideMenu/js/menuAside.js'; ?>"></script>
    <script>
        $(document).ready(function() {

            $(".complejoEncontrado").on("click", function() {
                let id_complejo = $(this).attr("valor");
                window.location.href = "<?php echo BASE_URL; ?>php/complejos/complejo.php?id_complejo=" + id_complejo;
            });

        }); //document ready
    </script>

</body>

</html>