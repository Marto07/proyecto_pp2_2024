<?php 

	require_once('../../config/database/db_functions.php');

	$registros = obtenerZonasFutbol();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TABLA ZONAS</title>
	<link rel="stylesheet" type="text/css" href="../../css/zonas.css">
</head>
<body>
	<h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px;">Modulo Zonas de Complejos Deportivos</h1>
	<table>
		<thead>
			<tr>
				<th>Zona</th>
				<th>Dimension</th>
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
			$dimension 	= $reg['dimension'];
			$terreno 	= $reg['terreno'];
			$tipoFutbol = $reg['tipo_futbol'];
			$complejo 	= $reg['descripcion_complejo'];

			$modificar = "<a href='tablaZonas_modificacion.php?id_zona=$id'>
								<img src='../../assets/icons/editar_azul.png'>
							</a>";

			$eliminar =	"<a href=\"javascript:confirmDelete($id)\">
								<img src='../../assets/icons/eliminar.png'>
							</a>";

		?>


				 <tr>
					 <td> <?php echo $id;										?></td>
					 <td> <?php echo $dimension;								?></td>
					 <td> <?php echo $terreno;									?></td>
					 <td> <?php echo $tipoFutbol;								?></td>
					 <td> <?php echo $complejo;									?></td>
					 <td> <?php echo $modificar 								?></td>
					 <td> <?php echo $eliminar 									?></td>
				 </tr>
				 
		<?php endforeach; ?>
		 
 		<tr>
 			<td colspan="7" class="alta">
 				<a href="tablaZonas_alta.php">
 					<img src="../../assets/icons/agregar.png" type="icon">
 				</a>
 			</td>
 		</tr>

 		</tbody>
 	</table>

 	<script>
        function confirmDelete(id) {
            var respuesta = confirm("¿Estás seguro de que deseas eliminar este registro?");
            if (respuesta) {
                // Si el usuario hace clic en "Aceptar", redirige a la página de eliminación
                window.location.href = "tablaZonas_baja.php?id_zona=" + id;
            }
        }
    </script>
</body>
</html>
	
