<?php 
$idHora = $_GET['id_hora']; 
$fecha = $_GET['fecha'];
echo $fecha;

$conexion = mysqli_connect('localhost','root','','reserva_con_chat');

$sql = "SELECT * FROM hora WHERE id_hora = $idHora";
$resultado = mysqli_query($conexion,$sql);

if($reg = mysqli_fetch_assoc($resultado)) {
	$horaInicio = $reg['hora_inicio'];
	$horaFin    = $reg['hora_fin'];
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
    <form action="confirmarReserva4.php" method="post">
    	<h2>¿Quiere reservar la hora?</h2>
    	<div>
    		<ul>
    			<li>Hora de inicio: <?php echo $horaInicio; ?></li>
    			<li>Hora de Fin: <?php echo $horaFin; ?></li>
    			<li>Fecha de reserva: <?php echo $fecha; ?></li>
    		</ul>
    	</div>
        <input type="hidden" name="id_hora" value="<?php echo $idHora; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
        <button type="submit" name="aceptar">Aceptar</button>
        <button type="submit" name="cancelar">Cancelar</button>
    </form>
</body>
</html>