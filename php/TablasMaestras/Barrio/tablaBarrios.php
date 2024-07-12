<?php 
	require_once("../../../config/database/conexion.php");
    session_start();

    if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_perfil'])) {
        header("Location: ../../../error403.php");
        exit();
    }

    $modulo = "domicilios";

    $sql_acceso = "SELECT COUNT(*) AS tiene_acceso
                    FROM 
                        asignacion_perfil_modulo asp
                    JOIN 
                        perfil p 
                    ON 
                        asp.rela_perfil = p.id_perfil
                    JOIN 
                        modulo m ON asp.rela_modulo = m.id_modulo
                    WHERE 
                        p.descripcion_perfil 
                    LIKE 
                        '{$_SESSION['perfil']}' 
                    AND 
                        m.descripcion_modulo 
                    LIKE 
                        '{$modulo}'";

    $resultado = $conexion->query($sql_acceso);

    if ($reg = $resultado->fetch_assoc()) {
        if ($reg['tiene_acceso'] == 0) {
            header("Location: ../../../error403.php");
            exit();
        }
    }
	
	// SETEAMOS EL PAGINADO
	$registros_por_pagina = 5;

	// Determinar la página actual
	if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
	    $pagina_actual = (int) $_GET['pagina'];
	} else {
	    $pagina_actual = 1;
	}

	//DEFINIMOS EL OFSET O LA CANTIDAD DE REGISTROS SKIPEADOS
	$offset = ($pagina_actual - 1) * $registros_por_pagina;

	require_once('../../../config/database/db_functions.php');
	require_once('../../../config/root_path.php');
	$registros = obtenerBarrios($offset, $registros_por_pagina);

	// Número de registros por página
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tabla Barrios</title>
	<style>
		/* GENERALES */
		body{
			padding: 0;
			margin: 0;
			font-family: sans-serif;
			background-color: #96E072/*rgba(0, 0, 0, 0.85)*/;
			color: white;
		}

		table {
			border-collapse: collapse;
			width: 65%;
			margin: 0 auto;
			margin-top: 15vh;
			color: rgba(0, 0, 0, 0.58);
			font-weight: bold;
		}

		th, td {
			text-align: center;
			padding: 8px 10px;
		}

		td, th:nth-child(7),
		td, th:nth-child(8) {
			padding: 8px 5px;
		}

		/* ESTILOS ESPECIALES A LOS THEAD */

		body table thead tr {
			background-color: #25ac5c ;
			color:rgba(255, 255, 255, 0.9);
			text-align: left;
		}


		/* RENGLONES DE COLORES DIFERENTES */
		table tbody tr:nth-child(odd) {
			background-color: #f4f4f4 ;
		}

		table tbody tr:nth-child(even) {
			background-color: #E6E6E6 ;
		}

		.alta {
			text-align: center;
			
		}

		table tbody img{
			height:30px;
		}

		table tbody a:hover {
			cursor: pointer;
		}

		.back-button {
            background-color: #a8e6cf;
            color: #3d9970;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background-color: #79b8a0;
            color: white;
        }
	</style>
</head>
<body>
	<?php include(RUTA . 'includes/nav-bar.php'); ?>
	<h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px;">Modulo de barrios</h1>
	<a class="back-button" href="../../../index_tincho.php">Volver</a>
	<table>
		<thead>
			<tr>
				<th>C&oacute;digo</th>
				<th>Descripcion</th>
				<th>Localidad</th>
				<th></th>
				<th></th>
			</tr>
		</thead>

		<tbody>

		<?php foreach ($registros as $reg) : 

			$id 		 = $reg['id_barrio'];
			$descripcion = $reg['descripcion_barrio'];
			$localidad   = $reg['descripcion_localidad'];

			$modificar = "<a href='tablaBarrios_modificacion.php?id_barrio=$id'>
								<img src='../../../assets/icons/editar_azul.png'>
							</a>";

			$eliminar =	"<a href=\"javascript:confirmDelete($id)\">
								<img src='../../../assets/icons/eliminar.png'>
							</a>";

		?>


				 <tr>
					 <td> <?php echo $id;										?></td>
					 <td> <?php echo $descripcion;								?></td>
					 <td> <?php echo $localidad;								?></td>
					 <td> <?php echo $modificar; 								?></td>
					 <td> <?php echo $eliminar;									?></td>
				 </tr>
				 
		<?php endforeach; ?>
		 
 		<tr>
 			<td colspan="8" class="alta">
 				<a href="tablabarrios_alta.php">
 					<img src="../../../assets/icons/agregar.png" type="icon">
 				</a>
 			</td>
 		</tr>

 		</tbody>
 	</table>

 	<?php 

 		//calculamos total de paginas necesarias
 		$sql = "SELECT COUNT(*) FROM barrio WHERE estado = 1";
 		$registros = $conexion->query($sql);
 		$reg = $registros->fetch_array();
 		$total_registros = $reg[0];
		$total_paginas 	= ceil($total_registros / $registros_por_pagina);

		echo "<center>";
			if ($pagina_actual > 1) {
			    echo "<a href='?pagina=" . ($pagina_actual - 1) . "' style='padding: 10px; border-radius: 5px; background-color: white; margin: 10px; margin-top:20px'>Previo</a> ";
			}

			if ($pagina_actual < $total_paginas) {
			    echo "<a href='?pagina=" . ($pagina_actual + 1) . "' style='padding: 10px; border-radius: 5px; background-color: white; margin: 10px; margin-top: 20px'>Siguiente</a>";
			}
		echo "</center>";

 	?>

 	<script>
        function confirmDelete(id) {
            var respuesta = confirm("¿Estás seguro de que deseas eliminar este registro?");
            if (respuesta) {
                // Si el usuario hace clic en "Aceptar", redirige a la página de eliminación
                window.location.href = "tablabarrios_baja.php?id_barrio=" + id;
            }
        }
    </script>
</body>
</html>
	
