<?php  
    require_once("../config/root_path.php");
    require_once(RUTA. 'config/database/conexion.php');
    // session_start();
    // $_SESSION['id_perfil'] = 1;
    $id_perfil = isset($_SESSION['id_perfil']) ? $_SESSION['id_perfil'] : 2/*23*/; // perfil del usuario almacenado en sesión
    /*
    $querySinRuta = "SELECT m.descripcion_modulo, sm.descripcion_submodulo
              FROM modulo m 
              JOIN asignacion_perfil_modulo apm ON m.id_modulo = apm.rela_modulo
              JOIN submodulo sm ON m.id_modulo = sm.rela_modulo
              WHERE apm.rela_perfil = ?";
    */
    $query = "SELECT m.descripcion_modulo, sm.descripcion_submodulo, m.ruta as ruta_modulo,sm.ruta as ruta_submodulo 
              FROM modulo m 
              JOIN asignacion_perfil_modulo apm ON m.id_modulo = apm.rela_modulo
              JOIN submodulo sm ON m.id_modulo = sm.rela_modulo
              WHERE apm.rela_perfil = ?";

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_perfil);
    $stmt->execute();
    $result = $stmt->get_result();

    $modulos = [];
    while ($row = $result->fetch_assoc()) {
        $modulos[$row['descripcion_modulo']]['ruta_modulo'] = $row['ruta_modulo'];
        $modulos[$row['descripcion_modulo']]['submodulos'][] = [
            'nombre' => $row['descripcion_submodulo'],
            'ruta' => $row['ruta_submodulo']
        ];
    }



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Lateral</title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/Aside/menu_aside.css'; ?>">
</head>
<body>
    <!-- Botón de menú (hamburguesa) -->
    <div class="menu-btn" >
        &#9776; <!-- Icono de las tres rayas -->
    </div>

    <!-- Contenido principal de la página -->
    <div class="content">
        <h1>Página Principal</h1>
        <p>Este es el contenido de la página que se superpondrá cuando el menú se abra.</p>
    </div>

    <!-- Menú lateral (aside) -->
    <aside id="side-menu" class="side-menu">
        <!-- 
            ESTATICO
        <div class="indice">
            <p>Índice (No clickeable)</p>
            <a href="#">Opción 1</a>
            <a href="#">Opción 2</a>
            <a href="#">Opción 3</a>
        </div>
        -->
        <?php foreach ($modulos as $modulo => $data): ?>

                        <div class="indice">
                            <p><?php echo $modulo; ?></p>

                                <?php foreach ($data['submodulos'] as $submodulo): ?>
                                    <a href="<?php echo BASE_URL . $submodulo['ruta']; ?>"><?php echo $submodulo['nombre']; ?></a>
                                <?php endforeach; ?>

                        </div>

        <?php endforeach; ?>
    </aside>



    <script src="<?php echo BASE_URL . 'js/jquery-3.7.1.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'js/Aside/menu_aside.js'; ?>"></script>
</body>
</html>
