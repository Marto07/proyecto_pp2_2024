<?php 
require_once('../../config/database/conexion.php');
$idHora     = $_GET['id_horario']; 
$fecha      = $_GET['fecha_reserva'];
$persona    = $_GET['id_persona'];
$cancha     = $_GET['cancha'];

$sql = "SELECT * FROM horario WHERE id_horario = $idHora";
$resultado = mysqli_query($conexion,$sql);

if($reg = mysqli_fetch_assoc($resultado)) {
	$horaInicio = $reg['horario_inicio'];
	$horaFin    = $reg['horario_fin'];
}

$sqlPersona = "SELECT * FROM persona WHERE id_persona = $persona";
$resultadoPersona = $conexion->query($sqlPersona);

if($reg = mysqli_fetch_assoc($resultadoPersona)) {
    $nombre = $reg['nombre'];
    $apellido    = $reg['apellido'];
    $dni = $reg['dni'];
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
            width: 300px;
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
        button[type="submit"] {
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
    			<li>Hora de inicio: <?php echo $horaInicio; ?></li>
    			<li>Hora de Fin: <?php echo $horaFin; ?></li>
    			<li>Fecha de reserva: <?php echo $fecha; ?></li>
                <li>Titular: <?php echo $nombre . ' - '.$apellido.' - '.$dni; ?></li>
    		</ul>
    	</div>
        <input type="hidden" name="id_hora" value="<?php echo $idHora; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
        <input type="hidden" name="persona" value="<?php echo $persona; ?>">
        <input type="hidden" name="cancha" value="<?php echo $cancha; ?>">

        <button type="submit" name="aceptar">Aceptar</button>
        <button type="submit" name="cancelar">Cancelar</button>
    </form>
</body>
</html>