<?php
    session_start();
    require_once("../../../config/root_path.php");
    $ruta = RUTA;
    require_once($ruta . "config/database/db_functions/zonas.php");
    require_once($ruta . "config/database/db_functions/personas.php");
    $registrosCancha = obtenerZonas();
    $registrosPersona = obtenerPersonas();
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
    <form action="formularioReserva2.php" method="get">
        <h2>Buscar reservas por fecha</h2>
        <input type="date" name="fecha_reserva">
        <select name="cancha" id="" required>
            <option value="" disabled selected>Eliga Cancha</option>
            <?php foreach ($registrosCancha as $reg) :?>
                <option value="<?php echo $reg['id_zona']; ?> ">
                    <?php echo $reg['descripcion_zona']. ' - '.$reg['descripcion_sucursal']. ' - ' .$reg['descripcion_complejo'];?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="persona" id="" required>
            <option value="" disabled selected>Eliga un titular</option>
            <?php foreach ($registrosPersona as $reg) :?>
                <option value="<?php echo $reg['id_persona']; ?> ">
                    <?php echo $reg['nombre']. ' - '.$reg['apellido']. ' - ' .$reg['descripcion_documento'];?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>
