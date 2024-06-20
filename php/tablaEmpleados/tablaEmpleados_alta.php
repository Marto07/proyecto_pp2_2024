<?php 
require_once("../../config/database/conexion.php");

$sqlComplejo = "SELECT 
                    id_complejo,
                    descripcion_complejo
                FROM 
                    complejo";
$registrosComplejo = $conexion->query($sqlComplejo);

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Empleado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #96E072;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #96E072;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px; color: white;">Modulo Alta de Empleados</h1>
    <form action="tablaEmpleados_aplicar_alta.php" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="">

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" value="" required>

        <label for="cargo">Cargo:</label>
        <select name="cargo">
            <option value=""disabled selected>Seleccione una Cargo...</option>
            <option value="Cantinero">Cantinero</option>
            <option value="Canchero">Canchero</option>
            <option value="Portero">Portero</option>
        </select>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="" required>

        <label for="complejo">Complejo:</label>
        <select id="complejo" name="complejo" required>
            <option value="" disabled selected>Seleccione un Complejo...</option>

            <?php foreach ($registrosComplejo as $reg) : ?>

                <option value="<?php echo $reg['id_complejo']; ?>">
                    <?php echo $reg['descripcion_complejo'];?>
                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit">Enviar</button>
    </form>

</body>
</html>
