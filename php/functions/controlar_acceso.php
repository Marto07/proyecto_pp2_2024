<?php 
require_once("../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
session_start();
$_SESSION['usuario'] = "martin";
$_SESSION['id_perfil'] = "1";

function validarAcceso($modulo=null,$perfil=null) {
	global $_SESSION, $conexion;

	if($modulo == null || $perfil == null ) {
		return false;
	} elseif ($modulo == "" || $perfil == "") {
		return false;
	}


	if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_perfil'])) {
        header("Location: ". BASE_URL ."errors/error403.php?no_tiene_sesion");
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
                        '{$perfil}' 
                    AND 
                        m.descripcion_modulo 
                    LIKE 
                        '{$modulo}'";

    $resultado = $conexion->query($sql_acceso);

    if ($reg = $resultado->fetch_assoc()) {
        if ($reg['tiene_acceso'] == 0) {
            header("Location: " . BASE_URL . "errors/error403.php?no_tiene_acceso");
            exit();
        } else{
        	return true;
        }

    }



}

if (validarAcceso("inicio","administrador")){
	echo "tiene acceso";
} else {
	echo "no tiene acceso";
}


?>