<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "config/database/db_functions/personas.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();

$modulo = "Inicio";
$perfil = $_SESSION['perfil'];
validarAcceso($modulo, $perfil);

$id_usuario = $_SESSION['id_usuario'];
$registros = obtenerPersonaPorUsuario($id_usuario);

if ($reg = $registros->fetch_assoc()) {
    $id_persona = $reg['id_persona'];
}

//esta funcion seria para darle acceso si tiene complejo a su nombre
function obtenerAcessoGestionCanchas($id_persona)
{
    global $conexion;

    $sql = "SELECT 
                    zona.id_zona,
                    zona.descripcion_zona,
                    persona.nombre,
                    persona.apellido
                    FROM asignacion_persona_complejo apc
                    JOIN complejo ON apc.rela_complejo = complejo.id_complejo
                    JOIN sucursal ON sucursal.rela_complejo = complejo.id_complejo
                    JOIN zona ON zona.rela_sucursal = sucursal.id_sucursal
                    JOIN persona ON persona.id_persona = apc.rela_persona
                    WHERE apc.rela_persona = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_persona);
    $registros = [];

    if ($stmt->execute()) {
        $registros = $stmt->get_result();
        return $registros;
    }
}

if ($registros = obtenerAcessoGestionCanchas($id_persona)) {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'modules/inicio/css/inicio.css' ?>">
</head>

<body>
    <div class="contenedor_banner">
        <div class="parte1">
            <?php include(RUTA . 'modules/asideMenu/php/asideMenu.php'); ?>

            <?php include(RUTA . 'modules/header/btnPerfil/php/btnPerfil.php'); ?>

            <?php include(RUTA . 'modules/header/filtroBusqueda/php/filtroBusqueda.php'); ?>

            <div class="nombre_pagina">
                <h1>Sportsplanner</h1>
                <img src="../../../assets/icons/icono22.png">
            </div>

            <div class="nosotros_pagina">
                <h1>Reserva y gestiona tus turnos, gestiona las reserva de las anchas y ganancias con nuestra plataforma
                    intuitiva!</h1>
            </div>

            <div class="redes_pagina">
                <div class="social_icons">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-youtube"></i>
                    <i class="fa-brands fa-instagram"></i>
                </div>
            </div>
        </div>
        <div class="parte2">
        </div>
    </div>
</body>
<script src="<?php echo BASE_URL . 'js/jquery-3.7.1.min.js'; ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="<?php echo BASE_URL . 'modules/inicio/js/inicio.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'modules/inicio/js/ajaxDeporte.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/fechaFlatpickr.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'modules/header/btnPerfil/js/btnPerfil.js'; ?>"></script>
<script src="<?php echo BASE_URL . 'modules/asideMenu/js/menuAside.js'; ?>"></script>

</html>