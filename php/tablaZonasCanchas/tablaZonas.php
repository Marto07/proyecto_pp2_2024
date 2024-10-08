<?php
session_start();
require_once('../../config/root_path.php');
$id_sucursal = isset($_GET['id_sucursal']) ? $_GET['id_sucursal'] : die("FALTA GET SUCURSAL");

require_once('../../config/database/db_functions.php');

$registros = obtenerZonasFutbol($id_sucursal);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TABLA ZONAS</title>
	<link rel="stylesheet" href="<?php echo BASE_URL . 'css/aside/menu_aside_beterette.css'; ?>">
	<link rel="stylesheet" href="<?php echo BASE_URL . 'css/header.css' ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style>
		body {
			background: #161616;
			font-family: Arial, Helvetica, sans-serif;
		}

		/* Formulario Empleado/////////////////////////////////////77 */
		/* Estilos generales para el contenedor del formulario */
		.containerEmpleado {
			margin: auto;
			margin-top: 10px;
			padding: 20px;
			background-color: #212121;
			border-radius: 8px;
			box-shadow: 0px 0px 10px rgb(128, 128, 128, 0.7);
		}

		.containerEmpleado h1 {
			color: #fff;
			text-align: center;
		}

		.containerEmpleado form {
			margin-top: 10px;
		}

		/* Estilos para las etiquetas de los campos */
		.containerEmpleado label {
			display: block;
			margin-bottom: 8px;
			font-weight: bold;
			color: #fff;
		}

		/* Estilos para los campos de entrada de texto */
		.containerEmpleado input[type="text"],
		.containerEmpleado input[type="date"],
		.containerEmpleado select {
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #2c2c2c;
			border-radius: 4px;
			font-size: 16px;
			box-sizing: border-box;
			transition: border-color 0.3s ease;
		}

		/* Estilos para cambiar el color del borde cuando el campo está enfocado */
		.containerEmpleado input[type="text"]:focus,
		.containerEmpleado input[type="date"]:focus,
		.containerEmpleado select:focus {
			border-color: grey;
			box-shadow: 1px 0px 3px grey;
			outline: none;
		}

		/* Estilos para el botón de enviar */
		.containerEmpleado button {
			width: 40%;
			padding: 12px;
			background-color: #2c2c2c;
			color: #fff;
			border: none;
			border-radius: 4px;
			font-size: 16px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		/* Cambio de color al pasar el cursor sobre el botón */
		.containerEmpleado button:hover {
			background-color: #0b0b0b;
			border: 1px solid grey;
			box-shadow: 1px 0px 3px gray;
		}

		/* Ajustes para pantallas pequeñas */
		@media (max-width: 480px) {
			.containerEmpleado {
				padding: 10px;
			}

			.containerEmpleado label {
				font-size: 14px;
			}

			.containerEmpleado input[type="text"],
			.containerEmpleado input[type="date"],
			.containerEmpleado select {
				font-size: 14px;
			}

			.containerEmpleado button {
				font-size: 14px;
				padding: 10px;
			}
		}

		/* Tabla Registro //////////////////////////////////////////7 */
		table {
			border-collapse: collapse;
			width: 100%;
			margin: auto;
			margin-top: 1%;
			color: rgba(0, 0, 0, 0.6);
			font-weight: bold;
			font-size: 16px;
			border: none;
		}

		th,
		td {
			text-align: center;
			padding: 10px;
			color: white;
		}

		/* ESTILOS ESPECIALES A LOS THEAD */

		body table thead tr {
			background-color: #161616;
			color: rgba(255, 255, 255, 0.9);
			text-align: center;
			padding: 8px;
		}

		/* RENGLONES DE COLORES DIFERENTES */
		table tbody tr:nth-child(odd) {
			background-color: #2c2c2c;
		}

		table tbody tr:nth-child(even) {
			background-color: #161616;
		}

		.alta {
			text-align: center;
			color: #161616;
		}

		table tbody img {
			height: 30px;
		}

		table tbody a:hover {
			cursor: pointer;
		}
	</style>
</head>

<body>
	<?php include(RUTA . 'includes/header_tincho.php'); ?>
	<?php include(RUTA . 'includes/menu_aside_beterette.php'); ?>
	<script src="js/jquery-3.7.1.min.js"></script>
	<div class="containerEmpleado">
		<h1>Modulo Zonas de Complejos Deportivos</h1>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Zona</th>
					<th>Terreno</th>
					<th>Tipo de futbol</th>
					<th>Complejo</th>
					<th></th>
					<th></th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($registros as $reg) :

					$id 		= $reg['id_zona'];
					$zona 		= $reg['descripcion_zona'];
					$terreno 	= $reg['descripcion_tipo_terreno'];
					$tipoFutbol = $reg['descripcion_formato_deporte'];
					$complejo 	= $reg['descripcion_sucursal'];

					$modificar = "<a href='tablaZonas_modificacion.php?id_zona=$id&id_sucursal=$id_sucursal'>
								<img src='../../assets/icons/editar_azul.png'>
							</a>";

					$eliminar =	"<a href=\"javascript:confirmDelete($id,$id_sucursal)\">
								<img src='../../assets/icons/eliminar.png'>
							</a>";

				?>


					<tr>
						<td> <?php echo $id;										?></td>
						<td> <?php echo $zona;										?></td>
						<td> <?php echo $terreno;									?></td>
						<td> <?php echo $tipoFutbol;								?></td>
						<td> <?php echo $complejo;									?></td>
						<td> <?php echo $modificar 								?></td>
						<td> <?php echo $eliminar 									?></td>
					</tr>

				<?php endforeach; ?>

				<tr>
					<td colspan="7" class="alta">
						<a href="tablaZonas_alta.php?<?php echo "id_sucursal=$id_sucursal" ?>">
							<img src="../../assets/icons/agregar.png" type="icon">
						</a>
					</td>
				</tr>

			</tbody>
		</table>
	</div>

	<script>
		function confirmDelete(id, id_sucursal) {
			var respuesta = confirm("¿Estás seguro de que deseas eliminar este registro?");
			if (respuesta) {
				// Si el usuario hace clic en "Aceptar", redirige a la página de eliminación
				window.location.href = "tablaZonas_baja.php?id_zona=" + id + "&id_sucursal=" + id_sucursal;
			}
		}
	</script>
</body>

</html>