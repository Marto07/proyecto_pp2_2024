<?php 

	$conexion = new mysqli("localhost", "root", "","proyecto_pp2");
	$contrasena = 'martin0001';
	$contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);
	$id_usuario = 9;

	$sql = "UPDATE 
				usuarios 
			SET 
				password = ? 
			WHERE 
				id_usuario = ?";
	$stmt = $conexion->prepare($sql);
	$stmt->bind_param("si", $contrasena_hasheada, $id_usuario);

	if ($stmt->execute()) {
		echo "exito";
	} else {
		echo "algo salio mal";
	}

?>