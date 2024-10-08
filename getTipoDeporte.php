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

$idDeporte = $conexion->real_escape_string($_POST['id_deporte']);

$sql = "SELECT id_formato_deporte, descripcion_formato_deporte 
            FROM formato_deporte 
            WHERE rela_deporte = $idDeporte
            ORDER BY descripcion_formato_deporte ASC";

$resultado = $conexion->query($sql);

$respuesta = "<option value=''>Seleccionar</option>";

while ($row = $resultado->fetch_assoc()) {
    $respuesta .= "<option value='" . $row['id_formato_deporte'] . "'>" . $row['descripcion_formato_deporte'] . "</option>";
}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
