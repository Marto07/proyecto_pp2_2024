<?php 
require_once("../../config/database/conexion.php");
$id = $_GET['id_empleado'];

$sqlComplejo = "SELECT 
                    id_complejo,
                    descripcion_complejo
                FROM 
                    complejo";
$registrosComplejo = $conexion->query($sqlComplejo);

$sql = "SELECT  
                        empleado.id_empleado,
                        persona.nombre,
                        persona.apellido,
                        persona.dni,
                        persona.cuil,
                        persona.fecha_nacimiento,
                        empleado.rela_persona,
                        empleado.empleado_cargo,
                        empleado.fecha_alta,
                        empleado.rela_complejo
                    FROM
                        empleado
                    JOIN
                        persona
                    ON
                        empleado.rela_persona = persona.id_persona
                    JOIN
                        complejo
                    ON
                        empleado.rela_complejo = complejo.id_complejo
                    WHERE
                        empleado.estado IN(1)
                    AND 
                        empleado.id_empleado = $id";

$registros = $conexion->query($sql);

foreach ($registros as $reg) {
        $id             = $reg['id_empleado'];
        $nombre         = $reg['nombre'];
        $apellido       = $reg['apellido'];
        $dni            = $reg['dni'];
        $cargo          = $reg['empleado_cargo'];
        $fechaNacimiento= $reg['fecha_nacimiento'];
        $fechaAlta      = $reg['fecha_alta'];
        $complejo       = $reg['rela_complejo'];
        $relaPersona    = $reg['rela_persona'];
}

if (isset($_POST['modificacion'])) {
                $nombre         = $_POST['nombre'];
                $apellido       = $_POST['apellido'];
                $dni            = $_POST['dni'];
                $cargo          = $_POST['cargo'];
                $fechaNacimiento= $_POST['fecha_nacimiento'];
                $complejo       = $_POST['complejo'];

    $sqlPersona = "UPDATE
                persona
            SET 
                nombre = '$nombre',
                apellido = '$apellido',
                dni = '$dni',
                fecha_nacimiento = '$fechaNacimiento'
            WHERE
                id_persona = $relaPersona";

    if ($conexion->query($sqlPersona)) {
        $sqlEmpleado = "UPDATE
                            empleado
                        SET
                            empleado_cargo = '$cargo',
                            rela_complejo = $complejo
                        WHERE
                            id_empleado = $id";
        if($conexion->query($sqlEmpleado)) {

            header("Location: tablaEmpleados.php");

        }
    }




}
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Empleado</title>
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

    <h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px; color: white;">Modulo Modificacion de Empleado</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']. '?id_empleado='. $id;?>" method="post" onsubmit="return confirmModification();">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" value="<?php echo $dni; ?>" required>

        <label for="cargo">Cargo:</label>
        <select name="cargo">
            <option value=""disabled selected>Seleccione una Cargo...</option>
            <option value="Cantinero">Cantinero</option>
            <option value="Canchero">Canchero</option>
            <option value="Portero">Portero</option>
        </select>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fechaNacimiento ?>" required>

        <label for="complejo">Complejo:</label>
        <select id="complejo" name="complejo" required>
            <option value="" disabled selected>Seleccione un Complejo...</option>

            <?php foreach ($registrosComplejo as $reg) : ?>

                <option value="<?php echo $reg['id_complejo']; ?>" <?php if($complejo == $reg['id_complejo']) {echo 'selected';} ?>>
                    <?php echo $reg['descripcion_complejo'];?>
                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit" name="modificacion">Enviar</button>
    </form>

</body>
</html>
