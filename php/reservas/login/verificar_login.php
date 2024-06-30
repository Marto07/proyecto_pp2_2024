<?php
require_once('../conexion.php');
$user=$_POST['username'];
$password=$_POST['password'];

//echo $user;
//echo $name;

$sql="SELECT * FROM usuario WHERE nombre_usuario = '{$user}';";

$datos = $conexion->query($sql);
// el compañero usa mysql->query 
if($datos->num_rows == 1) {
    $sql = "SELECT * FROM usuario WHERE contrasena LIKE '{$password}'";
    $datos = $conexion->query($sql);
    if($datos->num_rows == 1) {

//        echo"existe";

        $sql = "SELECT id_usuario ,nombre_usuario FROM usuario WHERE nombre_usuario = '{$user}'";
        $datos = $conexion->query($sql);

        while ($reg = $datos->fetch_assoc()) {
        	$idUsuario = $reg['id_usuario'];
            $usuario=$reg['nombre_usuario'];
        }

        session_start();
        $_SESSION['id']=$idUsuario;
        $_SESSION['usuario']=$usuario;
        header('location: ../formularioReserva1.php');
    }
    else {
//        echo"no existe";
    header('location: ../formularioReserva0.php?error=2');
    }
}
else{
//    echo"usuario inexistente";
    header('location: ../formularioReserva0.php?error=1');
    
}
?>