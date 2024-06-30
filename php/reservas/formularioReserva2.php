<?php 
session_start();
require_once('../../config/root_path.php');
require_once(RUTA . "config/database/db_functions/zonas.php");

$fecha   = $_GET['fecha_reserva'];
$cancha  = $_GET['cancha'];




$registros = ObtenerHorariosDisponibles($cancha, $fecha);
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

 		.disponible{
 			background-color: lightgreen;
 			color: white;
 			padding: 10px;
 		}

 		.no-disponible {
 			background-color: red;
 			color: white;
 			padding: 10px;
 		}

        span {
            padding: 10px;
        }
 	</style>
 </head>
 <body>

    <table class="horarios">
        <tbody>
            
            <?php
                $index = 0;
                foreach ($registros as $reg) {

                    if ($index % 4 == 0) {
                        if ($index != 0) {
                            echo '</tr>';
                        }
                        echo '<tr>';
                    }

                    $horario = substr($reg['horario_inicio'], 0, 2);
                    $estado = $reg['estado'];
                    $id_horario = $reg['id_horario'];
                    ?>
                    <td class="<?php echo $estado; ?>" id-hora="<?php echo $id_horario; ?>">
                        <?php echo htmlspecialchars($horario) ?>
                    </td>
                    <?php
                    $index++;
                }

                if ($index % 4 != 0) {
                    echo '</tr>';
                }
            ?>

        </tbody>
    </table>
 	
 </body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
 <script>
 	
 	/*let tabla = document.getElementsByTagName('table')[0];
 	let celdasDisponibles = tabla.querySelectorAll('td.disponible');

 	celdasDisponibles.forEach(function(celda) {
 		let idHora = celda.getAttribute('id-hora');
 		let hora = celda.textContent;
 		let enlace = document.createElement('a');
 		
 		enlace.href = "formularioReserva3.php?id_horario=" + encodeURIComponent(idHora) + 
 		"&fecha_reserva=<?php echo $fecha; ?> + &id_persona=<?php echo $_SESSION['id']; ?> + &cancha=<?php echo $cancha; ?>";
 		enlace.textContent = hora;

 		celda.innerHTML = "";
 		celda.appendChild(enlace);

 	});*/

 	// En lugar de document.getElementsByTagName, puedes usar $('table:eq(0)')
let tabla = $('table:eq(0)');
let celdasDisponibles = tabla.find('td.disponible');

celdasDisponibles.each(function() {
    let celda = $(this);
    let idHora = celda.attr('id-hora');
    let hora = celda.text();
    let enlace = $('<a></a>');

    enlace.attr('href', "formularioReserva3.php?id_horario=" + encodeURIComponent(idHora) + 
        "&fecha_reserva=<?php echo $fecha; ?> + &id_persona=<?php echo $_SESSION['id_usuario']; ?> + &cancha=<?php echo $cancha; ?>");
    enlace.text(hora);

    celda.empty().append(enlace);
});

 </script>
 </html>