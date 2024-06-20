<?php 
	$consulta_original="SELECT 
				horario.id_horario,
				horario.horario_inicio,
	    		horario.horario_fin,
	    		reserva.id_reserva,
	            zona.descripcion_zona,
	            complejo.descripcion_complejo,
	   			IF (reserva.id_reserva IS NULL, 'disponible', 'no-disponible') AS estado
			FROM 
	       		horario
				LEFT JOIN 
	            	`reserva` 
	            ON 
	            	horario.id_horario = reserva.rela_horario 
	            AND 
	            	reserva.fecha_reserva = '2023-11-30'
	        	JOIN
	            	zona
				ON
					zona.id_zona = reserva.rela_zona
				JOIN 
					complejo
				ON
					zona.rela_complejo = complejo.id_complejo
	            AND
					id_complejo = 5
			ORDER BY (horario.id_horario);";

	$verdadera_consulta="SELECT 
			horario.id_horario,
			horario.horario_inicio,
    		horario.horario_fin,
    		reserva.id_reserva,
            persona.nombre,
            persona.apellido,
            persona.dni,
            zona.descripcion_zona,
            complejo.descripcion_complejo,
   			IF (reserva.id_reserva IS NULL, 'disponible', 'no-disponible') AS estado
		FROM 
       		
            	zona
			JOIN 
				complejo
			ON
				zona.rela_complejo = complejo.id_complejo
            AND
				id_complejo = 5
            JOIN 
            	`reserva` 
            ON 
            	reserva.rela_zona = zona.id_zona
            JOIN
				persona
            ON
				reserva.rela_persona = persona.id_persona
			
            RIGHT JOIN 
             	horario
           	ON
            	horario.id_horario = reserva.rela_horario
            AND
            	reserva.fecha_reserva = '2023-11-30'
        	
		ORDER BY (horario.id_horario)";
	?>