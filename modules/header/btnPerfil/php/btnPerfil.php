<?php
$sucursales = [1, 2, 3];
$sucursales_imploded = implode(",", $sucursales);

$query_notificacion = "SELECT * FROM notificacion WHERE estado = 'no leido' AND rela_sucursal IN($sucursales_imploded)";

$resultado = $conexion->query($query_notificacion);

$hayNotificacion = $resultado->num_rows > 0;
?>

<div class="profile-dropdown">
    <div onclick="toggle()" class="profile-dropdown-btn">
        <div class="profile-img">
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

        <li class="profile-dropdown-list-item">
            <a href="#" <?php if ($hayNotificacion) {
                            echo 'style="background-color:red" class="hayNotificacion"';
                        } ?>>
                <i class="fa-regular fa-envelope"></i>
                Notificacion
            </a>
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
            <a href="#">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                Cerrar Sesion
            </a>
        </li>
    </ul>
</div>