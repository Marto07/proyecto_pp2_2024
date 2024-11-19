<?php
// Conexión a la base de datos
require_once("../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
session_start();

// Consultar notificaciones con el tipo de notificación
$sql = "SELECT id_notificacion, titulo, mensaje, n.estado AS leido, n.rela_sucursal, rela_usuario, fecha_creacion, 
            TIMESTAMPDIFF(DAY, fecha_creacion, NOW()) AS dias, 
            TIMESTAMPDIFF(HOUR, fecha_creacion, NOW()) % 24 AS horas, r.*, p.*, h.*, d.*, z.*
            FROM notificacion n 
            JOIN reserva r ON n.rela_reserva = r.id_reserva
            JOIN horario h ON r.rela_horario = h.id_horario
            JOIN persona p ON r.rela_persona = p.id_persona
            JOIN documento d ON p.id_persona = d.rela_persona
            JOIN zona z ON r.rela_zona = z.id_zona
            ORDER BY fecha_creacion DESC";

$Notificaciones = $conexion->query($sql);

// Contador de notificaciones no leídas
$sql_unread_count = "SELECT COUNT(*) AS unread_count FROM notificacion WHERE estado = 'no leido'";
$unread_result = $conexion->query($sql_unread_count);
$unread_count = ($unread_result->num_rows > 0) ? $unread_result->fetch_assoc()['unread_count'] : 0;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/aside.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
        }

        .containerNotificacion {
            padding: 10px;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 30%;
            border-right: 1px solid #ddd;
            padding: 10px;
            overflow: auto;
        }

        .details {
            flex-grow: 1;
            padding: 20px;
            border-left: 1px solid #ddd;
        }

        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .notification-item:hover {
            background-color: #f0f0f0;
        }

        .notification-title {
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .icon {
            margin-right: 10px;
        }

        .time-ago {
            font-size: 0.9em;
            color: gray;
        }

        .unread {
            background-color: #e0f7fa;
        }

        .unread .notification-title {
            color: #00796b;
        }

        .action-buttons {
            margin-top: 20px;
        }

        .action-buttons button {
            margin-right: 10px;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .accept-btn {
            background-color: #4caf50;
            color: #fff;
        }

        .verDetalle {
            background-color: blue;
            color: #fff;
        }

        .reject-btn {
            background-color: #f44336;
            color: #fff;
        }

        .view-btn {
            background-color: #2196f3;
            color: #fff;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .modal-header {
            font-weight: bold;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }

        .modal-footer button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-btn {
            background-color: #f44336;
            color: #fff;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .detalleModal {
            text-align: left;
            margin-left: 15%;
        }

        .datos {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .datos p {
            flex-grow: 1;
        }

        img {
            height: 20px;
            width: 20px;
        }
    </style>
</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/menu_aside.php'; ?>

    <div class="containerNotificacion">
        <h1 style="text-align: center;">Notificaciones</h1>
        <p>Notificaciones no leídas: <?php echo $unread_count; ?></p>
        <div class="container">
            <div class="sidebar">
                <?php if ($Notificaciones->num_rows > 0): ?>
                    <?php while ($row = $Notificaciones->fetch_assoc()): ?>
                        <div class="notification-item <?php echo $row['leido'] == 'no leido' ? 'unread' : ''; ?>" row="<?php echo htmlspecialchars(json_encode($row)); ?>"
                            onclick=" showDetails('<?php echo htmlspecialchars($row['mensaje']); ?>', '<?php echo $row['titulo']; ?>' , <?php echo $row['id_notificacion']; ?>)">
                            <div class="notification-title">
                                <div class="imgNotificacion">
                                    <?php if ($row['leido'] == 'no leido') { ?>
                                        <img src="../../assets/icons/CiNotification.svg">
                                    <?php } ?>
                                </div>
                                <?php echo htmlspecialchars($row['titulo']); ?>
                            </div>
                            <div class="time-ago">
                                hace <?php echo $row['dias']; ?> días <?php echo $row['horas']; ?> horas
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay notificaciones.</p>
                <?php endif; ?>
            </div>
            <div class="details" id="details">
                Seleccione desde la lista lateral de notificaciones para ver más detalles
            </div>
        </div>
    </div>

    <!-- Modal overlay -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal()"></div>

    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-header" id="modalHeader">Detalle de la notificación</div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-footer">
            <button class="accept-btn" id="aceptar">Aceptar</button>
            <button class="close-btn" onclick="closeModal()">Cerrar</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="<?php echo BASE_URL . 'libs/sweetalert2.all.min.js' ?>"></script>

    <script>
        // Manejo de clic en elementos de notificación
        let row = '';
        let reserva = '';

        $(document).on('click', '.notification-item', function() {
            reserva = $(this).attr('row');
            reserva = JSON.parse(reserva);
            predefinedMessage = ``;
            showDetails(predefinedMessage, reserva.titulo, reserva.id_notificacion, reserva);
        });

        $(document).on('click', '#rechazar', function() {
            let idReserva = reserva.id_reserva;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Seguro que quieres rechazar la petición de reserva?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, Rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, hacer un AJAX con el id_reserva
                    $.ajax({
                        url: 'rechazarReserva.php', // Cambia esto por el archivo que recibirá el id_reserva
                        method: 'POST',
                        data: {
                            id_reserva: idReserva
                        },
                        success: function(response) {
                            // Aquí puedes hacer algo con la respuesta
                            if (
                                response == 'todo correcto'
                            ) {
                                Swal.fire(
                                    '¡Reserva a sido Rechazada!',
                                    'La reserva ha sido Rechazada se le notificara al usuario.',
                                    'success'
                                );
                            }

                        },
                        error: function(xhr, status, error) {
                            // Manejo de error
                            console.log('Error en el Ajax');
                        }
                    });
                }
            });
        });

        $(document).on('click', '#aceptar', function() {
            let idReserva = reserva.id_reserva;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Seguro que quieres aceptar la petición de reserva?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, hacer un AJAX con el id_reserva
                    $.ajax({
                        url: 'aceptarReserva.php', // Cambia esto por el archivo que recibirá el id_reserva
                        method: 'POST',
                        data: {
                            id_reserva: idReserva
                        },
                        success: function(response) {
                            // Aquí puedes hacer algo con la respuesta
                            if (
                                response == 'todo correcto'
                            ) {
                                Swal.fire(
                                    '¡Reserva a sido Aceptada!',
                                    'La reserva ha sido Aceptada se le notificara al usuario.',
                                    'success'
                                );
                            }

                        },
                        error: function(xhr, status, error) {
                            // Manejo de error
                            console.log('Error en el Ajax');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.ver_detalle', function() {
            let idReserva = reserva.id_reserva;
            let detalle = `<div class="detalleModal">
                <div class="datos"><strong>Nombre:</strong> <p>${reserva.nombre}</p></div>
                <div class="datos"><strong>Apellido:</strong> <p>${reserva.apellido}</p></div>
                <div class="datos"><strong>Horario:</strong> <p>${reserva.horario_inicio} - ${reserva.horario_fin}</p></div>
                <div class="datos"><strong>Fecha de Reserva:</strong> <p>${reserva.fecha_reserva}</p></div>
                <div class="datos"><strong>Fecha de Alta:</strong> <p>${reserva.fecha_alta}</p></div>  
            </div>`;

            Swal.fire({
                title: 'Detalle Reserva',
                html: detalle,
                imageUrl: '../../assets/icons/CarbonReport.svg', // URL del icono
                imageWidth: 100, // Ancho del icono
                imageHeight: 100, // Alto del icono
            });
        });

        function showDetails(message, title, idNotificacion, reserva) {
            const detailsContainer = document.getElementById('details');
            let buttonsHTML = '';
            let predefinedMessage = '';

            switch (title) {
                case 'Reserva':
                    predefinedMessage = `La persona Nombre: ${reserva.nombre} Apellido: ${reserva.apellido} DNI: ${reserva.descripcion_documento} desea reservar la cancha ${reserva.id_zona} de ${reserva.horario_inicio} - ${reserva.horario_fin}`;
                    buttonsHTML = `
                <div class="action-buttons">
                    <button class="accept-btn" id="aceptar">Aceptar</button>
                    <button class="reject-btn" id="rechazar">Rechazar</button>
                    <button class="view-btn ver_detalle" id="ver_detalle">Ver Detalle</button>
                </div>`;
                    break;
                case 'Cancelacion':
                    predefinedMessage = 'La reserva no fue concretada por motivos de mantenimiento.';
                    break;
                case 'Confirmacion':
                    predefinedMessage = 'La reserva fue Aceptada, lo podra ver detalladamente en Mis Reservas.';
                    buttonsHTML = `
                <div class="action-buttons">
                    <button class="accept-btn ver_detalle">Ver Detalle</button>
                </div>`;
                    break;
                default:
                    predefinedMessage = message;
                    break;
            }

            detailsContainer.innerHTML = `<p>${predefinedMessage}</p>${buttonsHTML}`;

            // Marcar la notificación como "leída" mediante AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'marcar_leido.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + idNotificacion);
        }

        // function openModal(content) {
        //     document.getElementById('modalBody').innerText = content;
        //     document.getElementById('modal').style.display = 'block';
        //     document.getElementById('modalOverlay').style.display = 'block';
        // }

        // function closeModal() {
        //     document.getElementById('modal').style.display = 'none';
        //     document.getElementById('modalOverlay').style.display = 'none';
        // }
    </script>

</body>

</html>

<?php
$conexion->close();
?>