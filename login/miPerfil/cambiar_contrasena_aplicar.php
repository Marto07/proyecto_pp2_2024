<?php 

	require_once("../../config/root_path.php");
	require_once(RUTA."config/database/conexion.php");
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$contrasena = $_POST['password'];
		$id_usuario = $_POST['id_usuario'];
		$contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);

		$sql = "UPDATE usuarios SET password = ? WHERE id_usuario = ?";
		$stmt = $conexion->prepare($sql);
		$stmt->bind_param("si", $contrasena_hasheada, $id_usuario);
		if($stmt->execute()) {
			session_start();
			session_unset();
			session_destroy();
			header("Location: ../../index_tincho.php");
			exit();
		} else {
			echo "Error en el cambio de contraseña";
			echo "<a href='" . BASE_URL . "index_tincho.php'>Inicio</a>";
		}
		
		

	} else {
		echo "No tiene acceso a este modulo." . "<br>";
		echo "<a href='" . BASE_URL . "index_tincho.php'>Inicio</a>";
	}

?>