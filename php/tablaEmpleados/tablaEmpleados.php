<?php
session_start();
require_once("../../config/root_path.php");
require_once('../../config/database/db_functions.php');
if (isset($_GET['id_sucursal'])) {
	$id_sucursal = $_GET['id_sucursal'];
} else {
	echo "ha ocurrido un error :( falta get de sucursal" . "<br>";
	echo "<a href='" . BASE_URL . "index2.php" . "'>Volver</a>";
	die;
}

$registros = obtenerEmpleados($id_sucursal);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TABLA EMPLEADOS</title>
	<link rel="stylesheet" href="<?php echo BASE_URL . 'css/aside.css'; ?>">
	<link rel="stylesheet" href="<?php echo BASE_URL . 'css/header.css' ?>">
	<link rel="stylesheet" href="css/tabla_empleados.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
	<?php include(RUTA. "includes/header.php"); ?>

	<?php include(RUTA."includes/menu_aside.php") ?>

	<div class="containerEmpleado">
		<h1>Modulo de Empleados de Complejos Deportivos</h1>
		<input type="text" id="buscador" placeholder="Buscar...">
	    <div id="tabla-container"></div>
	    <div id="paginacion-container"></div>
	</div>

	<script src="<?php echo BASE_URL . "libs/jquery-3.7.1.min.js"; ?>"></script>
    <script src="<?php echo BASE_URL . "libs/sweetalert2.all.min.js"; ?>"></script>

	<script>
		
        $(document).on('click', '.eliminar', function() {
            let valor = $(this).attr('valor');
            let complejo = $(this).attr('complejo');
            // Mostrar SweetAlert con botones personalizados
            Swal.fire({
                title: '¿Seguro que desea eliminar este registro?',
                text: "No podrás deshacer esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Botón rojo
                cancelButtonColor: '#aaa', // Botón gris
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'custom-swal-popup' // Añadir una clase personalizada al modal
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminar(valor, complejo);
                }
            });

        }); // #ELIMINAR ON CLICK

        function eliminar(id_empleado, id_sucursal) {
            window.location.href = "tablaEmpleados_baja.php?id_empleado=" + id_empleado + "&id_sucursal=" + id_sucursal;
        }
	</script>
	<script src="<?php echo BASE_URL . "js/header.js"; ?>"></script>
	<script src="<?php echo BASE_URL . "js/aside.js"; ?>"></script>
	<script>
        $(document).ready(function() {
        	let id_sucursal = <?php echo json_encode($id_sucursal); ?>;

            function cargarTabla(id_sucursal,filtro = '', pagina = 1) {
                $.ajax({
                    url: 'ajax/obtenerEmpleados.php',
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