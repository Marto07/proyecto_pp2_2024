<?php 
$conexion = new mysqli("localhost","root","","proyecto_pp2");


// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPerfil = $_POST['perfil'];
    $modulosSeleccionados = isset($_POST['modulos']) ? $_POST['modulos'] : [];

    // Borrar las profesiones anteriores de la persona seleccionada
    $sqlDelete = "DELETE FROM asignacion_perfil_modulo WHERE rela_perfil = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $idPerfil);
    $stmtDelete->execute();

    // Insertar las nuevas profesiones seleccionadas
    $sqlInsert = "INSERT INTO asignacion_perfil_modulo (rela_perfil, rela_modulo) VALUES (?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param("ii", $idPerfil, $idModulo);

    foreach ($modulosSeleccionados as $idModulo) {
        $stmtInsert->execute();
    }

}



$sql = "SELECT id_modulo,descripcion_modulo FROM modulo";
$resultado = $conexion->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHECKBOX</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <h2>Formulario de Inserci&oacute;n</h2>
        <!-- Otros campos del formulario -->

        <label for="perfil">perfil:</label>
        <div class="perfilXerror">
            <select name="perfil" id="perfil" class="inputs">
            </select>
            <span><?php echo 'Mensaje de error'; ?></span>
        </div>

        <label for="modulos">modulos:</label>
        <div id="modulos">
            <!-- Aquí se agregarán los checkboxes de modulos -->
            <?php foreach ($resultado as $reg) :?>
                <div>
                    <input type="checkbox" name="modulos[]" value="<?php echo $reg['id_modulo']; ?>">
                    <?php echo $reg['descripcion_modulo'];?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="boton-submit">
            <button type="submit" id="botonSubmit" name="boton-submit">Submit</button>
        </div>
    </form>

    <div id="resultado-ajax"></div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="validaciones.js"></script>
</body>
</html>
<?php $conexion->close(); ?>
