<?php  
require_once("../config/database/conexion.php");
$id_persona = isset($_SESSION['id_persona']) ? $_SESSION['id_persona'] : 28;// ID de la persona que se logueó

// Asumiendo que estás usando PDO para conectarte a la base de datos
$stmt = $conexion->prepare("
    SELECT 
        COALESCE(GROUP_CONCAT(DISTINCT apc.rela_complejo), '') AS complejosPropietario,
        COALESCE(GROUP_CONCAT(DISTINCT e.rela_sucursal), '') AS sucursalesEmpleado
    FROM 
        persona p
    LEFT JOIN 
        asignacion_persona_complejo apc ON apc.rela_persona = p.id_persona
    LEFT JOIN 
        empleado e ON e.rela_persona = p.id_persona
    WHERE 
        p.id_persona = ?
    GROUP BY 
        p.id_persona;
");
$stmt->bind_param("i",$id_persona);
$stmt->execute();

$result = $stmt->get_result()->fetch_assoc();

// Convertimos las cadenas separadas por comas en arrays
$complejosPropietario = $result['complejosPropietario'] ? explode(',', $result['complejosPropietario']) : [];
$sucursalesEmpleado = $result['sucursalesEmpleado'] ? explode(',', $result['sucursalesEmpleado']) : [];

// Ahora puedes guardar estos arrays en la sesión
$_SESSION['complejosPropietario'] = $complejosPropietario;
$_SESSION['sucursalesEmpleado'] = $sucursalesEmpleado;

// Ejemplo de cómo podrías mostrarlo
echo "Complejos donde es propietario: " . implode(', ', $complejosPropietario) . "\n";
echo "Sucursales donde es empleado: " . implode(', ', $sucursalesEmpleado) . "\n";

// Primero obtenemos el id_sucursal desde el parámetro GET
$id_sucursal = isset($_GET['id_sucursal']) ? (int) $_GET['id_sucursal'] : null;

// Verificamos si el id_sucursal está dentro del array sucursalesEmpleado
$esEmpleado = $id_sucursal && in_array($id_sucursal, $_SESSION['sucursalesEmpleado']);

// Ahora el mismo proceso para el id_complejo
$id_complejo = isset($_GET['id_complejo']) ? (int) $_GET['id_complejo'] : null;
$esPropietario = $id_complejo && in_array($id_complejo, $_SESSION['complejosPropietario']);


?>