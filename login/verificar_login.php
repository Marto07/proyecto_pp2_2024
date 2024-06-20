<?php
require_once('../config/database/conexion.php');
$user       = $_POST['username'];
$password   = $_POST['password'];

//echo $user;
//echo $name;

$sql="SELECT * FROM usuario WHERE nombre_usuario LIKE '{$user}'";

$datos = $conexion->query($sql);

// el compañero usa mysql->query 
if($datos->num_rows == 1) {

    $row = $datos->fetch_assoc();

    if(password_verify($password, $row['contrasena'])) {

        $sql = "SELECT id_usuario ,nombre_usuario ,id_perfil, descripcion_perfil 
            FROM 
                usuario 
            JOIN 
                perfil
            ON
                rela_perfil = id_perfil
            WHERE 
                nombre_usuario LIKE '{$user}'";

        $datos = $conexion->query($sql);

        while ($reg = $datos->fetch_assoc()) {
        	$id_usuario = $reg['id_usuario'];
            $usuario    = $reg['nombre_usuario'];
            $id_perfil  = $reg['id_perfil'];
            $perfil     = $reg['descripcion_perfil'];

        }

        session_start();

        $_SESSION['id_usuario'] =   $id_usuario;
        $_SESSION['usuario']    =   $usuario;
        $_SESSION['id_perfil']  =   $id_perfil;
        $_SESSION['perfil']     =   $perfil;

        header('location: ../index_tincho.php');
        exit();
    }
    else {
//        echo"no existe";
    header('location: inicio_sesion.php?error=2');
    }

} else {
//    echo"usuario inexistente";
    header('location: inicio_sesion.php?error=1');
    
}
?>