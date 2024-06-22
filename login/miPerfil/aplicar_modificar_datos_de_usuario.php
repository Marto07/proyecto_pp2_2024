<?php  
		$email 		= $_POST['email'];
		$usuario	= $_POST['username'];

		$sql_usuario = "UPDATE usuarios SET 
								username = '$usuario', 
							WHERE 
								id_usuario = {$_SESSION['id_usuario']}";

		$sql_contacto = "UPDATE 
								contacto 
							JOIN
								usuarios
							ON
								contacto.id_contacto = usuarios.rela_contacto
							SET 
								descripcion_contacto = '$email', 
							WHERE 
								id_usuario = {$_SESSION['id_usuario']}";

		if($conexion->query($sql_usuario) && $conexion->query($sql_contacto)) {
			header("Location: mis_datos.php");
		} else {
			echo "error en el update de usuario";
		}
?>