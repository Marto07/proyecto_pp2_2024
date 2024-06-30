<?php 

$conexion = mysqli_connect("localhost","root","","sistema_simple");
$sql_perfil = "SELECT id_perfil,descripcion_perfil FROM perfil;";
$registros = $conexion->query($sql_perfil);
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="resgistro_usuario_aplicar_alta.php" method="post">
		
		<label for="usuario">Usuario:</label>
		<input type="text" name="usuario">
		<br>

		<label for="contrasena">Contraseña:</label>
		<input type="text" name="contrasena">
		<br>

		<label for="perfil">Perfil:</label>
		<select name="perfil" id="perfil">
			<?php foreach ($registros as $reg) { ?>
				<option value="<?php echo $reg['id_perfil']; ?>"><?php echo $reg['descripcion_perfil']; ?></option>
			<?php } ?>
			
		</select>
		<br>

		<button type="submit">Enviar</button>

	</form>
</body>
</html>