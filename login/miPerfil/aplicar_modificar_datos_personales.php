<?php 
	session_start();
	require_once("../../config/database/conexion.php");
	

		$nombre 	= $_POST['nombre'];
		$apellido 	= $_POST['apellido'];
		$documento 	= $_POST['documento'];
		$sexo 		= $_POST['sexo'];
		$email      = $_SESSION['email'];

		$sql_persona = "UPDATE 
								persona
							JOIN
								contacto 
							ON 
								contacto.rela_persona = persona.id_persona
							SET 
								nombre 		= ?, 
								apellido 	= ?,
								rela_sexo 	= ?
							WHERE 
								contacto.descripcion_contacto = ?";

		$sql_documento = "UPDATE 
								documento
							JOIN
								persona
							ON
								id_documento = rela_documento
							JOIN
								contacto
							ON
								contacto.rela_persona = persona.id_persona
							SET 
								descripcion_documento = ?
							WHERE 
								contacto.descripcion_contacto = ?";

		$stmt1 = $conexion->prepare($sql_persona);
		$stmt2 = $conexion->prepare($sql_documento);

		$stmt1->bind_param("ssis", $nombre, $apellido, $sexo, $email);
		$stmt2->bind_param("ss", $documento, $email);


		if($stmt1->execute() && $stmt2->execute()) {
			header("Location: mis_datos.php");
		} else {
			echo "error en el update de persona". $conexion->error;
		}
	stmt1->close();
	stmt2->close();
	conexion->close();

?>