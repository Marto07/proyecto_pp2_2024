<?php  
    $sucursales = [1,2,3];
    $sucursales_imploded = implode(",", $sucursales);

    $query_notificacion = "SELECT * FROM notificacion WHERE estado = 'no leido' AND rela_sucursal IN($sucursales_imploded)";

    $resultado = $conexion->query($query_notificacion);

    $hay_notificacion = $resultado->num_rows > 0;
?>
<header>
    <a href="<?php echo BASE_URL . 'index2.php' ?>" style="text-decoration: none;">
        <div class="titulo_inicio">
            <img src="<?php echo BASE_URL. "assets/icons/juego.png" ?>" alt="icono inicio">
            <h2>SportPlanner</h2>
        </div>
    </a>

    <div class="profile-dropdown">
        <div onclick="toggle()" class="profile-dropdown-btn">
            <div class="profile-img">
                <!-- Imagen de perfil aquí -->
            </div>
            <span style="width: max-content;"><?php echo $_SESSION['usuario']; ?>
                <i class="fa-solid fa-angle-down"></i>
            </span>
        </div>

        <ul class="profile-dropdown-list">
            <li class="profile-dropdown-list-item">
                <a href="<?php echo BASE_URL; ?>login/miPerfil/mis_datos.php">
                    <i class="fa-regular fa-user"></i>
                    Perfil
                </a>
            </li>

            <li class="profile-dropdown-list-item" id="notificaciones">
                <a href="" id="notificaciones-btn">
                    <?php if ($hay_notificacion) { ?>
                        <i class="fa-solid fa-envelope"></i>
                    <?php } else { ?>
                        <i class="fa-solid fa-envelope-open"></i>
                    <?php } ?>
                    Notificaciones
                </a>
                <!-- Contenedor para la sublista -->
                <div class="notifications-dropdown">
                    <!-- Sublista oculta para notificaciones -->
                    <ul class="sub-notifications-list">
                        <li>Notificación 1</li>
                        <li>Notificación 2</li>
                        <li>Notificación 3</li>
                        <li>Notificación 4</li>
                        <li>Notificación 5</li>
                    </ul>
                </div>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="<?php echo BASE_URL . 'modules/misReservasUsuario/misReservas.php' ?>">
                    <i class="fa-solid fa-futbol"></i>
                    Mis Reservas
                </a>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="#">
                    <i class="fa-solid fa-toggle-off"></i>
                    Modo Oscuro
                </a>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="#">
                    <i class="fa-regular fa-circle-question"></i>
                    Ayuda
                </a>
            </li>
            <hr />

            <li class="profile-dropdown-list-item">
                <a href="<?php echo BASE_URL. "login/cerrar_sesion.php" ?>">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Cerrar Sesión
                </a>
            </li>
        </ul>
    </div>
</header>