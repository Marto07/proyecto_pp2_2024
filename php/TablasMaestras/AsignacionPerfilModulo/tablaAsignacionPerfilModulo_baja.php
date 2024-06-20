<?php 
require_once("../../../config/database/conexion.php");
    session_start();

    if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_perfil'])) {
        header("Location: ../../../error403.php");
        exit();
    }

    $modulo = "Permisos";

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
            header("Location: ../../../error403.php");
            exit();
        }
    }
    
$id = $_GET['id_asignacion_perfil_modulo'];

//eliminar el producto
$sql = "DELETE FROM asignacion_perfil_modulo 
        	WHERE id_asignacion_perfil_modulo = $id;";

//ejecutar la consulta o error
if ($conexion->query($sql)) {
    header("Location: tablaAsignacionPerfilModulo.php"); 
} else {
    echo "error al actualizar el registro: " . $conexion->error;
}
?>