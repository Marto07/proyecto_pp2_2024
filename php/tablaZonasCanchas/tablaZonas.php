<?php 
	session_star();
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
	<style>
		body {
		    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		    background-color: #F0F4F8;
		    margin: 0;
		    padding: 20px;
		}

		h2 { 
		    text-align: center;
		}

		table {
		    width: 100%;
		    border-collapse: collapse;
		    background-color: #FFFFFF;
		    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		    border-radius: 8px;
		    overflow: hidden;
		    margin: 20px auto;
		    max-width: 800px;
		}

		thead {
		    background-color: #A8E6CF;
		    color: #333;
		    text-align: left;
		}

		thead th {
		    padding: 12px;
		    font-weight: bold;
		    font-size: 16px;
		}

		tbody tr {
		    border-bottom: 1px solid #E0E0E0;
		    transition: background-color 0.3s ease;
		}

		tbody tr:hover {
		    background-color: #DEFDE0;
		}

		tbody td {
		    padding: 12px;
		    font-size: 16px;
		    color: #555;
		}

		table tbody img{
		    height:30px;
		}

		tbody tr:last-child {
		    border-bottom: none;
		}

		.alta {
		    text-align: center;
		            
		}

		tfoot {
		    background-color: #A8E6CF;
		    text-align: right;
		}

		tfoot td {
		    padding: 12px;
		    font-weight: bold;
		    color: #333;
		}

		table th, table td {
		    text-align: left;
		}


	</style>
</head>
<body>
	<h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px;">Modulo Zonas de Complejos Deportivos</h1>
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

 	<script>
        function confirmDelete(id,id_sucursal) {
            var respuesta = confirm("¿Estás seguro de que deseas eliminar este registro?");
            if (respuesta) {
                // Si el usuario hace clic en "Aceptar", redirige a la página de eliminación
                window.location.href = "tablaZonas_baja.php?id_zona=" + id + "&id_sucursal=" + id_sucursal;
            }
        }
    </script>
</body>
</html>
	
