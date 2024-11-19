<?php
// Conexión a la base de datos
include 'conexion.php';

// Consulta de complejos
$queryComplejos = "SELECT id_complejo, nombre_complejo FROM complejos";
$resultComplejos = $conn->query($queryComplejos);

// Consulta de deportes
$queryDeportes = "SELECT id_deporte, nombre_deporte FROM deportes";
$resultDeportes = $conn->query($queryDeportes);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Reservas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .chart-container {
            width: 80%;
            max-width: 800px;
            margin: 20px 0;
        }

        .reservas-details {
            width: 80%;
            max-width: 800px;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .reservas-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .reservas-details th,
        .reservas-details td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .reservas-details th {
            background-color: #4CAF50;
            color: white;
        }

        .reservas-details tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <header>
        <h1>Dashboard de Reservas por Sucursal</h1>
    </header>

    <main>
        <section class="filter-container">
            <form id="filterForm">
                <label for="complejo">Complejo:</label>
                <select id="complejo" name="complejo" onchange="fetchSucursales()">
                    <option value="">Selecciona un Complejo</option>
                    <!-- Opciones de Complejos se cargarán desde la base de datos con PHP -->
                </select>

                <label for="sucursal">Sucursal:</label>
                <select id="sucursal" name="sucursal">
                    <option value="">Selecciona una Sucursal</option>
                    <!-- Opciones dinámicas de sucursales -->
                </select>

                <label for="deporte">Deporte:</label>
                <select id="deporte" name="deporte" onchange="fetchFormatos()">
                    <option value="">Selecciona un Deporte</option>
                    <!-- Opciones de Deportes se cargarán desde la base de datos con PHP -->
                </select>

                <label for="formato">Formato de Deporte:</label>
                <select id="formato" name="formato">
                    <option value="">Selecciona un Formato</option>
                    <!-- Opciones dinámicas de formato de deporte -->
                </select>
            </form>

        </section>

        <section class="chart-container">
            <canvas id="reservasChart"></canvas>
        </section>

        <section class="reservas-details">
            <h2>Reservas Detalladas</h2>
            <table id="reservasTable">
                <thead>
                    <tr>
                        <th>Sucursal</th>
                        <th>Cancha</th>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const complejoSelect = document.getElementById('complejo');
            const deporteSelect = document.getElementById('deporte');

            <?php while ($row = $resultComplejos->fetch_assoc()): ?>
                complejoSelect.innerHTML += `<option value="<?= $row['id_complejo'] ?>"><?= $row['descripcion_complejo'] ?></option>`;
            <?php endwhile; ?>

            <?php while ($row = $resultDeportes->fetch_assoc()): ?>
                deporteSelect.innerHTML += `<option value="<?= $row['id_deporte'] ?>"><?= $row['descripcion_deporte'] ?></option>`;
            <?php endwhile; ?>
        });
    </script>

    <script>
        function fetchSucursales() {
            const complejoId = document.getElementById('complejo').value;

            if (!complejoId) return;

            fetch(`../dashboardPropietario/get_sucursales.php?complejo=${complejoId}`)
                .then(response => response.json())
                .then(data => {
                    const sucursalSelect = document.getElementById('sucursal');
                    sucursalSelect.innerHTML = '<option value="">Selecciona una Sucursal</option>';
                    data.forEach(sucursal => {
                        sucursalSelect.innerHTML += `<option value="${sucursal.id_sucursal}">${sucursal.descripcion_sucursal}</option>`;
                    });
                })
                .catch(error => console.error('Error al cargar las sucursales:', error));
        }

        function fetchFormatos() {
            const deporteId = document.getElementById('deporte').value;

            if (!deporteId) return;

            fetch(`../dashboardPropietario/get_formatoDeporte.php?deporte=${deporteId}`)
                .then(response => response.json())
                .then(data => {
                    const formatoSelect = document.getElementById('formato');
                    formatoSelect.innerHTML = '<option value="">Selecciona un Formato</option>';
                    data.forEach(formato => {
                        formatoSelect.innerHTML += `<option value="${formato.id_formato_deporte}">${formato.descripcion_formato_deporte}</option>`;
                    });
                })
                .catch(error => console.error('Error al cargar los formatos:', error));
        }
    </script>

    <script>
        async function fetchReservas() {
            const sucursal = document.getElementById('sucursal').value;
            const cancha = document.getElementById('cancha').value;
            const fecha_desde = document.getElementById('fecha_desde').value;
            const fecha_hasta = document.getElementById('fecha_hasta').value;
            const estado = document.getElementById('estado').value;

            const params = new URLSearchParams({
                sucursal,
                cancha,
                fecha_desde,
                fecha_hasta,
                estado
            });

            const response = await fetch(`api_reservas.php?${params}`);
            const reservas = await response.json();
            updateChart(reservas);
            updateTable(reservas);
        }

        function updateChart(reservas) {
            const sucursales = [...new Set(reservas.map(r => r.sucursal))];
            const deportes = [...new Set(reservas.map(r => r.cancha))];

            const data = deportes.map(deporte => {
                return sucursales.map(sucursal => {
                    return reservas.filter(r => r.cancha === deporte && r.sucursal === sucursal).length;
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
            <td>${reserva.sucursal}</td>
            <td>${reserva.cancha}</td>
            <td>${reserva.fecha}</td>
            <td>${reserva.hora}</td>
            <td>${reserva.estado}</td>
        `;
                tableBody.appendChild(row);
            });
        }
        // Llamada inicial para cargar datos sin filtros
        fetchReservas();
    </script>
</body>

</html>