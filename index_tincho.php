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

    $id_usuario = $_SESSION['id_usuario'];
    $registros = obtenerPersonaPorUsuario($id_usuario);

    if ($reg = $registros->fetch_assoc()) {
        $id_persona = $reg['id_persona'];
    }

    //esta funcion seria para darle acceso si tiene complejo a su nombre
    function obtenerAcessoGestionCanchas($id_persona) {
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

        if($stmt->execute()) {
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
    <!-- <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            color: white;
            font-family: 'Montserrat', sans-serif;
            background-color: gray;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #e0f2e9;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu {
            display: flex;
        }

        .menu ul.cont-ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .menu ul.cont-ul > li {
            position: relative;
        }

        .menu ul.cont-ul > li > a {
            text-decoration: none;
            color: #3d9970;
            font-size: 18px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .menu ul.cont-ul > li > a:hover {
            background-color: #3d9970;
            color: #e0f2e9;
            transform: scale(1.1);
        }

        .menu ul.cont-ul > li > ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #a8e6cf;
            list-style: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            min-width: 100%;
        }

        .menu ul.cont-ul > li > ul > li {
            position: relative;
        }

        .menu ul.cont-ul > li > ul > li > a {
            text-decoration: none;
            color: #3d9970;
            padding: 8px 12px;
            display: block;
            transition: all 0.3s ease;
        }

        .menu ul.cont-ul > li > ul > li > a:hover {
            background-color: #3d9970;
            color: #e0f2e9;
            transform: scale(1.05);
        }

        .menu ul.cont-ul > li:hover > ul {
            display: block;
        }

        .menu ul.cont-ul > li > ul > li > ul {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            background-color: #d7ffd9;
            list-style: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            min-width: 100%;
        }

        .menu ul.cont-ul > li > ul > li > ul > li {
            position: relative;
        }

        .menu ul.cont-ul > li > ul > li > ul > li > a {
            text-decoration: none;
            color: #3d9970;
            padding: 8px 12px;
            display: block;
            transition: all 0.3s ease;
        }

        .menu ul.cont-ul > li > ul > li > ul > li > a:hover {
            background-color: #3d9970;
            color: #e0f2e9;
            transform: scale(1.05);
        }

        .menu ul.cont-ul > li > ul > li:hover > ul {
            display: block;
        }

        .profile-menu {
            position: relative;
            margin-right: 20px;
        }

        .profile-button {
            padding: 10px 15px;
            background-color: #3d9970;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-button:hover {
            background-color: #2e7d32;
            transform: scale(1.1);
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #a8e6cf;
            list-style: none;
            padding: 10px;
            border-radius: 5px;
            z-index: 10;
        }

        .profile-dropdown:hover {
            display: block;
        }

        .profile-dropdown li {
            margin-bottom: 10px;
        }

        .profile-dropdown li a {
            text-decoration: none;
            color: #3d9970;
            padding: 8px 12px;
            display: block;
            transition: all 0.3s ease;
        }

        .profile-dropdown li a:hover {
            background-color: #3d9970;
            color: #e0f2e9;
            transform: scale(1.05);
        }

        /*.profile-menu:hover .profile-dropdown {
            display: block;
        }*/
    </style> -->
    <link rel="stylesheet" href="<?php echo BASE_URL. 'css/aside/menu_aside_beterette.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL. 'css/header.css' ?>">
</head>
<body>
    <?php include(RUTA. 'includes/header_tincho.php'); ?>
    <?php include(RUTA. 'includes/menu_aside_beterette.php'); ?>
<script src="js/jquery-3.7.1.min.js"></script>
<!-- <script src="js/desplegar_perfil.js"></script> -->
</body>
</html>
