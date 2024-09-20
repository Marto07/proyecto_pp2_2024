        <header>
            <div class="titulo_inicio">
                <img src="../../../../assets/icons/icono22.png" alt="icono inicio">
                <h2>Sportolanner</h2>
            </div>

            <!-- Botón que aparece en pantallas pequeñas -->
            <button id="open-modal-btn" class="open-modal-btn" style="display: none;" onclick="openModal()">Buscar
                Cancha</button>

            <!-- Formulario de filtro que será contenido del modal en pantallas pequeñas -->
            <form id="filtro_deporte">
                <!-- Selección del deporte -->
                <div class="form_filtro">
                    <label for="deporte">Deporte:</label>
                    <select id="deporte" name="deporte" onchange="updateTipoDeporte()">
                        <option value="futbol">Fútbol</option>
                        <option value="voley">Vóley</option>
                        <option value="basquet">Básquet</option>
                    </select>
                </div>

                <!-- Tipo de deporte dinámico -->
                <div class="form_filtro" id="tipo-deporte-container" style="display: none;">
                    <label for="tipoDeporte">Formato:</label>
                    <select id="tipoDeporte" name="tipoDeporte">
                        <!-- Se llenará dinámicamente según el deporte -->
                    </select>
                </div>

                <!-- Selección de la superficie -->
                <div class="form_filtro">
                    <label for="superficie">Superficie:</label>
                    <select id="superficie" name="superficie">
                        <option value="cesped">Césped</option>
                        <option value="piso">Piso</option>
                        <option value="sintetico">Sintético</option>
                    </select>
                </div>

                <!-- Selección de la fecha -->
                <div class="form_filtro">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha">
                </div>

                <!-- Selección de la hora -->
                <div class="form_filtro">
                    <label for="hora">Hora:</label>
                    <input type="time" id="hora" name="hora">
                </div>

                <button type="submit">Buscar Partido</button>
            </form>

            <!-- Modal -->
            <div id="filter-modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3>Filtrar Deportes</h3>
                    <!-- Aquí se carga el formulario de filtros -->
                    <form id="filtro_deporte_modal"></form>
                </div>
            </div>

            <div class="profile-dropdown">
                <div onclick="toggle()" class="profile-dropdown-btn">
                    <div class="profile-img">
                    </div>

                    <span>Lionel Messi
                        <i class="fa-solid fa-angle-down"></i>
                    </span>
                </div>

                <ul class="profile-dropdown-list">
                    <li class="profile-dropdown-list-item">
                        <a href="<?php echo BASE_URL; ?>login/miPerfil/mis_datos.php">
                            <i class="fa-regular fa-user"></i>
                            Mi Perfil
                        </a>
                    </li>

                    <li class="profile-dropdown-list-item">
                        <a href="#">
                            <i class="fa-regular fa-envelope"></i>
                            Notificacion
                        </a>
                    </li>

                    <li class="profile-dropdown-list-item">
                        <a href="#">
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
                        <a href="<?php echo BASE_URL; ?>login/cerrar_sesion.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Cerrar Sesion
                        </a>
                    </li>
                </ul>
            </div>
            <script>
                let profileDropdownList = document.querySelector(".profile-dropdown-list");
                let btn = document.querySelector(".profile-dropdown-btn");

                let classList = profileDropdownList.classList;

                const toggle = () => classList.toggle("active");

                window.addEventListener("click", function (e) {
                    if (!btn.contains(e.target)) classList.remove("active");
                });
            </script>
        </header>