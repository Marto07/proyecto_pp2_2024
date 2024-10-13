<?php
require_once("../../../config/root_path.php");
require_once(RUTA. "config/database/conexion.php");
require_once(RUTA. "config/database/db_functions/personas.php");
session_start();
// Suponiendo que ya tienes conexión a la base de datos almacenada en $conexion
//paso 1
$descripcion_complejo       = $_POST['descripcion_complejo'];
$fecha_fundacion_complejo   = $_POST['fecha_fundacion_complejo'];

//paso 2
$descripcion_sucursal       = $_POST['descripcion_sucursal'];
$fecha_fundacion_sucursal   = $_POST['fecha_fundacion_sucursal'];
$rela_barrio                = $_POST['barrio']; // Este valor viene del formulario
$direccion                  = $_POST['direccion'];


//paso 3
$descripcion_zona   = $_POST['descripcion_zona'];
$tipo_terreno       = $_POST['tipo_terreno'];
$formato_deporte    = $_POST['formato_deporte'];
$estado_zona        = $_POST['estado'];

$fecha_creacion_zona = date('Y-m-d');

$id_usuario = $_SESSION['id_usuario'];
$registros = obtenerPersonaPorUsuario($id_usuario);
$objeto_persona = $registros->fetch_assoc();
$rela_persona = $objeto_persona['id_persona'];

$fecha_alta = date('Y-m-d');
echo $rela_persona. "<br>";
echo $fecha_alta;

try {
    // Iniciar la transacción
    $conexion->begin_transaction();

    // Insertar en la tabla Complejo
    $sql_complejo = "INSERT INTO Complejo (descripcion_complejo, fecha_fundacion, fecha_alta, verificado) 
                     VALUES (?, ?, ?, 'no verificado')";
    $stmt_complejo = $conexion->prepare($sql_complejo);
    $stmt_complejo->bind_param('sss', $descripcion_complejo, $fecha_fundacion_complejo, $fecha_alta);
    $stmt_complejo->execute();

    // Obtener el ID generado del complejo
    $rela_complejo = $conexion->insert_id;

    // Insertar en la tabla Asignacion_persona_complejo
    $sql_asignacion_pc = "INSERT INTO Asignacion_persona_complejo (fecha_alta,rela_persona, rela_complejo) 
                          VALUES (?, ?, ?)";
    $stmt_asignacion_pc = $conexion->prepare($sql_asignacion_pc);
    $stmt_asignacion_pc->bind_param('sii', $fecha_alta, $rela_persona, $rela_complejo);
    $stmt_asignacion_pc->execute();

    // Insertar en la tabla Sucursal
    $sql_sucursal = "INSERT INTO Sucursal (descripcion_sucursal, fecha_de_creacion,fecha_alta,rela_complejo) 
                     VALUES (?, ?, ?, ?)";
    $stmt_sucursal = $conexion->prepare($sql_sucursal);
    $stmt_sucursal->bind_param('sssi', $descripcion_sucursal, $fecha_fundacion_sucursal,$fecha_alta, 
        $rela_complejo);
    $stmt_sucursal->execute();

    // Obtener el ID generado de la sucursal
    $rela_sucursal = $conexion->insert_id;

    // Insertar en la tabla Asignacion_sucursal_domicilio
    $sql_asignacion_sd = "INSERT INTO Asignacion_sucursal_domicilio (rela_barrio, rela_sucursal, direccion) 
                          VALUES (?, ?, ?)";
    $stmt_asignacion_sd = $conexion->prepare($sql_asignacion_sd);
    $stmt_asignacion_sd->bind_param('iis', $rela_barrio, $rela_sucursal, $direccion);
    $stmt_asignacion_sd->execute();

    // Insertar en la tabla Zona
    $sql_zona = "INSERT INTO Zona (descripcion_zona, rela_tipo_terreno, rela_formato_deporte, rela_estado_zona,rela_sucursal, rela_servicio) 
                 VALUES (?, ?, ?, ?, ?,1/*servicio = cancha =1*/)";
    $stmt_zona = $conexion->prepare($sql_zona);
    $stmt_zona->bind_param('siiii', $descripcion_zona, $rela_tipo_terreno, $rela_formato_deporte, $rela_estado_zona, $rela_sucursal);
    $stmt_zona->execute();

    //hay que actualizar el perfil del usuario a PROPIETARIO
    if ($_SESSION['perfil'] != 'propietario' || $_SESSION['perfil'] != 'administrador') {

        $id_usuario = $_SESSION['id_usuario'];
        $sql_update_usuario = "UPDATE usuarios SET rela_perfil = 23 WHERE id_usuario = {$id_usuario}";
        $conexion->query($sql_update_usuario);
        
    }


    // Si todo fue bien, confirmar la transacción
    $conexion->commit();

    echo "Transacción realizada con éxito.";
} catch (Exception $e) {
    // En caso de error, hacer rollback
    $conexion->rollback();
    echo "Error en la transacción: " . $e->getMessage();
} finally {
    // Cerrar los prepared statements
    $stmt_complejo->close();
    $stmt_asignacion_pc->close();
    $stmt_sucursal->close();
    $stmt_asignacion_sd->close();
    $stmt_zona->close();
    $conexion->close();
}
?>
