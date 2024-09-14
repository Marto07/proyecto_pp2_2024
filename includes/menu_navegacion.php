<header>
        <div class="menu">
            <img src="<?php echo BASE_URL; ?>assets/icons/prototipo_logo-Photoroom.png"  width="60px" height="60px">

            <ul class="cont-ul">

                <li><a href="#">reclamos</a></li>
                <li><a href="#">vistas</a></li>
                <li><a href="<?php echo BASE_URL . 'php/reservas/reserva_de_usuario/formularioReserva1.php' ?>">Reservar</a></li>
                <li><a href="<?php echo BASE_URL . 'php/reservas/reserva_de_personal_administrativo/formularioReserva1.php' ?>">Reservarle</a></li>  
                <li><a href="#">Gestion del Sistema</a>
                    <ul>
                        <li><a href="#">Personas</a>
                            <ul>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/Sexo/tablaSexos.php">sexo</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/TipoDocumento/tabla_tipo_documentos.php">tipo documento</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/TipoContacto/tablaTipoContactos.php">tipo contacto</a></li>
                            </ul>
                        </li>
                        <li><a href="#">zona</a>
                            <ul>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/Deportes/tablaDeportes.php">Deporte</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/FormatoDeporte/tablaFormatoDeportes.php">Formato Deporte</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/Servicio/tablaServicios.php">Servicio</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/TipoTerreno/tablaTipoTerrenos.php">Tipo Terreno</a></li>
                            </ul>
                        </li>
                        <li><a href="#">domicilio</a>
                            <ul>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/Provincia/tablaProvincias.php">Provincia</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/Localidad/tablaLocalidades.php">Localidad</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/Barrio/tablaBarrios.php">Barrio</a></li>
                            </ul>
                        </li>
                        <li><a href="#">reserva</a>
                            <ul>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/EstadoReserva/tablaEstadoReserva.php">Estado Reserva</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/TablasMaestras/EstadoControl/tablaEstadoControl.php">Estado Control</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/reservas/reserva_de_usuario/formularioReserva1.php">Reservar</a></li>
                                <li><a href="<?php echo BASE_URL; ?>php/reservas/reserva_de_personal_administrativo/formularioReserva1.php">Reservar a un cliente</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo BASE_URL; ?>php/modulosPorPerfil/index.php">Permisos</a></li>
                        <?php if ($registros->num_rows > 0) {echo '<li><a href="#">Mis Canchas</a></li>';} ?>
                    </ul>
                </li>
            </ul>

        </div>

        <div class="profile-menu">
            <button class="profile-button">Mi Perfil</button>
            <ul class="profile-dropdown">
                <li><a href="<?php echo BASE_URL; ?>login/miPerfil/mis_datos.php">Mis Datos</a></li>
                <li><a href="<?php echo BASE_URL; ?>login/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>

    </header>