<?php 
require_once("../../config/database/conexion.php");

$sqlSucursal = "SELECT 
                    id_sucursal,
                    descripcion_sucursal
                FROM 
                    sucursal";

$sqlTipoDocumento = "SELECT
                        id_tipo_documento,
                        descripcion_tipo_documento
                    FROM
                        tipo_documento
                    WHERE 
                        estado IN(1)";

$registrosSucursal = $conexion->query($sqlSucursal);

$registrosTipoDocumento = $conexion->query($sqlTipoDocumento);
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

        /* MODAL */
        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none; /* Oculto por defecto */
            justify-content: center;
            align-items: center;
        }
        .notification-box {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 90%; /* Limitar el ancho máximo */
            width: 300px; /* Ajustar según el tamaño del formulario */
            margin:auto;
            margin-top:30vh;
        }

        .notification-box p {
            margin: 0 0 15px;
        }

        .notification-box .close-btn {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        /* MODAL */
    </style>
</head>
<body>

    <!-- MODAL  -->
    <div class="notification-overlay" id="notificationOverlay">
        <div class="notification-box">
            <p>Persona repetida.</p>
            <small>Esta persona ya fue insertada:</small>
            <p>nombre:<?php echo " " . $_GET['nombre']; ?></p>
            <p>apellido:<?php echo " " . $_GET['apellido']; ?></p>
            <p>documento:<?php echo " " . $_GET['documento']; ?></p>
            <p>fecha de nacimiento:<?php echo " " . $_GET['fecha_nacimiento']; ?></p>


            <button class="close-btn" id="closeNotification">Cerrar</button>
        </div>
    </div>

    <h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px; color: white;">Modulo Alta de Empleados</h1>
    <form action="tablaEmpleados_aplicar_alta.php" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="">

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="" required>


        <label for="documento">Documento:</label>
        <input type="text" id="documento" name="documento" value="" required>

        <label for="tipo_documento">Tipo de documento:</label>
        <select name="tipo_documento">
            <option value=""disabled selected>Seleccione una tipo de documento...</option>
            <?php foreach ($registrosTipoDocumento as $reg) { ?>
                <option value="<?php echo $reg['id_tipo_documento']; ?>"><?php echo $reg['descripcion_tipo_documento']; ?></option>
            <?php } ?>
        </select>

        <label for="cargo">Cargo:</label>
        <select name="cargo">
            <option value=""disabled selected>Seleccione una Cargo...</option>
            <option value="Personal Administrativo">Personal Administrativo</option>
            <option value="Portero">Portero</option>
        </select>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="" required>

        <label for="sucursal">Sucursal:</label>
        <select id="sucursal" name="sucursal" required>
            <option value="" disabled selected>Seleccione una Sucursal...</option>

            <?php foreach ($registrosSucursal as $reg) : ?>

                <option value="<?php echo $reg['id_sucursal']; ?>">
                    <?php echo $reg['descripcion_sucursal'];?>
                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit">Enviar</button>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            //funcion cerrar el modal 
            $('#closeNotification').on('click', function() {
                $('#notificationOverlay').hide();
            });


            // Mostrar el modal solo si se detecta la variable 'persona_repetida' en la URL
            <?php if (isset($_GET['persona_repetida'])): ?>
                $('#notificationOverlay').show();
            <?php endif; ?>
        });//FIN DOCUMENT READY
    </script>

</body>
</html>
