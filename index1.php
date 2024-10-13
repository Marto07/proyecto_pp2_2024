<?php 
    require_once("config/root_path.php");       
    require_once(RUTA . "config/database/conexion.php");
    require_once(RUTA . "config/database/db_functions/personas.php");
    require_once(RUTA . "php/functions/controlar_acceso.php");
    session_start(); 

    $deporte = $conexion->query("SELECT id_deporte, descripcion_deporte FROM deporte");

    $superficie = $conexion->query("SELECT id_tipo_terreno, descripcion_tipo_terreno FROM tipo_terreno");

    $horario = $conexion->query("SELECT id_horario, horario_inicio, horario_fin FROM horario");

    $sucursales = [1,2,3];
    $sucursales_imploded = implode(",", $sucursales);

    $query_notificacion = "SELECT * FROM notificacion WHERE estado = 'no leido' AND rela_sucursal IN($sucursales_imploded)";

    $resultado = $conexion->query($query_notificacion);

    $hay_notificacion = $resultado->num_rows > 0;
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="maquetado inicio/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <!-- Header + Hero envueltos en una sección para hacer que el carrusel sea su fondo -->
    <section class="hero-container">
        <div class="carrusel-container">
            <div class="carrusel-slide">
                <img src="maquetado inicio/carrusel_2.jpg" alt="">
                <img src="maquetado inicio/carrusel_3.jpg" alt="">
                <img src="maquetado inicio/carrusel_4.jpg" alt="">
            </div>
        </div>
        <header>
            <button class="menu-btn" id="toggle-menu">☰</button>

            <?php if (isset($_SESSION)) {?>

                    <div class="profile-menu"> <!-- PROFILE -->
                        <button class="profile-btn">Mi Perfil</button>
                        <ul class="profile-dropdown">
                            <li><a href="#">Ver Perfil</a></li>
                            <li><a href=""<?php if ($hay_notificacion) {echo 'class="hay-notificacion"';} ?>>Notificaciones</a></li>
                            <li><a href="#">Configuraciones</a></li>
                            <li><a href="#">Cerrar Sesión</a></li>
                        </ul>
                    </div>

            <?php } else {?>    
                <button class="register-btn">Registrarse</button>
            <?php } ?>
        </header>
        <?php include(RUTA."includes/menu_aside.php") ?>

        <section class="hero">

            <div class="search-container">
                <select name="deporte" id="deporte">
                    <option value="" disabled selected>Deporte</option>
                        <?php foreach ($deporte as $reg) :?>
                            <option value="<?= $reg['id_deporte'] ?>"><?= $reg['descripcion_deporte'] ?></option>
                        <?php endforeach; ?>
                </select>

                <select name="tipoDeporte" id="tipoDeporte">
                    <option value="">Tipo de deporte</option>
                </select>

                <input type="text" id="fecha" name="fecha" placeholder="fecha">
                <select name="horario" id="horario">
                    <option value="" disabled selected>Hora</option>
                        <?php foreach ($horario as $reg) :?>
                            <option value="<?= $reg['id_horario'] ?>"><?= $reg['horario_inicio'] ?></option>
                        <?php endforeach; ?>

                </select>
                <button class="search-btn">Buscar</button>
            </div>

        </section>
    </section>

    <section class="info-section">
        <p>Regístrate a nuestra página y accede a nuestros servicios de reservas y gestión de canchas</p>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/es.js"></script>
    <script>
        $(document).ready(function () {
            let images = $('.carrusel-slide img');
            let currentIndex = 0;

            function showNextImage() {
                images.eq(currentIndex).removeClass('active');
                currentIndex = (currentIndex + 1) % images.length;
                images.eq(currentIndex).addClass('active');
            }

            $("#deporte").on("change", function() {
                id_deporte = $(this).val();
                $.ajax({
                    url: '<?= BASE_URL . "includes/ajax/formato_deporte.php"?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {id_deporte: id_deporte},
                    success: function(data) {
                        $('#tipoDeporte').empty();
                        $('#tipoDeporte').append('<option value="" disabled selected>Tipo de deporte</option>');

                        $.each(data, function (index,formato_deporte) {
                             $('#tipoDeporte').append('<option value="' + formato_deporte.id_formato_deporte + '">' + formato_deporte.descripcion_formato_deporte + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("error al cargar los tipos de deporte: ", error);
                    }
                });

            });

            flatpickr("#fecha", {
                dateFormat: "Y-m-d",  // Formato de fecha almacenado
                minDate: "today",     // Hoy como la fecha mínima
                maxDate: new Date().fp_incr(7),  // 7 días hacia adelante desde hoy
                defaultDate: "today", // Preselecciona la fecha de hoy
                altInput: true,
                altFormat: "F j, Y",  // Formato alternativo que se muestra
                allowInput: false,     // Evita que el usuario escriba manualmente
            });

            setInterval(showNextImage, 7000);
            images.eq(currentIndex).addClass('active');
        });
    </script>
    <script>
        $(document).ready(function () {
            const $menu = $("#aside-menu");
            const $toggleButton = $("#toggle-menu");

            // Mostrar/Ocultar el menú cuando se hace clic en el botón
            $toggleButton.on("click", function () {
                $menu.toggleClass("active");
                // $(this).hide(); 
            });

            // Cerrar el menú al hacer clic fuera de él
            $(document).on("click", function (e) {
                if (!$menu.is(e.target) && !$menu.has(e.target).length && !$toggleButton.is(e.target)) {
                    $menu.removeClass("active");
                    $toggleButton.show(); // Mostrar el botón de nuevo
                }
            });

        });
    </script>
</body>
</html>
