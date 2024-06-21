<?php
require_once('../config/database/conexion.php');
$email       = $_POST['email'];
$password   = $_POST['password'];

//echo $user;
//echo $name;

$sql="SELECT 
            usuarios.id_usuario,
            usuarios.password
        FROM 
            usuarios
        JOIN
            contacto
        ON
            usuarios.rela_contacto = contacto.id_contacto
        WHERE 
            contacto.descripcion_contacto LIKE '{$email}'
        AND
            usuarios.estado LIKE 'verificado'";

$datos = $conexion->query($sql);

// el compañero usa mysql->query 
if($datos->num_rows == 1) {

    $row = $datos->fetch_assoc();

    if(password_verify($password, $row['password'])) {

        $sql = "SELECT id_usuario ,username ,id_perfil, descripcion_perfil, descripcion_contacto 
            FROM 
                usuarios 
            JOIN 
                perfil
            ON
                usuarios.rela_perfil = perfil.id_perfil
            JOIN
                contacto
            ON 
                usuarios.rela_contacto = contacto.id_contacto
            WHERE 
                contacto.descripcion_contacto LIKE '{$email}'";

        $datos = $conexion->query($sql);

        while ($reg = $datos->fetch_assoc()) {
        	$id_usuario = $reg['id_usuario'];
            $usuario    = $reg['username'];
            $email      = $reg['descripcion_contacto'];
            $id_perfil  = $reg['id_perfil'];
            $perfil     = $reg['descripcion_perfil'];

        }

        session_start();

        $_SESSION['id_usuario'] =   $id_usuario;
        $_SESSION['usuario']    =   $usuario;
        $_SESSION['email']      =   $email;
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