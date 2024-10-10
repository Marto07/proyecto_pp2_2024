<?php
require_once("config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
session_start();

$deporte = isset($_GET['deporte']) ? $_GET['deporte'] : null;
$tipo_deporte = isset($_GET['tipoDeporte']) ? $_GET['tipoDeporte'] : null;
$superficie = isset($_GET['superficie']) ? $_GET['superficie'] : null;
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
$horario = isset($_GET['horario']) ? $_GET['horario'] : null;

// Empezamos a armar la consulta base
$sql = "SELECT 
                    zona.id_zona,
                    zona.descripcion_zona,
                    sucursal.descripcion_sucursal,
                    reserva.fecha_reserva,
                    IF (reserva.id_reserva IS NULL, 'disponible', 'no-disponible') AS estado
                FROM 
                    zona
                JOIN 
                    sucursal ON zona.rela_sucursal = sucursal.id_sucursal
                LEFT JOIN 
                    reserva ON reserva.rela_zona = zona.id_zona 
                              AND reserva.fecha_reserva = '$fecha' -- La fecha que pasas
                              AND reserva.rela_horario = $horario -- El horario que pasas
                WHERE
                    zona.rela_tipo_terreno = $superficie
                    AND rela_formato_deporte = $tipo_deporte
                    and id_reserva is null

                ORDER BY 
                    (zona.id_zona)";

if ($registros = $conexion->query($sql)) {
} else {
    die("error durante la consulta");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/index.css' ?>">
    <style>
        .canchasdisp {
            position: relative;
            height: 90%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .canchasdisp {
            background-color: rgb(240, 255, 255, 0.5);
            position: relative;
            height: 90%;
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .cancha {
            background-color: lightgray;
            display: flex;
            align-items: center;
            gap: 30px;
            width: 75%;
            padding: 10px;
            border: 1.5px solid grey;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.5s ease;
        }

        .cancha:not(:first-child) {
            margin-top: 10px;
        }

        .cancha:hover {
            transform: scale(1.05);
        }

        .cancha picture,
        .cancha h2 {
            pointer-events: none;
        }

        picture {
            height: 30px;
            width: 30px;
            border-radius: 50%;
        }
    </style>
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
            <div class="canchasEncontradas">
                <div class="canchasdisp">
                    <?php foreach ($registros as $reg) { ?>
                        <div class="cancha" id="<?php echo $reg['id_zona'] ?>">
                            <picture>Imagen</picture>
                            <h2><?php echo $reg['descripcion_zona'] ?></h2>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </main>
        <footer>
            footer
        </footer>
    </div>
    <script src="<?php echo BASE_URL . 'js/jquery-3.7.1.min.js'; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/ajaxDeportes.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/fechaFlatpickr.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/btnPerfil/js/btnPerfil.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/asideMenu/js/menuAside.js'; ?>"></script>
</body>

</html>