<?php 
session_start();
require_once('../../../config/root_path.php');
require_once(RUTA . 'config/database/db_functions/zonas.php');
require_once(RUTA . 'config/database/db_functions/personas.php');
$id_horario     = $_GET['id_horario']; 
$fecha          = $_GET['fecha_reserva'];
$id_usuario     = $_SESSION['id_usuario'];
$usuario        = $_SESSION['usuario'];
$cancha         = $_GET['cancha'];

$registros = obtenerHorario($id_horario);

if($reg = $registros->fetch_assoc()) {
	$horario_inicio = $reg['horario_inicio'];
	$horario_fin    = $reg['horario_fin'];
}


$registros = obtenerPersonaPorUsuario($id_usuario);

if($reg = $registros->fetch_assoc()) {
    $id_persona = $reg['id_persona'];
    $nombre = $reg['nombre'];
    $apellido = $reg['apellido'];
    $documento = $reg['descripcion_documento'];
}





// CALCULO DE LA TARIFA

    $consulta_tarifa = "SELECT t.precio, t.horario_desde, t.horario_hasta
                        FROM TARIFA t
                        JOIN ASIGNACION_TARIFA_SERVICIO ts ON ts.rela_tarifa = t.id_tarifa
                        JOIN ZONA z ON z.rela_servicio = ts.rela_servicio
                        WHERE z.id_zona = ?;";
    $stmt = $conexion->prepare($consulta_tarifa);
    $stmt->bind_param("i",$cancha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Suponiendo que $resultado es el resultado de la consulta SQL anterior
    $tarifaDia = 8000;
    $tarifaNoche = 10000;

    foreach ($resultado as $fila) {
        if ($fila['horario_desde'] == '06:00:00' && $fila['horario_hasta'] == '19:00:00') {
            $tarifaDia = $fila['precio'];
        } elseif ($fila['horario_desde'] == '20:00:00' && $fila['horario_hasta'] == '05:00:00') {
            $tarifaNoche = $fila['precio'];
        }
    }

    // Hora actua
    $horaActual = date('H:i:s');

    // Comparar la hora actual con los rangos
    if ($horaActual >= '06:00:00' && $horaActual <= '19:00:00') {
        $tarifaActual = $tarifaDia;
    } else{
        $tarifaActual = $tarifaNoche;
    }

// CALCULO DE LA TARIFA








?>
<html>
<head>
    <title>Formulario de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #333;
        }
        form {
            width: 350px;
            height: 300px;
            margin: 0 auto;
            margin-top: 10vh;
            text-align: center;
            background-color: lightgray;
            border-radius: 15px;
            border: 1px solid darkgray;
        }

        div{
        	text-align: left;
        }

        ul {
        	list-style: none;
        }
        
        input[type="hidden"] {
            display: none; /* Input oculto */
        }

        button[type="submit"], button[type="button"]{
            padding: 10px 20px;
            margin: 10px;
            border: none;
            cursor: pointer;
        }

        button[name="aceptar"] {
            background-color: #0074D9; /* Azul */
            color: #fff;
        }

        button[name="cancelar"] {
            background-color: #FF4136; /* Rojo */
            color: #fff;
        }
    </style>
</head>
<body>
    <form action="formularioReserva4.php" method="post">
    	<h2>¿Quiere reservar la hora?</h2>
    	<div>
    		<ul>
    			<li>Hora de inicio: <?php echo $horario_inicio; ?></li>
    			<li>Hora de Fin: <?php echo $horario_fin; ?></li>
    			<li>Fecha de reserva: <?php echo $fecha; ?></li>
                <li>Nombre de Usuario <?php echo $usuario; ?></li>
                <li>Titular: <?php echo $nombre. " - " .$apellido. " - " . $documento?></li>
                <li>Precio: <?php echo $tarifaActual; ?></li>
                <br>
                <li>Ingresar Pago: <input type="text" name="monto_pagado"></li>
    		</ul>
    	</div>
        <input type="hidden" name="id_horario" value="<?php echo $id_horario; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
        <input type="hidden" name="persona" value="<?php echo $id_persona; ?>">
        <input type="hidden" name="cancha" value="<?php echo $cancha; ?>">
        <input type="hidden" name="monto_total" value="<?php echo $tarifaActual; ?>">

        <button type="submit" name="aceptar" id="submit">Aceptar</button>
        <button type="button" name="cancelar" id="cancelar">Cancelar</button>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let boton_cancelar = $('#cancelar');
        boton_cancelar.on('click', function() { 
            location.href='formularioReserva1.php?';
        });
    });

</script>
</html>