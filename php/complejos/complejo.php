<?php 
    require_once("../../config/root_path.php");
    $conexion = new mysqli("localhost","root","","proyecto_pp2");
    session_start();

    if (isset($_GET['id_complejo'])) {
        $id_complejo = $_GET['id_complejo'];
    } else {
        echo "ha ocurrido un error :(";
        die;
    }

    if(isset($_GET['id_usuario'])) {
        $id_usuario = $_GET['id_usuario'];
    } else {
        $id_usuario = 8;
    }

    $query_complejo = "SELECT * FROM complejo WHERE id_complejo = ? AND estado IN(1)";
    $stmt = $conexion->prepare($query_complejo);
    $stmt->bind_param("i",$id_complejo);
    $stmt->execute();
    $registros = $stmt->get_result();

    foreach ($registros as $reg) {
        $descripcion_complejo = $reg['descripcion_complejo'];
        $fecha_alta = $reg['fecha_alta'];
    }

    $query_sucursal = "SELECT * FROM sucursal WHERE rela_complejo = ? AND estado IN(1)";
    $stmt = $conexion->prepare($query_sucursal);
    $stmt->bind_param("i",$id_complejo);
    $stmt->execute();
    $registros_sucursal = $stmt->get_result();


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportplanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style type="text/css">
       /* Estilos generales */
        * {
          font-family: Arial, sans-serif;
        }

        body {
          background-color: lightgreen;
        }

        /* Contenedores principales */
        .indexComplejo {
          position: relative;
          height: 90%;
          width: 100%;
          overflow: auto;
        }

        .complejocontainer {
          background-color: white;
          margin: 20px auto;
          width: 65%;
          min-height: 500px;
          overflow: auto;
        }

        /* Imagen y descripción del complejo */
        .complejoImg {
          margin: 20px auto;
          width: 70%;
          background-color: black;
          height: 160px;
        }

        .complejoDescripcion {
          display: flex;
          padding: 15px;
          align-items: center;
          justify-content: space-evenly;
        }

        .complejoDescripcion a {
          color: white;
          text-decoration: none;
          background-color: rgb(101, 209, 101);
          padding: 10px;
          border-radius: 5px;
        }

        /* Sucursales del complejo */
        .complejoSucursales {
          margin: 35px auto 20px;
          width: 70%;
          border: 2px solid lightgray;
          background-color: rgb(241, 230, 230);
          padding: 10px;
          border-radius: 10px;
        }

        .complejoSucursal {
          display: flex;
          justify-content: space-between;
          padding: 10px;
          border: 3px solid gray;
          background-color: lightgray;
          border-radius: 10px;
          transition: background-color 0.3s ease;
        }

        .complejoSucursal:hover {
          cursor: pointer;
          background-color: lightslategray;
        }

        .complejoSucursal:not(:first-child) {
          margin-top: 20px;
        }

        /* Header */
        header {
          background-color: rgba(55, 176, 68, 0.4);
          display: flex;
          align-items: center;
          justify-content: space-evenly;
          height: 13%;
          width: 100%;
          border-radius: 0 0 10px 10px;
        }

        /* Filtro de búsqueda */
        #filtro_deporte {
          width: 60%;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 10px;
        }

        .form_filtro label {
          font-weight: bold;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
        }

        .form_filtro select,
        .form_filtro input[type="date"],
        .form_filtro input[type="time"] {
          width: 120px;
          height: 40px;
          text-align: center;
          border-radius: 10px;
          border: none;
          padding: 8px 2px;
          margin: 2px 10px 10px 0;
          cursor: pointer;
        }

        #filtro_deporte button {
          padding: 8px;
          background-color: white;
          color: #427a35;
          font-weight: 500;
          border: none;
          border-radius: 10px;
          font-size: 16px;
          cursor: pointer;
          margin: 16px 2px 0;
          text-align: center;
          transition: all 0.5s ease;
        }

        #filtro_deporte button:hover {
          background-color: #218838;
          color: white;
          transform: scale(1.05);
        }

        /* Menú desplegable */
        .menu-btn {
          position: absolute;
          top: 5px;
          left: 5px;
          font-size: 24px;
          background: rgba(129, 40, 29, 0.6);
          padding: 10px;
          border: none;
          border-radius: 50%;
          cursor: pointer;
          z-index: 10;
        }

        .menu_desplegable {
          position: absolute;
          top: 0;
          left: -300px;
          width: 250px;
          height: 100%;
          background-color: rgba(99, 156, 84, 0.8);
          color: white;
          padding-top: 0;
          z-index: 5;
          border-radius: 0 10px 10px 0;
          transition: left 0.5s;
          overflow: auto;
        }

        .menu_desplegable.active {
          left: 0;
        }

        .menu_desplegable p {
          background-color: rgba(99, 156, 84, 0.8);
          font-weight: 500;
          text-align: center;
          margin: 15px 0 10px;
        }

        .menu_desplegable ul {
          list-style: none;
          padding: 0;
        }

        .menu_desplegable ul li {
          padding: 4px;
          transition: all 0.5s ease;
        }

        .menu_desplegable ul li a {
          color: white;
          text-decoration: none;
          display: block;
          padding: 10px 15px;
          transition: all 0.5s ease;
          border-radius: 10px;
        }

        .menu_desplegable ul li a:hover {
          background-color: rgba(255, 255, 255, 0.7);
          color: rgb(99, 156, 84);
          padding-left: 30px;
        }

        .submenu {
          max-height: 0;
          overflow: hidden;
          padding-left: 15px;
          background-color: rgba(255, 255, 255, 0.7);
          border-radius: 10px;
          transition: max-height 0.5s ease-out;
        }

        .submenu li {
          border-radius: 10px;
        }

        .submenu a {
          background-color: rgb(99, 156, 84);
          color: rgba(255, 255, 255, 0.7);
          padding-left: 30px;
          transition: background-color 0.5s ease, padding-left 0.5s ease;
        }

        .submenu-active .submenu {
          max-height: 300px;
        }

        /* Título inicio */
        .titulo_inicio {
          display: flex;
          justify-content: center;
          align-items: center;
          border-radius: 5px;
          cursor: pointer;
          transition: all 0.5s ease;
        }

        .titulo_inicio:hover {
          color: aqua;
          transform: scale(1.05);
        }

        .titulo_inicio img,
        .titulo_inicio h2 {
          pointer-events: none;
          transition: all 0.5s ease;
        }

        .titulo_inicio img {
          height: 30px;
          width: 25px;
          margin-bottom: 8px;
        }

    </style>
