<?php  
	require_once("../../config/root_path.php");
	require_once(RUTA . "config/database/conexion.php");
	session_start();
	if (isset($_GET['id_sucursal'])) {
		$id_sucursal = $_GET['id_sucursal'];
	} else {
		echo "ocurrio un error :( No hay GET de sucursal"; die;
	}

	if (isset($_SESSION['perfil'])) {
		$id_usuario = $_SESSION['id_usuario'];
		$perfil = $_SESSION['perfil'];
		$sql = "SELECT id_complejo FROM complejo JOIN sucursal ON rela_complejo = id_complejo WHERE id_sucursal = $id_sucursal";
		$registro = $conexion->query($sql);
		$reg = $registro->fetch_assoc();
		$id_complejo = $reg['id_complejo']; 
	} else {
		echo "ocurrio un error :( No hay sesion"; die;
	}

	//registros sucursal

		$sql_sucursal = "SELECT 
					id_sucursal,
					descripcion_sucursal,
					fecha_alta,
					fecha_de_creacion,
					rela_complejo,
					asd.direccion,
					c.descripcion_contacto
				FROM
					sucursal s
				JOIN
					asignacion_sucursal_domicilio asd
				ON
					s.id_sucursal = asd.rela_sucursal
				JOIN
					asignacion_sucursal_contacto ac
				ON
					s.id_sucursal = ac.rela_sucursal
				JOIN
					contacto c
				ON
					ac.rela_contacto = c.id_contacto
				WHERE
					id_sucursal = ?";

		$stmt = $conexion->prepare($sql_sucursal);
		$stmt->bind_param("i", $id_sucursal);
		$stmt->execute();
		$registros = $stmt->get_result();
		$sucursal = $registros->fetch_assoc();

		$sql_sucursal_sin_contacto = "SELECT 
					id_sucursal,
					descripcion_sucursal,
					fecha_alta,
					fecha_de_creacion,
					rela_complejo,
					asd.direccion
				FROM
					sucursal s
				JOIN
					asignacion_sucursal_domicilio asd
				ON
					s.id_sucursal = asd.rela_sucursal
				WHERE
					id_sucursal = $id_sucursal";

		$registros = $conexion->query($sql_sucursal_sin_contacto);
		$datos = $registros->fetch_assoc();
		//ASIGNAMOS LOS DATOS DE LA SUCURSAL
		if($sucursal) {
			$id_sucursal 		= htmlspecialchars($sucursal['id_sucursal']);
			$nombre_sucursal 	= htmlspecialchars($sucursal['descripcion_sucursal']);
			$fecha_alta 		= htmlspecialchars($sucursal['fecha_alta']);
			$fecha_de_creacion 	= htmlspecialchars($sucursal['fecha_de_creacion']);
			$direccion 			= htmlspecialchars($sucursal['direccion']);
			$contacto 			= htmlspecialchars($sucursal['descripcion_contacto']);
		} else {
			$id_sucursal 		= htmlspecialchars($datos['id_sucursal']);
			$nombre_sucursal 	= htmlspecialchars($datos['descripcion_sucursal']);
			$fecha_alta 		= htmlspecialchars($datos['fecha_alta']);
			$fecha_de_creacion 	= htmlspecialchars($datos['fecha_de_creacion']);
			$direccion 			= htmlspecialchars($datos['direccion']);
		}

	//registros canchas
		$sql_canchas = "SELECT 
	                z.id_zona, 
	                z.descripcion_zona,
	                fd.descripcion_formato_deporte,
	                tt.descripcion_tipo_terreno
	            FROM 
	                ZONA z
	            JOIN
	                sucursal su ON z.rela_sucursal = su.id_sucursal
	            JOIN
					formato_deporte fd
	            ON
					fd.id_formato_deporte = z.rela_formato_deporte
	            JOIN
					tipo_terreno tt
	            ON
					tt.id_tipo_terreno = z.rela_tipo_terreno
	            WHERE 
	                z.rela_sucursal = ?";
	    $stmt = $conexion->prepare($sql_canchas);
	    $stmt->bind_param("i",$id_sucursal);
	    $stmt->execute();
	    $registros_canchas = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $nombre_sucursal; ?></title>
	<style type="text/css">
		*{font-family: arial;}
	</style>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL. 'php/sucursales/css/sucursal.css'; ?>">
	<script src="https://kit.fontawesome.com/03cc0c0d2a.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="<?php echo BASE_URL . 'css/aside/menu_aside_beterette.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/header.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
	<?php include(RUTA. 'includes/header_tincho.php'); ?>
	<?php include(RUTA. 'includes/menu_aside_beterette.php'); ?>

	<div class="contenido">
		
	

		<div class="container">

			    <div class="mitadSuperior">

			        <div class="contenedor-foto" style=
			        "background-image:url(<?php echo BASE_URL . 'assets/img/l_1573770810.jpg'; ?>);"
			        >

			            <div class="icono">
			                <img src="" alt="">
			                <h3><?php echo $nombre_sucursal; ?></h3>
			            </div>

			        </div>

			        <div class="info">
			            <h3><?php echo $nombre_sucursal; ?></h3>
			            <h4>Contacto! <?php if(isset($contacto)) {echo $contacto;} else {echo "...";} ?></h4>
			            <a href="<?php echo BASE_URL. "php/complejos/hacerse_socio.php?id_usuario=$id_usuario&id_complejo=$id_complejo"; ?>">Hazte Socio!</a>
			        </div>

			        <div class="info2">

			            <div class="direccion" align="center">
			                <!-- icono mapita -->
			                <h3><?php echo $direccion; ?></h3>
			            </div>

			            <div class="servicios">
			                <h3>Servicio</h3>
			                <div class="iconos">
			                    <div class="icono1">
			                        <div class="i">
			                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
			                            <small>luz</small>
			                        </div>
			                        <div class="i">
			                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
			                            <small>Camaras</small>
			                        </div>
			                        <div class="i">
			                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
			                            <small>Bar</small>
			                        </div>
			                        
			                        
			                    </div>
			                    <div class="icono2">	 
			                        <div class="i">
			                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
			                            <small>Vestuario</small>
			                        </div>
			                        <div class="i">
			                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
			                            <small>Wi-fi</small>
			                        </div>
			                        <div class="i">
			                            <i class="fa-solid fa-house" style="color: #ffffff;"></i>
			                            <small>Duchas</small>
			                        </div>
			                    </div>
			                </div>
			            </div>

			        </div>

			    </div>

			    <div class="mitadInferior">

			        <div class="canchas">

			        	<?php if ($registros_canchas->num_rows > 0) {  ?>

				        	<?php foreach ($registros_canchas as $reg) :?>

					            <div class="cancha">

					                <div class="info_cancha">
					                    <small><?php echo htmlspecialchars($reg['descripcion_zona']); ?></small>
					                    <small><?php echo htmlspecialchars($reg['descripcion_formato_deporte']); ?></small>
					                    <small>techo, luz, camara</small>
					                    <?php 
					                    	if ($perfil == "empleado" || $perfil == "administrador") {
					                    		echo '<a href="#"><i class="fa-solid fa-pen" style="color: #FFD43B;"></i></a>' . '<a href="#"><i class="fa-solid fa-trash" style="color: #c20000;"></i></a>';
					                    	}
					                    ?>
					                </div>

					            </div>

				        	<?php endforeach; ?>

				        <?php 
				    		} else {echo "<h2 align='center'>No hay canchas...</h2>";} 
				        ?>
			            
			        </div>


			        <div class="Altas">
			        	<a href="../tablaEmpleados/tablaEmpleados.php?id_sucursal=<?php echo $id_sucursal; ?>">Gestionar Empleados</a>
			        	<a href="../Socio/tabla_socios.php?id_complejo=<?php echo $id_complejo; ?>">Gestionar Socios</a><a href="<?php echo BASE_URL. "php/tablaZonasCanchas/tablaZonas.php?id_sucursal=$id_sucursal"; ?>">Gestionar canchas</a>
			        </div>
			    </div>

			</div>

		</div>

	</div>
</body>
</html>