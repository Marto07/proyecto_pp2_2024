<?php 
$fecha = $_GET['fecha'];
$conexion = mysqli_connect("localhost", "root", "","reserva_con_chat");

$sql = "SELECT 
			h.id_hora,
			h.hora_inicio,
    		h.hora_fin,
    		r.id_reserva,
   			IF (r.id_reserva IS NULL, 'disponible', 'no-disponible') AS estado
		FROM hora as h
			LEFT JOIN `reserva` AS r ON h.id_hora = r.rela_hora AND r.fecha = '$fecha'
		ORDER BY (h.hora_inicio);";

$resultado = mysqli_query($conexion, $sql);
 ?>

 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>Document</title>
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
 			
 			<?php foreach ($resultado as $reg) { ?>

 				<tr>
 					<td class="<?PHP echo $reg['estado'] ?>" id-hora="<?php echo $reg['id_hora'] ?>">
 					 	<?php echo $reg['hora_inicio']; ?> 
 					</td>
 					<td class="<?PHP echo $reg['estado'] ?>" id-hora="<?php echo $reg['id_hora'] ?>">
 						<?php echo $reg['hora_fin']; ?> 
 					</td>
 					<td class="<?PHP echo $reg['estado'] ?>" id-hora="<?php echo $reg['id_hora'] ?>">
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
 		
 		enlace.href = "formularioReserva3.php?id_hora=" + encodeURIComponent(idHora) + 
 		"&fecha=<?php echo $fecha ?>";
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