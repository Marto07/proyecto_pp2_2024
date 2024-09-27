<?php 
session_start();
require_once('../../../config/root_path.php');
require_once(RUTA . 'config/database/conexion.php');
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



// Obtener la hora actual en formato 24 horas
$hora_actual = date('H:i:s');

// ID de la sucursal (supongamos que viene de una petición GET o de una variable)
$id_sucursal = isset($_GET['id_sucursal']) ? $_GET['id_sucursal'] : 1;

// Consulta para obtener las tarifas de la sucursal
$sql = "SELECT * FROM tarifa WHERE rela_sucursal = ? AND estado = 1 ORDER BY hora_inicio";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_sucursal);
$stmt->execute();
$result = $stmt->get_result();

// Variable para guardar la tarifa seleccionada
$tarifa_seleccionada = null;

while ($fila = $result->fetch_assoc()) {
    $hora_desde = $fila['hora_inicio'];
    $hora_hasta = $fila['hora_fin'];
    
    // Comparar si la hora actual está en el rango
    if ($hora_desde <= $hora_hasta) {
        // Caso donde el rango es del mismo día (ejemplo 06:00 - 12:00)
        if ($hora_actual >= $hora_desde && $hora_actual <= $hora_hasta) {
            $tarifa_seleccionada = $fila;
            break;
        }
    } else {
        // Caso donde el rango cruza la medianoche (ejemplo 20:00 - 05:00)
        if ($hora_actual >= $hora_desde || $hora_actual <= $hora_hasta) {
            $tarifa_seleccionada = $fila;
            break;
        }
    }
}

// Mostrar la tarifa seleccionada
if ($tarifa_seleccionada) {
    echo "Tarifa: " . $tarifa_seleccionada['descripcion_tarifa'] . "<br>";
    echo "Precio: $" . $tarifa_seleccionada['precio'] . "<br>";
    echo $hora_actual;
} else {
    echo "No se encontró una tarifa para la hora actual.";
}
    

// Consulta para obtener el precio de la cancha o el precio general de la sucursal si es NULL.
    /*
        $sql = "SELECT 
            IFNULL(c.precio, t.precio) AS precio_final
        FROM 
            cancha c
        JOIN 
            sucursal s ON c.rela_sucursal = s.id_sucursal
        JOIN 
            tarifa t ON s.id_sucursal = t.rela_sucursal
        WHERE 
            c.id_cancha = :id_cancha
        AND 
            t.hora_inicio <= :hora_actual AND t.hora_fin >= :hora_actual";
    */








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
                <li>Precio: <?php echo $tarifa_seleccionada['precio']; ?></li>
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

<?php 
    
?>