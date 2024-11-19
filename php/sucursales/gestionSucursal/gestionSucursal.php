<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

// Obtener las sucursales desde la base de datos
$sql = "SELECT * FROM persona p 
        JOIN empleado e ON e.rela_persona = p.id_persona
        JOIN sucursal s ON e.rela_sucursal = s.id_sucursal
        JOIN complejo c ON s.rela_complejo = c.id_complejo
        JOIN zona z ON z.rela_sucursal = s.id_sucursal
        JOIN formato_deporte fd ON z.rela_formato_deporte = fd.id_formato_deporte
        JOIN deporte d ON fd.rela_deporte = d.id_deporte
        GROUP BY s.id_sucursal";

$result = $conexion->query($sql);

$sucursales = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sucursales[] = $row;
    }
}

// Obtener el total de canchas y empleados por cada sucursal
$totalCanchas = [];
$totalEmpleados = [];
foreach ($sucursales as $sucursal) {
    $id_sucursal = $sucursal['id_sucursal'];

    // Consultar el total de canchas
    $queryCanchas = "SELECT COUNT(z.rela_sucursal) AS total_canchas
                     FROM zona z
                     JOIN sucursal s ON z.rela_sucursal = s.id_sucursal
                     WHERE s.id_sucursal = $id_sucursal
                     GROUP BY s.id_sucursal";
    $resultCanchas = $conexion->query($queryCanchas);
    $totalCanchas[$id_sucursal] = $resultCanchas->num_rows > 0 ? $resultCanchas->fetch_assoc()['total_canchas'] : 0;

    // Consultar el total de empleados
    $queryEmpleados = "SELECT COUNT(e.rela_sucursal) AS total_empleados
                       FROM empleado e
                       JOIN sucursal s ON e.rela_sucursal = s.id_sucursal
                       WHERE s.id_sucursal = $id_sucursal
                       GROUP BY s.id_sucursal";
    $resultEmpleados = $conexion->query($queryEmpleados);
    $totalEmpleados[$id_sucursal] = $resultEmpleados->num_rows > 0 ? $resultEmpleados->fetch_assoc()['total_empleados'] : 0;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sucursales</title>
    <style>
        .container {
            background-color: #0056b3;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Arial', sans-serif;
            color: #fff;
        }

        .title {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }

        .sucursal-card-container {
            background-color: #444;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            border-radius: 10px;
        }

        .sucursal-card {
            background-color: #d19b9b;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 15px;
            transition: transform 0.4s;
        }

        .sucursal-card:hover {
            transform: scale(1.05);
        }

        .sucursal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .sucursal-title {
            font-size: 18px;
            font-weight: bold;
        }

        .info-sucursal {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-sucursal p {
            margin: 0;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            gap: 5px;
        }

        .action-button {
            border: none;
            background-color: #007bff;
            color: #fff;
            padding: 5px 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .action-button:hover {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title">Mis Sucursales</h1>
        <div class="sucursal-card-container" id="sucursalList">
            <?php foreach ($sucursales as $sucursal): ?>
                <div class="sucursal-card">
                    <div class="sucursal-header">
                        <span class="complejo-title">
                            <?= $sucursal['descripcion_complejo'] ?>
                        </span>
                        <span class="sucursal-title">
                            <?= $sucursal['descripcion_sucursal'] ?>
                        </span>
                    </div>
                    <div class="info-sucursal">
                        <p>Empleados:
                            <?= $totalEmpleados[$sucursal['id_sucursal']] ?>
                        </p>
                        <button class="action-button" data-id="<?= $sucursal['id_sucursal'] ?>"
                            data-action="ver-empleados">Ver</button>
                        <button class="action-button" data-id="<?= $sucursal['id_sucursal'] ?>"
                            data-action="gestionar-empleados">Gestionar Empleados</button>
                    </div>
                    <div class="info-sucursal">
                        <p>Canchas:
                            <?= $totalCanchas[$sucursal['id_sucursal']] ?>
                        </p>
                        <button class="action-button" data-id="<?= $sucursal['id_sucursal'] ?>"
                            data-action="ver-canchas">Ver</button>
                        <button class="action-button" data-id="<?= $sucursal['id_sucursal'] ?>"
                            data-action="gestionar-canchas">Gestionar Canchas</button>
                    </div>
                    <div class="action-buttons">
                        <p>Gestion Sucursal</p>
                        <button class="action-button" data-id="<?= $sucursal['id_sucursal'] ?>"
                            data-action="ver-detalle">Ver</button>
                        <button class="action-button" data-id="<?= $sucursal['id_sucursal'] ?>"
                            data-action="modificar">Modificar</button>
                        <button class="action-button" data-id="<?= $sucursal['id_sucursal'] ?>"
                            data-action="eliminar">Eliminar</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="modalDetail">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.action-button').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = e.target.getAttribute('data-id');
                const action = e.target.getAttribute('data-action');
                handleModalAction(id, action);
            });
        });

        function handleModalAction(id, action) {
            switch (action) {
                case 'ver-empleados':
                    fetch(`php/ver_empleados.php?id_sucursal=${id}`)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('modalContent').innerHTML = data;
                            document.getElementById('modalDetail').style.display = 'flex';
                        });
                    break;
                case 'ver-canchas':
                    fetch(`php/ver_canchas.php?sucursal_id=${id}`)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('modalContent').innerHTML = data;
                            document.getElementById('modalDetail').style.display = 'flex';
                        });
                    break;
                    // Agregar más casos si es necesario para otras acciones
            }
        }

        function closeModal() {
            document.getElementById('modalDetail').style.display = 'none';
        }
    </script>
</body>

</html>