<?php 
require_once('../../config/database/conexion.php');

$fecha   = $_GET['fecha_reserva'];
$cancha  = $_GET['cancha'];
$persona = $_GET['persona'];

echo $fecha."<br>". $cancha."<br>".$persona;

$sql = "SELECT 
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
                id_zona = $cancha
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
                reserva.fecha_reserva = '$fecha'
            
        ORDER BY (horario.id_horario)";

$registros = $conexion->query($sql);
?>

 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>RESERVA</title>
 	<style>
 		body {
 			padding:0;
 			margin:0;
 			font-family: arial;
 			background-color: rgba(0, 0, 0, 0.0);
 		}

 		table {
 			margin: auto;
 			margin-top: 10vh;
 			
 		}

 		table .disponible{
 			background-color: lightgreen;
 			color: white;
 			padding: 10px;
 		}

 		table .no-disponible {
 			background-color: red;
 			color: white;
 			padding: 10px;
 		}
 	</style>
 </head>
 <body>

 	<table>
 		<tbody>
            <h1 style="text-align: center; margin-top: 25px;">Modulo de Disponibilidad Reservas</h1>
 			
 			<?php foreach ($registros as $reg) { ?>

 				<tr>
 					<td class="<?PHP echo $reg['estado'] ?>" id-hora="<?php echo $reg['id_horario'] ?>">
 					 	<?php echo $reg['horario_inicio']; ?> 
 					</td>
 					<td class="<?PHP echo $reg['estado'] ?>" id-hora="<?php echo $reg['id_horario'] ?>">
 						<?php echo $reg['horario_fin']; ?> 
 					</td>
 					<td class="<?PHP echo $reg['estado'] ?>" id-hora="<?php echo $reg['id_horario'] ?>">
 						<?php echo $reg['estado']; ?> 
 					</td>
 				</tr>

 			<?php } ?>

 		</tbody>
 	</table>
 	
 </body>

 <script>
 	
 	let tabla = document.getElementsByTagName('table')[0];
 	let celdasDisponibles = tabla.querySelectorAll('td.disponible');

 	celdasDisponibles.forEach(function(celda) {
 		let idHora = celda.getAttribute('id-hora');
 		let hora = celda.textContent;
 		let enlace = document.createElement('a');
 		
 		enlace.href = "formularioReserva3.php?id_horario=" + encodeURIComponent(idHora) + 
 		"&fecha_reserva=<?php echo $fecha; ?> + &id_persona=<?php echo $persona; ?> + &cancha=<?php echo $cancha; ?>";
 		enlace.textContent = hora;

 		celda.innerHTML = "";
 		celda.appendChild(enlace);

 	});

 	// En lugar de document.getElementsByTagName, puedes usar $('table:eq(0)')
/*let tabla = $('table:eq(0)');
let celdasDisponibles = tabla.find('td.disponible');

celdasDisponibles.each(function() {
    let celda = $(this);
    let idHora = celda.attr('id-hora');
    let hora = celda.text();
    let enlace = $('<a></a>');

    enlace.attr('href', "formularioReserva.php3?id_hora=" + encodeURIComponent(idHora) + "&fecha=<?php echo $fecha ?>");
    enlace.text(hora);

    celda.empty().append(enlace);
});
*/
 </script>
 </html>