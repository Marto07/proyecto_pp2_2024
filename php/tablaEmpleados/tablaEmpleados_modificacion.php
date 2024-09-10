<?php 
require_once("../../config/database/conexion.php");
$id = $_GET['id_empleado'];

$sqlSucursal = "SELECT 
                    id_sucursal,
                    descripcion_sucursal
                FROM 
                    sucursal";
$registrosSucursal = $conexion->query($sqlSucursal);

$sql = "SELECT  
                        empleado.id_empleado,
                        persona.nombre,
                        persona.apellido,
                        persona.rela_documento,
                        documento.descripcion_documento,
                        persona.fecha_nacimiento,
                        empleado.rela_persona,
                        empleado.empleado_cargo,
                        empleado.fecha_alta,
                        empleado.rela_sucursal
                    FROM
                        empleado
                    JOIN
                        persona
                    ON
                        empleado.rela_persona = persona.id_persona
                    JOIN
                        sucursal
                    ON
                        empleado.rela_sucursal = sucursal.id_sucursal
                    JOIN 
                        documento
                    ON
                        documento.id_documento = persona.rela_documento
                    WHERE
                        empleado.estado IN(1)
                    AND 
                        empleado.id_empleado = $id";

$registros = $conexion->query($sql);

foreach ($registros as $reg) {
        $id             = $reg['id_empleado'];
        $nombre         = $reg['nombre'];
        $apellido       = $reg['apellido'];
        $documento      = $reg['descripcion_documento'];
        $cargo          = $reg['empleado_cargo'];
        $fechaNacimiento= $reg['fecha_nacimiento'];
        $fechaAlta      = $reg['fecha_alta'];
        $sucursal       = $reg['rela_sucursal'];
        $relaPersona    = $reg['rela_persona'];
}

if (isset($_POST['modificacion'])) {
                $nombre         = $_POST['nombre'];
                $apellido       = $_POST['apellido'];
                $documento      = $_POST['documento'];
                $cargo          = $_POST['cargo'];
                $fechaNacimiento= $_POST['fecha_nacimiento'];
                $sucursal       = $_POST['sucursal'];

    // Iniciamos la transacción
    $conexion->begin_transaction();

    try {
        // Actualizar documento
        $sqlDocumento = "UPDATE documento 
                            SET descripcion_documento = ? 
                            WHERE id_documento = ?";
        $stmtDocumento = $conexion->prepare($sqlDocumento);
        $stmtDocumento->bind_param("si", $documento, $relaDocumento);
        $stmtDocumento->execute();

        // Actualizar persona
        $sqlPersona = "UPDATE persona 
                        SET nombre = ?, apellido = ?, fecha_nacimiento = ?
                        WHERE id_persona = ?";
        $stmtPersona = $conexion->prepare($sqlPersona);
        $stmtPersona->bind_param("sssi", $nombre, $apellido, $fechaNacimiento, $relaPersona);
        $stmtPersona->execute();

        // Actualizar empleado
        $sqlEmpleado = "UPDATE empleado 
                            SET empleado_cargo = ?, rela_sucursal = ?
                            WHERE id_empleado = ?";
        $stmtEmpleado = $conexion->prepare($sqlEmpleado);
        $stmtEmpleado->bind_param("sii", $cargo, $sucursal, $id);
        $stmtEmpleado->execute();

        // Si todo salió bien, hacemos el commit
        $conexion->commit();

        // Redireccionar si todo fue exitoso
        header("Location: tablaEmpleados.php");

    } catch (Exception $e) {
        // Si ocurre algún error, hacemos un rollback
        $conexion->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Cerramos las conexiones
    $stmtDocumento->close();
    $stmtPersona->close();
    $stmtEmpleado->close();
    $conexion->close();

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

        <label for="dni">Documento:</label>
        <input type="text" id="documento" name="documento" value="<?php echo $documento; ?>" required>

        <label for="cargo">Cargo:</label>
        <select name="cargo">
            <option value=""disabled selected>Seleccione una Cargo...</option>
            <option value="Cantinero">Cantinero</option>
            <option value="Canchero">Canchero</option>
            <option value="Portero">Portero</option>
        </select>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fechaNacimiento ?>" required>

        <label for="sucursal">Sucursal:</label>
        <select id="sucursal" name="sucursal" required>
            <option value="" disabled selected>Seleccione un sucursal...</option>

            <?php foreach ($registrosSucursal as $reg) : ?>

                <option value="<?php echo $reg['id_sucursal']; ?>" <?php if($sucursal == $reg['id_sucursal']) {echo 'selected';} ?>>
                    <?php echo $reg['descripcion_sucursal'];?>
                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit" name="modificacion">Enviar</button>
    </form>

</body>
</html>
