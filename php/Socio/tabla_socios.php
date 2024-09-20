<?php
require_once("../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA. "php/functions/consulta_reutilizable_mysql.php");

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
$campos = ['id_socio as id','id_persona', 'nombre', 'apellido', 'descripcion_documento', 'descripcion_membresia'];
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
    <link rel="stylesheet" href="<?php echo BASE_URL. "php/socio/css/tabla_reutilizable.css" ?>">
</head>
<body>

    <div class="table-container">
        <h2><?php echo $modulo; ?></h2>
        <table>
            <thead>
                <tr>

                    <?php foreach ($thead as $th) : ?>
                        <th><?php echo $th;?></th>
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

        $('.eliminar').on('click', function () {

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

        function eliminar(id, complejo) {
            window.location.href = "eliminar.php?id=" + id + "&id_complejo=" + complejo;
        }
        
    </script>
</body>
</html>
