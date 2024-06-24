

<?php 

    require_once("../../config/database/conexion.php");
    require_once("../../config/database/db_functions.php");

    $id_perfil = 1;
    $perfiles = obtenerPerfiles();
    $modulos = obtenerModulos();
    $sql_permisos = "SELECT rela_modulo FROM asignacion_perfil_modulo WHERE rela_perfil = ?";
    $stmt_permisos = $conexion->prepare($sql_permisos);
    $stmt_permisos->bind_param("i", $id_perfil);
    $stmt_permisos->execute();
    $result_permisos = $stmt_permisos->get_result();
    $permisos = $result_permisos->fetch_all(MYSQLI_ASSOC);
    $modulos_permitidos = array_column($permisos, 'rela_modulo');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Permisos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Gestión de Permisos</h2>
    <form id="permisosForm">
        <label for="perfil">Seleccionar perfil:</label>
        <select id="perfil" name="perfil" onchange="cargarPermisos(this.value)">
            <?php while($perfil = $perfiles->fetch_assoc()): ?>
                <option value="<?php echo $perfil['id_perfil']; ?>" >
                    <?php echo $perfil['descripcion_perfil']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <div id="modulos">
            <?php while($modulo = $modulos->fetch_assoc()): ?>
                <div>
                    <input type="checkbox" name="modulos[]" value="<?php echo $modulo['id_modulo']; ?>">
                    <?php echo $modulo['descripcion_modulo']; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <button type="button" onclick="guardarPermisos()">Guardar</button>
    </form>

    <script>
        function cargarPermisos(idPerfil) {
            $.ajax({
                url: 'modulos_por_perfil.php',
                type: 'GET',
                data: { id_perfil: idPerfil },
                success: function(response) {
                    var permisos = JSON.parse(response);
                    $('input[type="checkbox"]').each(function() {
                        $(this).prop('checked', permisos.includes(parseInt($(this).val())));
                    });
                },
                error: function() {
                    alert('Hubo un error al cargar los permisos.');
                }
            });
        }

        function guardarPermisos() {
            var formData = $('#permisosForm').serialize();
            $.ajax({
                url: 'guardar_permisos.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Permisos guardados correctamente.');
                },
                error: function() {
                    alert('Hubo un error al guardar los permisos.');
                }
            });
        }

        // Cargar los permisos del primer perfil seleccionado al cargar la página
        $(document).ready(function() {
            var idPerfil = $('#perfil').val();
            if (idPerfil) {
                cargarPermisos(idPerfil);
            }
        });
    </script>
</body>
</html>
