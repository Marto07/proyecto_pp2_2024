<?php  

require_once("../../../config/root_path.php");

?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/alta_complejo.css">
</head>
<body>
	<div class="formulario-wizard">
		
		<form action="alta_complejo.php" method="POST" id="formulario">
			
			<div class="paso" id="paso1">
				<h3>Datos del Complejo</h3>

				<label for="descripcion_complejo">Nombre del complejo:</label>
				<input type="text" name="descripcion_complejo" id="descripcion_complejo">
				<span id="error_descripcion_complejo"></span>

				<label for="fecha_fundacion_complejo">Fecha de Fundaci&oacute;n</label>
				<input type="date" name="fecha_fundacion_complejo" id="fecha_fundacion_complejo">
				<span id="error_fecha_fundacion_complejo"></span>

				<label for="logo">Logo:</label>
				<input type="file" name="logo">
				<span id="error_logo"></span>

				<div class="botones">
					<button type="button" class="siguiente" paso="1">Siguiente</button>
				</div>

			</div>

			<div class="paso" id="paso2">
				<h3>Datos de la Sucursal</h3>

				<label for="descripcion_sucursal">Nombre de la sucursal:</label>
				<input type="text" name="descripcion_sucursal" id="descripcion_sucursal">
				<span id="error_descripcion_sucursal"></span>

				<label for="provincia">Provincia</label>
				<select name="provincia" id="provincia" class="domicilio">
					<option value="" disabled selected>Seleccione una Provincia...</option>
					<!-- esto con php -->
				</select>

				<label for="localidad">Localidad</label>
				<select name="localidad" id="localidad" class="domicilio">
					<option value="" disabled selected>Seleccione una localidad...</option>
					<!-- esto con ajax -->
				</select>

				<label for="barrio">Barrio</label>
				<select name="barrio" 	 id="barrio" class="domicilio">
					<option value="" disabled selected>Seleccione un barrio...</option>
					<!-- esto con ajax -->
				</select>

				<label for="direccion">Direccion:</label>
				<input type="text" name="direccion" id="direccion">
				<span id="direccion_error"></span>

				<label for="Imagenes_sucursal">Imagenes de la sucursal:</label>
				<input type="file" name="Imagenes_sucursal">

				<label for="fecha_fundacion_sucursal">Fecha de Fundaci&oacute;n</label>
				<input type="date" name="fecha_fundacion_sucursal" id="fecha_fundacion_sucursal">
				<span id="error_fecha_fundacion_sucursal"></span>
				<div class="botones">
					<button type="button" class="anterior" paso="2">Anterior</button>
					<button type="button" class="siguiente" paso="2">Siguiente</button>
				</div>


			</div>

			<div class="paso" id="paso3">

				<label for="descripcion_zona">Descripcion:</label>
				<input type="text" name="descripcion_zona" placeholder="ejemplo: cancha 1...">
				<span id="error_descripcion_zona"></span>
				
				<label for="imagenes_zona">Imagenes de la cancha:</label>
				<input type="file" name="imagenes_zona" id="">

				<label for="">Superficie:</label>
				<select name="tipo_terreno" id="tipo_terreno" class="domicilio">
					<option value="" disabled selected>seleccione una superficie...</option>
				</select>
				
				<label for="">Deporte:</label>
				<select name="deporte" class="domicilio" id="deporte">
					<option value="" disabled selected>seleccione un deporte...</option>
				</select>

				<label for="">Tipo de deporte:</label>
				<select name="formato_deporte" class="domicilio" id="formato_deporte">
					<option value="" disabled selected>seleccione un tipo de deporte...</option>
				</select>

				<label for="">Estado de la cancha:</label>
				<select name="estado" class="domicilio" id="estado_zona">
					<option value="" disabled selected>seleccione un estado...</option>
				</select>

				<div class="botones">
					<button type="button" class="anterior" paso="3">Anterior</button>
					<button type="button" id="btn-finalizar">Finalizar</button>
				</div>

			</div>

		</form>
	</div>
	<!-- <script>alert("falta los divs de los inputs (no los pongo porque rompe el css)");</script> -->
	<script src="../../../libs/jquery-3.7.1.min.js"></script>
	<script src="js/pasos_y_obtener_domicilios.js"></script>
	<script src="js/validaciones_de_formulario.js"></script>
</body>
</html>