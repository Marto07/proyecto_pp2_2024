<?php
// Conexión a la base de datos
require_once("./../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Reservas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: #fff;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
            gap: 2rem;
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
        }

        .filter-container label {
            font-weight: 500;
            margin-right: 0.5rem;
            color: #555;
        }

        .filter-container select,
        .filter-container input {
            margin-bottom: 4px;
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #333;
            transition: border-color 0.3s;
        }

        .filter-container select:focus,
        .filter-container input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .chart-container {
            width: 100%;
            max-width: 900px;
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .chart-container:hover {
            transform: scale(1.02);
        }

        .reservas-details {
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        .reservas-details:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .reservas-details h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            padding: 1rem;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .reservas-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .reservas-details th,
        .reservas-details td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f0f2f5;
        }

        .reservas-details th {
            background-color: #4CAF50;
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .reservas-details td {
            font-size: 0.9rem;
            color: #555;
        }

        .reservas-details tr:hover {
            background-color: #f9f9f9;
        }

        .reservas-details tr td {
            transition: background-color 0.3s ease;
        }

        .reservas-details tr td:first-child {
            border-left: 5px solid #4CAF50;
            padding-left: 0.75rem;
        }

        /* Flatpickr input style */
        #fechaRango {
            padding: 0.5rem;
            font-size: 0.9rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
            transition: border-color 0.3s;
        }

        #fechaRango:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .filter-container,
            .chart-container,
            .reservas-details {
                width: 90%;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Dashboard de Reservas por Sucursal</h1>
    </header>

    <main>
        <section class="filter-container" style="width: 90%; padding: 5px;">
            <form id="filterForm">
                <label for="complejo">Complejo:</label>
                <select id="complejo" name="complejo">
                    <option value="">Selecciona un Complejo</option>
                    <?php
                    // Código PHP para cargar los complejos
                    $sql = "SELECT id_complejo, descripcion_complejo FROM complejo";
                    $result = $conexion->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_complejo"] . "'>" . $row["descripcion_complejo"] . "</option>";
                    }
                    ?>
                </select>

                <label for="sucursal">Sucursal:</label>
                <select id="sucursal" name="sucursal">
                    <option value="">Selecciona una Sucursal</option>
                    <?php
                    // Código PHP para cargar todas las sucursales inicialmente
                    $sql = "SELECT id_sucursal, descripcion_sucursal FROM sucursal";
                    $result = $conexion->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_sucursal"] . "'>" . $row["descripcion_sucursal"] . "</option>";
                    }
                    ?>
                </select>

                <label for="deporte">Deporte:</label>
                <select id="deporte" name="deporte">
                    <option value="">Selecciona un Deporte</option>
                    <?php
                    // Código PHP para cargar los deportes
                    $sql = "SELECT id_deporte, descripcion_deporte FROM deporte";
                    $result = $conexion->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_deporte"] . "'>" . $row["descripcion_deporte"] . "</option>";
                    }
                    ?>
                </select>

                <label for="formato">Formato de Deporte:</label>
                <select id="formato" name="formato">
                    <option value="">Selecciona un Formato</option>
                    <?php
                    // Código PHP para cargar todos los formatos inicialmente
                    $sql = "SELECT id_formato_deporte, descripcion_formato_deporte FROM formato_deporte";
                    $result = $conexion->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_formato_deporte"] . "'>" . $row["descripcion_formato_deporte"] . "</option>";
                    }
                    ?>
                </select>

                <label for="estadoReserva">estado reserva:</label>
                <select id="estadoReserva" name="estadoReserva">
                    <option value="">Selecciona un estado</option>
                    <?php
                    // Código PHP para cargar todos los formatos inicialmente
                    $sql = "SELECT id_estado_reserva, descripcion_estado_reserva FROM estado_reserva";
                    $result = $conexion->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_estado_reserva"] . "'>" . $row["descripcion_estado_reserva"] . "</option>";
                    }
                    ?>
                </select>

                <br>

                <!-- Campos para el rango de fechas con Flatpickr -->
                <label for="fechaRango">Rango de Fechas:</label>
                <input type="text" id="fechaRango" name="fechaRango">
            </form>
        </section>

        <button id="exportarpdf">Exportar a PDF</button>

        <section class="chart-container">
            <canvas id="reservasChart"></canvas>
        </section>

        <section class="reservas-details">
            <h2>Reservas Detalladas</h2>
            <table id="reservasTable">
                <thead>
                    <tr>
                        <th>Complejo</th>
                        <th>Sucursal</th>
                        <th>Deporte</th>
                        <th>Formato</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se cargarán dinámicamente aquí -->
                </tbody>
            </table>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Inicializar Flatpickr en el campo de rango de fechas
        flatpickr("#fechaRango", {
            mode: "range",
            dateFormat: "Y-m-d", // Formato de fecha compatible con SQL
            locale: "es", // Opcional: configuración de idioma español
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#complejo').change(function() {
                var complejoId = $(this).val(); // Obtiene el ID del complejo seleccionado

                $.ajax({
                    url: 'get_sucursales.php', // Archivo PHP que maneja la consulta de sucursales
                    type: 'POST',
                    data: {
                        id_complejo: complejoId
                    }, // Envía el ID del complejo
                    success: function(data) {
                        $('#sucursal').html(data); // Carga las sucursales en el select
                    }
                });
            });

            $('#deporte').change(function() {
                var deporteId = $(this).val(); // Obtiene el ID del deporte seleccionado

                $.ajax({
                    url: 'get_formatoDeporte.php', // Archivo PHP que maneja la consulta de formatos
                    type: 'POST',
                    data: {
                        id_deporte: deporteId
                    }, // Envía el ID del deporte
                    success: function(data) {
                        $('#formato').html(data); // Carga los formatos en el select de formato
                    }
                });
            });
        });
    </script>

    <script>
        async function fetchReservas() {
            const complejo = document.getElementById('complejo').value;
            const sucursal = document.getElementById('sucursal').value;
            const deporte = document.getElementById('deporte').value;
            const formato = document.getElementById('formato').value;
            const estadoReserva = document.getElementById('estadoReserva').value;

            const params = new URLSearchParams({
                complejo,
                sucursal,
                deporte,
                formato,
                estadoReserva
            });

            const response = await fetch(`api_reservas.php?${params}`);
            const reservas = await response.json();
            updateChart(reservas);
            updateTable(reservas);
        }

        function updateChart(reservas) {
            const sucursales = [...new Set(reservas.map(r => r.descripcion_sucursal))];
            const deportes = [...new Set(reservas.map(r => r.descripcion_deporte))];

            const data = deportes.map(deporte => {
                return sucursales.map(sucursal => {
                    return reservas.filter(r => r.descripcion_deporte === deporte && r.descripcion_sucursal === sucursal).length;
                });
            });

            // Verificar si reservasChart existe y es una instancia de Chart antes de destruirla
            if (window.reservasChart instanceof Chart) {
                window.reservasChart.destroy();
            }

            const ctx = document.getElementById('reservasChart').getContext('2d');
            window.reservasChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sucursales,
                    datasets: deportes.map((deporte, index) => ({
                        label: deporte,
                        data: data[index],
                        backgroundColor: `rgba(${index * 50 + 75}, ${index * 50 + 75}, 192, 0.6)`,
                        borderColor: `rgba(${index * 50 + 75}, ${index * 50 + 75}, 192, 1)`,
                        borderWidth: 1
                    }))
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function updateTable(reservas) {
            const tableBody = document.getElementById('reservasTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = '';

            reservas.forEach(reserva => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${reserva.descripcion_complejo}</td>
                <td>${reserva.descripcion_sucursal}</td>
                <td>${reserva.descripcion_deporte}</td>
                <td>${reserva.descripcion_formato_deporte}</td>
                <td>${reserva.fecha_reserva}</td>
                <td>${reserva.horario_inicio} - ${reserva.horario_fin}</td>
                <td>${reserva.descripcion_estado_reserva}</td>
            `;
                tableBody.appendChild(row);
            });
        }

        // Llamada inicial para cargar datos sin filtros
        fetchReservas();

        // Agregar evento de cambio a cada select para actualizar al cambiar el filtro
        document.querySelectorAll('#filterForm select').forEach(select => {
            select.addEventListener('change', fetchReservas);
        });

        // Llamada inicial para cargar datos sin filtros seleccionados
        fetchReservas();
    </script>
</body>

</html>