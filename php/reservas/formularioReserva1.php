<?php

require_once('../../config/database/conexion.php');

$sqlCancha  = "SELECT
                    id_zona,
                    descripcion_zona,
                    descripcion_complejo
                FROM
                    zona
                JOIN 
                    complejo
                ON
                    zona.rela_Complejo = complejo.id_complejo
                JOIN 
                    servicio
                ON
                    zona.rela_servicio = servicio.id_servicio
                WHERE
                    servicio.descripcion_servicio LIKE 'cancha'
                AND
                    zona.estado IN (1)";



$sqlPersona = "SELECT
                    id_persona,
                    nombre,
                    apellido
                FROM 
                    persona
                WHERE 
                    estado IN (1)";

$registrosCancha  = $conexion->query($sqlCancha);
$registrosPersona = $conexion->query($sqlPersona);

?>

<html>
<head>
    <title>Buscar Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #333;
        }
        form {
            background-color: lightgray;
            border: 2px solid darkgray;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            margin-top:10vh;
            text-align: center;
            border-radius: 15px;
        }
        input[type="date"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid darkgray;
        }
        button[type="submit"] {
            background-color: #0074D9; /* Azul */
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-top: 25px;">Modulo de Buscqueda de Reservas</h1>
    <form action="formularioReserva2.php" method="get">
        <h2>Buscar reservas por cancha y fecha</h2>

        <input type="date" name="fecha_reserva">

        <select name="cancha" id="" required>
            <option value="" disabled selected>Eliga Cancha</option>
            <?php foreach ($registrosCancha as $reg) :?>
                <option value="<?php echo $reg['id_zona']; ?> ">
                    <?php echo $reg['descripcion_zona']. ' - '.$reg['descripcion_complejo'];?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="persona" id="" required>
            <option value="" disabled selected>titular de reserva</option>
            <?php foreach ($registrosPersona as $reg) :?>
                <option value="<?php echo $reg['id_persona']; ?> ">
                    <?php echo $reg['nombre']. ' - '.$reg['apellido'];?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Buscar</button>



    </form>
</body>
</html>
