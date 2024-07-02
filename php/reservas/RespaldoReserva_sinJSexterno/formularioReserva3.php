<?php 
session_start();
require_once('../../config/root_path.php');
require_once(RUTA . 'config/database/db_functions/zonas.php');
$id_horario     = $_GET['id_horario']; 
$fecha      = $_GET['fecha_reserva'];
$id_usuario  = $_SESSION['id_usuario'];
$usuario    = $_SESSION['usuario'];
$cancha     = $_GET['cancha'];

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
    		</ul>
    	</div>
        <input type="hidden" name="id_horario" value="<?php echo $id_horario; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
        <input type="hidden" name="persona" value="<?php echo $id_persona; ?>">
        <input type="hidden" name="cancha" value="<?php echo $cancha; ?>">

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