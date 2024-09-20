<?php  
require_once("../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
require_once(RUTA. "php/functions/consulta_reutilizable_mysql.php");
require_once(RUTA. "config/database/db_functions.php");

$registrosSexo = obtenerSexos();
$registrosTipoDocumento = obtenerTipoDocumentos();
$registrosMembresia = obtenerMembresias(20,0);

if (isset($_GET['id'])) {
	$id_complejo = $_GET['id'];
} else {
	echo "ha ocurrido un error :(" . "<br>";
	echo "<a href='". BASE_URL . "index_tincho.php" ."'></a>";
}


$campos = ['id_complejo as id', 'descripcion_complejo'];
$tabla = 'complejo'; // La tabla principal

// Define el JOIN con la tabla ciudades
$join = '';

// Define la condición WHERE para buscar 
$condicion = "estado IN(1) AND id_complejo = {$id_complejo}";

// Obtén los registros de la base de datos con JOIN y WHERE
$registros = obtenerRegistros($tabla, $campos, $join, $condicion);
$reg = $registros->fetch_assoc();
//titulos y alta
$titulo_pagina = "Alta de Socio";
$modulo = "Alta de socio complejo {$reg['descripcion_complejo']}";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $titulo_pagina; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL. 'php/socio/css/agregar.css'; ?>">
</head>
<body>

	<h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px; color: white;"><?php echo $modulo; ?></h1>
    <form action="agregar_aplicar.php" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="">

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="">

        <label for="descripcion_documento">Documento:</label>
        <input type="text" id="descripcion_documento" name="descripcion_documento" value="">

        <label for="tipo_documento">Tipo de Documento:</label>
        <select name="tipo_documento" required>
        	<option value='' disabled selected>Seleccione un tipo de documento...</option>
        	<?php foreach ($registrosTipoDocumento as $reg) : ?>
        		<option value="<?php echo $reg['id_tipo_documento']; ?>"><?php echo $reg['descripcion_tipo_documento']; ?></option>
        	<?php endforeach; ?>
        </select>

        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="">

        <label for="descripcion_sexo">Sexo:</label>
        <select name ="descripcion_sexo" required>
        	<option value='' disabled selected>Seleccione un sexo...</option>
        	<?php foreach ($registrosSexo as $reg) : ?>
        		<option value="<?php echo $reg['id_sexo']; ?>"><?php echo $reg['descripcion_sexo']; ?></option>
        	<?php endforeach; ?>
        </select>

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" value="" placeholder="ej: 1239874321">

        <label for="rela_membresia">Membresia:</label>
        <select name="rela_membresia">
        	<option value='' disabled selected>Seleccione una membresia...</option>
        	<?php foreach ($registrosMembresia as $reg) : ?>
        		<option value="<?php echo $reg['id_membresia']; ?>"><?php echo $reg['descripcion_membresia']. ' - %'. $reg['beneficio_membresia']; ?></option>
        	<?php endforeach; ?>
        </select>

        <input type="hidden" name="id_complejo" value="<?php echo $id_complejo; ?>">

        <button type="submit">Enviar</button>
    </form>

    <script src="<?php echo BASE_URL. 'libs/sweetalert2.all.min.js' ?>"></script>
    <?php if(isset($_GET['persona_repetida'])) {?>
    	<script> swal.fire({icon: 'warning', text: 'Esta persona ya existe en la base de datos'})</script>
    <?php } ?>
</body>
</html>