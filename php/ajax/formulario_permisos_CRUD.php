<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Permisos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Gestión de Permisos</h2>
    <form id="permisosForm">
        <label for="rol">Seleccionar Rol:</label>
        <select id="rol" name="rol" onchange="cargarPermisos(this.value)">
            <?php while($rol = $result_roles->fetch_assoc()): ?>
                <option value="<?php echo $rol['id']; ?>" <?php if($rol['id'] == $rol_id) echo 'selected'; ?>>
                    <?php echo $rol['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <div id="modulos">
            <?php while($modulo = $result_modulos->fetch_assoc()): ?>
                <div>
                    <input type="checkbox" name="modulos[]" value="<?php echo $modulo['id']; ?>">
                    <?php echo $modulo['nombre']; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <button type="button" onclick="guardarPermisos()">Guardar</button>
    </form>

    <script>
        // Incluir aquí el script jQuery
        function cargarPermisos(rolId) {
            $.ajax({
                url: 'obtener_permisos.php',
                type: 'GET',
                data: { rol: rolId },
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

        // Cargar los permisos al cargar la página
        $(document).ready(function() {
            var rolId = $('#rol').val();
            cargarPermisos(rolId);
        });
    </script>
</body>
</html>