</head>

<body>
    <div class="conteiner_index">
        <div class="background_index">
            <header>
                <div class="titulo_inicio">
                    <h2>Sportolanner</h2>
                </div>

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

            </header>
            <main>
                <div class="main_conteiner">
                    <!-- Botón para abrir el menú -->
                    <button id="toggle-menu" class="menu-btn">☰</button>

                    <!-- Menú lateral -->
                    <aside class="menu_desplegable" id="menu">
                        <ul>
                            <li><a href="#">Torneo</a></li>
                            <li><a href="#">Buscar Rival</a></li>
                            <p>administrador</p>
                            <li><a href="#">Dashboard</a></li>
                            <li>
                                <a href="#" class="has-submenu">Reservas</a>
                                <ul class="submenu">
                                    <li><a href="#">Ver reservas</a></li>
                                    <li><a href="#">Realizar Reserva</a></li>
                                    <li><a href="#">Marketing</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="has-submenu">Socios</a>
                                <ul class="submenu">
                                    <li><a href="#">Ver Socios</a></li>
                                    <li><a href="#">Notificar Socio</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Empleados</a></li>
                            <li><a href="#">Reclamos</a></li>
                            <li>
                                <a href="#" class="has-submenu">Modulos</a>
                                <ul class="submenu">
                                    <li><a href="#">Personas</a></li>
                                    <li><a href="#">Zonas</a></li>
                                </ul>
                            </li>
                        </ul>
                    </aside>

                    <div class="indexComplejo">
                        <div class="complejocontainer">

                            <div class="complejoImg"></div>

                            <div class="complejoDescripcion">
                                <h3><?php echo $descripcion_complejo; ?></h3>
                                <h3>Fecha de Creacion: <?php echo $fecha_alta; ?></h3>
                                <a href="hacerse_socio.php?id_usuario=<?php echo $id_usuario; ?>&id_complejo=<?php echo $id_complejo; ?>">Hazte Socios!</a>
                            </div>

                            <div class="complejoSucursales">

                                <?php foreach ($registros_sucursal as $reg) :?>
                                
                                    <div class="complejoSucursal" id="<?php echo $reg['id_sucursal'];?>">
                                        <h3><?php echo $reg['descripcion_sucursal']; ?></h3>
                                        <h5><?php echo $reg['direccion']; ?></h5>
                                    </div>

                                <?php endforeach; ?>

                            </div>

                            <div class="altas" align="center" style="">
                                <a href="<?php echo BASE_URL . "php/socio/tabla_socios.php?id_complejo=$id_complejo"; ?>">Gestionar Socios</a>
                            </div>

                        </div>
                    </div>

                    <footer style="background-color: antiquewhite;">
                        <h2>footer</h2>
                    </footer>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.complejoSucursal').on('click', function () {

                let idSucursal = $(this).attr("id");
                alert(idSucursal);
                window.location.href = "<?php echo BASE_URL; ?>php/sucursales/sucursal.php" + "?id_sucursal=" + idSucursal;
            });

            $('.menu-btn').click(function() {
              // Alternar la clase 'active' en el menú
              $('.menu_desplegable').toggleClass('active');
            });
        });///document ready
    </script>

    <!-- <script src="/pp2/modules/nav/filtro_busqueda/js/filtro_busqueda.js"></script> -->
    <!-- <script src="/pp2/modules/menu_desplegable/js/menu_desplegable.js"></script> -->
</body>

</html>