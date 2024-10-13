<?php   
    require_once("config/root_path.php");
    require_once(RUTA . "config/database/conexion.php");
    require_once(RUTA . "config/database/db_functions/personas.php");
    require_once(RUTA . "php/functions/controlar_acceso.php");
    session_start();

    $modulo = "Inicio";
    $perfil = $_SESSION['perfil'];
    validarAcceso($modulo, $perfil);

    





/* 
        if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_perfil'])) {
            header("Location: error403.php");
            exit();
        }
        $sql_acceso = "SELECT COUNT(*) AS tiene_acceso
                        FROM 
                            asignacion_perfil_modulo asp
                        JOIN 
                            perfil p 
                        ON 
                            asp.rela_perfil = p.id_perfil
                        JOIN 
                            modulo m ON asp.rela_modulo = m.id_modulo
                        WHERE 
                            p.descripcion_perfil 
                        LIKE 
                            '{$_SESSION['perfil']}' 
                        AND 
                            m.descripcion_modulo 
                        LIKE 
                            '{$modulo}'";

        $resultado = $conexion->query($sql_acceso);

        if ($reg = $resultado->fetch_assoc()) {
            if ($reg['tiene_acceso'] == 0) {
                header("Location: error403.php");
                exit();
            }
        }
*/


 
    



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="<?php echo BASE_URL. 'css/aside/menu_aside_beterette.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL. 'css/header.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        * {
            padding:0;
            margin:0;
        }
        /* CONTENEDOR PRINCIPAL */
        main {
/*            padding: 20px;*/
        }

        /* CARRUSEL */
        .carousel-container {
            width: 100%;
/*            max-width: 800px;*/
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        .carousel-slide {
            position: relative;
            display: flex;
            width: 100%;
            height: 600px; /* Altura fija del carrusel */
        }

        .carousel-slide img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel-slide img.active {
            opacity: 1;
        }
        
        .flatpickr-calendar {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .flatpickr-day {
            border-radius: 50%;
            transition: background-color 0.3s, color 0.3s;
        }

        .flatpickr-day:hover, .flatpickr-day.selected {
            background-color: #007bff;
            color: #fff;
        }

    </style>
</head>
<body>
    <?php include(RUTA. 'includes/header_tincho.php'); ?>
    <?php include(RUTA. 'includes/menu_aside_beterette.php'); ?>
    <main>
        <!-- CARRUSEL -->
        <div class="carousel-container">
            <div class="carousel-slide">
                <img src="<?php echo BASE_URL . "assets/img/carrusel_2.jpg"; ?>" alt="Imagen 1">
                <img src="<?php echo BASE_URL . "assets/img/carrusel_3.jpg"; ?>" alt="Imagen 2">
                <img src="<?php echo BASE_URL . "assets/img/carrusel_4.jpg"; ?>" alt="Imagen 3">
            </div>
        </div>
    </main>
<script src="js/jquery-3.7.1.min.js"></script>
<script src="<?php echo BASE_URL . "js/carrusel.js"; ?>"></script>
<script>
    $(document).ready(function () {

        flatpickr("#fecha", {
            dateFormat: "Y-m-d",  // Formato de fecha almacenado
            minDate: "today",     // Hoy como la fecha mínima
            maxDate: new Date().fp_incr(7),  // 7 días hacia adelante desde hoy
            defaultDate: "today", // Preselecciona la fecha de hoy
            altInput: true,
            altFormat: "F j, Y",  // Formato alternativo que se muestra
            allowInput: false     // Evita que el usuario escriba manualmente
        });

    });//document ready

</script>
</body>
</html>
