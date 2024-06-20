<?php 
require_once("../../config/database/conexion.php");

$nombre             = $_POST['nombre'];
$apellido           = $_POST['apellido'];
$dni                = $_POST['dni'];
$cargo              = $_POST['cargo'];
$fechaNacimiento    = $_POST['fecha_nacimiento'];
$complejo           = $_POST['complejo'];

$sqlPersona = "INSERT INTO 
                    persona(nombre,apellido,dni,fecha_nacimiento,fecha_alta)
                VALUES
                    ('$nombre','$apellido','$dni','$fechaNacimiento',CURRENT_DATE())";

if($conexion->query($sqlPersona)) {
   $relaPersona = $conexion->insert_id;

    $sqlEmpleado = "INSERT INTO 
                        empleado(empleado_cargo,fecha_alta,rela_persona,rela_complejo)
                    VALUES
                        ('$cargo',CURRENT_DATE(),$relaPersona,$complejo)";
    if ($conexion->query($sqlEmpleado)) {
        header("Location: tablaEmpleados.php");
    }
    
}



?>