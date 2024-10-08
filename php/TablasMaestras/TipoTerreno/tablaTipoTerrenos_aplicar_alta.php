<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/controlar_acceso.php");
session_start();
$perfil = $_SESSION['perfil'];
validarAcceso("administrador", $perfil);
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_perfil'])) {
    header("Location: ../../../error403.php");
    exit();
}

$modulo = "Zonas";

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

$descripcion         = $_POST['descripcion'];

$sql = "INSERT INTO 
					tipo_terreno(descripcion_tipo_terreno)
		VALUES
			('$descripcion')";

if ($conexion->query($sql)) {
    header("Location: tablatipoTerrenos.php");
}
