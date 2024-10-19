<?php
session_start();
require_once('../../config/root_path.php');
$id_sucursal = isset($_GET['id_sucursal']) ? $_GET['id_sucursal'] : die("FALTA GET SUCURSAL");

require_once('../../config/database/db_functions.php');

$registros = obtenerZonasFutbol($id_sucursal);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TABLA ZONAS</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="css/tablaZonas.css">
	<link rel="stylesheet" href="<?php echo BASE_URL. "css/header.css"; ?>">
	<link rel="stylesheet" href="<?php echo BASE_URL. "css/aside.css"; ?>">
	<!-- <style>
		@import url(/../../../css/header.css);
		@import url(/../../../css/aside.css);

		body {
			background: #161616;
			font-family: Arial, Helvetica, sans-serif;
		}

		/* Formulario Empleado/////////////////////////////////////77 */
		/* Estilos generales para el contenedor del formulario */
		.containerEmpleado {
			margin: auto;
			margin-top: 10px;
			padding: 20px;
			background-color: #212121;
			border-radius: 8px;
			box-shadow: 0px 0px 10px rgb(128, 128, 128, 0.7);
		}

		.containerEmpleado h1 {
			color: #fff;
			text-align: center;
		}

		.containerEmpleado form {
			margin-top: 10px;
		}

		/* Estilos para las etiquetas de los campos */
		.containerEmpleado label {
			display: block;
			margin-bottom: 8px;
			font-weight: bold;
			color: #fff;
		}

		/* Estilos para los campos de entrada de texto */
		.containerEmpleado input[type="text"],
		.containerEmpleado input[type="date"],
		.containerEmpleado select {
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #2c2c2c;
			border-radius: 4px;
			font-size: 16px;
			box-sizing: border-box;
			transition: border-color 0.3s ease;
		}

		/* Estilos para cambiar el color del borde cuando el campo está enfocado */
		.containerEmpleado input[type="text"]:focus,
		.containerEmpleado input[type="date"]:focus,
		.containerEmpleado select:focus {
			border-color: grey;
			box-shadow: 1px 0px 3px grey;
			outline: none;
		}

		/* Estilos para el botón de enviar */
		.containerEmpleado button {
			width: 40%;
			padding: 12px;
			background-color: #2c2c2c;
			color: #fff;
			border: none;
			border-radius: 4px;
			font-size: 16px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		/* Cambio de color al pasar el cursor sobre el botón */
		.containerEmpleado button:hover {
			background-color: #0b0b0b;
			border: 1px solid grey;
			box-shadow: 1px 0px 3px gray;
		}

		/* Ajustes para pantallas pequeñas */
		@media (max-width: 480px) {
			.containerEmpleado {
				padding: 10px;
			}

			.containerEmpleado label {
				font-size: 14px;
			}

			.containerEmpleado input[type="text"],
			.containerEmpleado input[type="date"],
			.containerEmpleado select {
				font-size: 14px;
			}

			.containerEmpleado button {
				font-size: 14px;
				padding: 10px;
			}
		}

		/* Tabla Registro //////////////////////////////////////////7 */
		table {
			border-collapse: collapse;
			width: 100%;
			margin: auto;
			margin-top: 1%;
			color: rgba(0, 0, 0, 0.6);
			font-weight: bold;
			font-size: 16px;
			border: none;
		}

		th,
		td {
			text-align: center;
			padding: 10px;
			color: white;
		}

		/* ESTILOS ESPECIALES A LOS THEAD */

		body table thead tr {
			background-color: #161616;
			color: rgba(255, 255, 255, 0.9);
			text-align: center;
			padding: 8px;
		}

		/* RENGLONES DE COLORES DIFERENTES */
		table tbody tr:nth-child(odd) {
			background-color: #2c2c2c;
		}

		table tbody tr:nth-child(even) {
			background-color: #161616;
		}

		.alta {
			text-align: center;
			color: #161616;
		}

		table tbody img {
			height: 30px;
		}

		table tbody a:hover {
			cursor: pointer;
		}
	</style> -->
</head>

<body>

	<?php include(RUTA. "includes/header.php"); ?>

	<?php include(RUTA."includes/menu_aside.php") ?>

	<script src="js/jquery-3.7.1.min.js"></script>
	<div class="containerEmpleado">
		<h1>Modulo Zonas de Complejos Deportivos</h1>
		<div id="tabla-container"></div>
        <div id="paginacion-container"></div>
	</div>

	<script src="<?php echo BASE_URL . "libs/jquery-3.7.1.min.js"; ?>"></script>
	<script>
		$(document).on('click', '.eliminar', function() {
            let valor = $(this).attr('valor');
            let sucursal = $(this).attr('sucursal');
            // Mostrar SweetAlert con botones personalizados
            Swal.fire({
                title: '¿Seguro que desea eliminar este registro?',
                text: "No podrás deshacer esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Botón rojo
                cancelButtonColor: '#aaa', // Botón gris
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                // Si el usuario confirma
                if (result.isConfirmed) {
                    // Llamar a la función 'confirmarEliminacion' pasando el id
                    eliminar(valor, sucursal);
                }
            });

        }); // #ELIMINAR ON CLICK


        function eliminar(id, sucursal) {
            window.location.href = "eliminar.php?id=" + id + "&id_sucursal=" + sucursal;
        }
	</script>

	<script src="<?php echo BASE_URL . "js/header.js"; ?>"></script>
	<script src="<?php echo BASE_URL . "js/aside.js"; ?>"></script>
	<script>
		 $(document).ready(function() {
            let id_sucursal = <?php echo $id_sucursal; ?>;

            function cargarTabla(id_sucursal,filtro = '', pagina = 1) {
                $.ajax({
                    url: 'ajax/obtenerZonas.php',
                    type: 'GET',
                    data: { filtro: filtro, pagina: pagina , id_sucursal: id_sucursal},
                    dataType: 'json',
                    success: function(data) {
                        // Actualizar el contenedor de la tabla con el HTML generado
                        $('#tabla-container').html(data.tabla);
                        // Actualizar la paginación
                        actualizarPaginacion(data.total_pages, data.current_page);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX: ", status, error);
                    }
                });
            }

            // Función para actualizar los controles de paginación
            function actualizarPaginacion(total_pages, current_page) {
                var paginacionHTML = '';

                // Generar botones de paginación
                for (var i = 1; i <= total_pages; i++) {
                    if (i === current_page) {
                        paginacionHTML += '<span class="pagina-activa">' + i + '</span>';
                    } else {
                        paginacionHTML += '<button class="pagina-boton" data-page="' + i + '">' + i + '</button>';
                    }
                }

                $('#paginacion-container').html(paginacionHTML);
            }

            // Cargar la tabla inicialmente sin filtro
            cargarTabla(id_sucursal);

            // Evento de búsqueda
            $('#buscador').on('keyup', function() {
                var filtro = $(this).val();
                cargarTabla(id_sucursal ,filtro); //llamar a la funcion con el termino de busqueda
            });

            // Evento para cambiar de página
            $(document).on('click', '.pagina-boton', function() {
                var filtro = $('#buscador').val();
                var page = $(this).data('page');
                cargarTabla(id_sucursal,filtro, page);
            });

        }); // Cierre del DOCUMENT READY
	</script>

</body>

</html>