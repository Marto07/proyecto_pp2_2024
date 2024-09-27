<?php
session_start();
require_once("../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA . "php/functions/consulta_reutilizable_mysql.php");

if (isset($_GET['id_complejo'])) {
    $id_complejo = $_GET['id_complejo'];
} else {
    echo "ha ocurrido un error :(" . "<br>";
    echo "<a href='" . BASE_URL . "index_tincho.php" . "'>Volver</a>";
    die;
}


// Incluye la función de obtener registros

// Define las variables reutilizables
$titulo_pagina = "Socios";
$modulo = "Lista de socios de un complejo";

// definimos los campos del encabezado
$thead = ['ID', 'Nombre', 'Apellido', 'Documento', 'Membresia'];

// Define los campos a seleccionar
$campos = ['id_socio as id', 'id_persona', 'nombre', 'apellido', 'descripcion_documento', 'descripcion_membresia'];
$tabla = 'socio'; // La tabla principal

// Define el JOIN con la tabla ciudades
$join = 'JOIN persona
            ON socio.rela_persona = persona.id_persona
            JOIN documento
            ON persona.rela_documento = documento.id_documento
            JOIN membresia
            ON socio.rela_membresia = membresia.id_membresia
';

// Define la condición WHERE para buscar 
$condicion = "rela_complejo = $id_complejo AND socio.estado IN(1)";

//orden de la consulta
$orden = '';

// Obtén los registros de la base de datos con JOIN y WHERE
$registros = obtenerRegistros($tabla, $campos, $join, $condicion);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/aside/menu_aside_beterette.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/header.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
        table td {
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
    </style>

</head>

<body>
    <?php include(RUTA . 'includes/header_tincho.php'); ?>
    <?php include(RUTA . 'includes/menu_aside_beterette.php'); ?>
    <div class="containerEmpleado">
        <h1>Socios</h1>
        <table>
            <thead>
                <tr>

                    <?php foreach ($thead as $th) : ?>
                        <th><?php echo $th; ?></th>
                    <?php endforeach; ?>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($registros as $registro) {
                    $modificar = "<a href='modificar.php?id={$registro['id']}&id_complejo=$id_complejo'>
                                <img src='" . BASE_URL . "/assets/icons/editar_azul.png'>
                            </a>";

                    $eliminar = "<a valor='{$registro['id']}' complejo='{$id_complejo}' class='eliminar'>
                                            <img src='" . BASE_URL . "/assets/icons/eliminar.png'>
                                        </a>";
                ?>

                    <tr>
                        <td><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['nombre']; ?></td>
                        <td><?php echo $registro['apellido']; ?></td>
                        <td><?php echo $registro['descripcion_documento']; ?></td>
                        <td><?php echo $registro['descripcion_membresia']; ?></td>
                        <td class="actions"><?php echo $modificar; ?></td>
                        <td class="actions"><?php echo $eliminar; ?></td>
                    </tr>

                <?php } ?>

                <tr>
                    <td colspan="7" class="alta">
                        <a href="agregar.php?id=<?php echo $id_complejo; ?>">
                            <img src="<?php echo BASE_URL . '/assets/icons/agregar.png'; ?>">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="../../libs/jquery-3.7.1.min.js"></script>
    <script src="../../libs/sweetalert2.all.min.js"></script>
    <script>
        $('.eliminar').on('click', function() {

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
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                // Si el usuario confirma
                if (result.isConfirmed) {
                    // Llamar a la función 'confirmarEliminacion' pasando el id
                    eliminar(valor, complejo);
                }
            });

        }); // #ELIMINAR ON CLICK

        <?php if (isset($_GET['persona_repetida'])) : ?>  
            Swal.fire({
                title: '¿Seguro que desea eliminar este registro?',
                text: "No podrás deshacer esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Botón rojo
                cancelButtonColor: '#aaa', // Botón gris
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            })
        <?php endif; ?>

        function eliminar(id, complejo) {
            window.location.href = "eliminar.php?id=" + id + "&id_complejo=" + complejo;
        }
    </script>
</body>

</html>