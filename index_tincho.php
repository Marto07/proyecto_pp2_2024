<?php
require_once("config/root_path.php");
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
    <title>Index</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/index.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'headerGeneral.css' ?>">
</head>

<body>
    <div class="container">
        <header>
            <?php include(RUTA . 'modules/header/tituloWeb/php/tituloWeb.php'); ?>
            <?php include(RUTA . 'modules/header/btnPerfil/php/btnPerfil.php'); ?>
        </header>
        <main>
            <?php include(RUTA . 'modules/asideMenu/php/asideMenu.php'); ?>
        </main>
        <footer>
            footer
        </footer>
    </div>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/filtroBusqueda.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/btnPerfil/js/btnPerfil.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/asideMenu/js/menuAside.js'; ?>"></script>
</body>

</html>