<?php 
	require_once(RUTA."config/database/conexion.php");

	function obtenerZonas() {

		global $conexion;

		$sql = "SELECT
                    id_zona,
                    descripcion_zona,
                    descripcion_sucursal,
                    descripcion_complejo
                FROM
                    zona
                JOIN 
                    sucursal
                ON
                    zona.rela_sucursal = sucursal.id_sucursal
                JOIN 
                	complejo 
                ON
                	sucursal.rela_complejo = complejo.id_complejo
                JOIN
                    servicio
                ON
                    zona.rela_servicio = servicio.id_servicio
                WHERE
                    servicio.descripcion_servicio LIKE 'cancha'
                AND
                    zona.estado IN (1)";

        $stmt = $conexion->prepare($sql);
        $registros = [];

        if($stmt->execute()) {
        	$registros = $stmt->get_result();
        	return $registros;
        } 

    }


    function ObtenerHorariosDisponibles($id_zona, $fecha) {
    	global $conexion;

    	$sql = "SELECT 
            		horario.id_horario,
            		horario.horario_inicio,
		            horario.horario_fin,
		            reserva.id_reserva,
		            zona.descripcion_zona,
		            sucursal.descripcion_sucursal,
		            complejo.descripcion_complejo,
		            IF (reserva.id_reserva IS NULL, 'disponible', 'no-disponible') AS estado
        		FROM 
	                zona
	            JOIN 
	            	sucursal
	            ON
	            	zona.rela_sucursal = sucursal.id_sucursal
	            JOIN
	                complejo
	            ON
	                sucursal.rela_complejo = complejo.id_complejo
	            AND
	                id_zona = ?
	            JOIN 
	                reserva 
	            ON 
	                reserva.rela_zona = zona.id_zona
	            RIGHT JOIN 
	                horario
	            ON
	                horario.id_horario = reserva.rela_horario
	            AND
	                reserva.fecha_reserva = ?
	        ORDER BY (horario.horario_inicio)";

	        $stmt = $conexion->prepare($sql);
	        $stmt->bind_param("is", $id_zona, $fecha);
	        $registros = [];

	        if($stmt->execute()) {
	        	$registros = $stmt->get_result();
	        	return $registros;
	        } 
    }
?>