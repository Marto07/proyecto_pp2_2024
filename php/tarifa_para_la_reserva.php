<?php  
	$conexion = new mysqli("localhost", "root", "","proyecto_pp2");
	if (isset($_GET['id_zona'])) {
		$id_zona = $_GET['id_zona'];
	} else {
		$id_zona = 1;
	}


	$consulta_tarifa = "SELECT t.precio, t.horario_desde, t.horario_hasta
						FROM TARIFA t
						JOIN ASIGNACION_TARIFA_SERVICIO ts ON ts.rela_tarifa = t.id_tarifa
						JOIN ZONA z ON z.rela_servicio = ts.rela_servicio
						WHERE z.id_zona = ?;";
	$stmt = $conexion->prepare($consulta_tarifa);
	$stmt->bind_param("i",$id_zona);
	$stmt->execute();
	$resultado = $stmt->get_result();

	// Suponiendo que $resultado es el resultado de la consulta SQL anterior
	$tarifaDia = null;
	$tarifaNoche = null;

	foreach ($resultado as $fila) {
	    if ($fila['horario_desde'] == '06:00:00' && $fila['horario_hasta'] == '19:00:00') {
	        $tarifaDia = $fila['precio'];
	    } elseif ($fila['horario_desde'] == '20:00:00' && $fila['horario_hasta'] == '05:00:00') {
	        $tarifaNoche = $fila['precio'];
	    }
	}

	// Hora actual
	$horaActual = date('H:i:s', strtotime(' +5 hours'));

	// Comparar la hora actual con los rangos
	if ($horaActual >= '06:00:00' && $horaActual <= '19:00:00') {
	    $tarifaActual = $tarifaDia;
	} elseif ($horaActual >= '20:00:00' || $horaActual <= '05:00:00') {
	    $tarifaActual = $tarifaNoche;
	}

	echo "Son las : " . $horaActual . " - por lo tanto la tarifa vale: " . $tarifaActual;
	echo "<br>";


?>