<?php 
require_once('../../config/database/conexion.php');

$id = $_GET['id_zona'];

//eliminar el producto
$sql = "UPDATE zona 
        	SET
        		estado = 0
        	WHERE id_zona = $id;";

//ejecutar la consulta o error
if ($conexion->query($sql)) {
    header("Location: tablaZonas.php"); 
} else {
    echo "error al actualizar el registro: " . $conexion->error;
}
?>