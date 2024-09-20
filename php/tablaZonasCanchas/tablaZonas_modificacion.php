<?php 
require_once('../../config/database/conexion.php');
$id = $_GET['id_zona'];
$id_sucursal = isset($_GET['id_sucursal']) ? $_GET['id_sucursal'] : die("no hay id de sucursal :(");;

$sqlEstado = "SELECT
					id_estado_zona,
					descripcion_estado_zona
				FROM
					estado_zona
				WHERE estado IN (1)";

$sqlTerreno = "SELECT id_tipo_terreno, descripcion_tipo_terreno
                FROM tipo_terreno WHERE estado IN(1)";

$sqlFutbol = "SELECT id_formato_deporte, descripcion_formato_deporte
                FROM formato_deporte WHERE estado IN(1)";

$sqlSucursal = "SELECT
                    id_sucursal,
                    descripcion_sucursal
                FROM
                    sucursal
                WHERE estado IN (1)";



$registrosEstado	= $conexion->query($sqlEstado); 
$registrosComplejo	= $conexion->query($sqlSucursal);
$registrosTerreno  = $conexion->query($sqlTerreno);
$registrosFutbol  = $conexion->query($sqlFutbol);

$sql = "SELECT 	
						id_zona,
						descripcion_zona,
						descripcion_tipo_terreno,
						descripcion_formato_deporte,
						descripcion_sucursal,
						rela_tipo_terreno,
						rela_formato_deporte,
						rela_estado_zona,
						rela_sucursal						
					FROM
						zona
					JOIN
						servicio
					ON
						zona.rela_servicio = servicio.id_servicio
                    JOIN 
                    	sucursal
					ON 
						zona.rela_sucursal = sucursal.id_sucursal
					JOIN 
						formato_deporte
					ON 
						zona.rela_formato_deporte = formato_deporte.id_formato_deporte
					JOIN
						tipo_terreno
					ON
						zona.rela_tipo_terreno = tipo_terreno.id_tipo_terreno
					WHERE
						descripcion_servicio LIKE 'cancha'
					AND
						id_zona = $id
					AND
						zona.estado IN(1)";

$registros = $conexion->query($sql);

foreach($registros as $reg) {

	$id 		= $reg['id_zona'];
	$zona 		= $reg['descripcion_zona'];
	$terreno 	= $reg['rela_tipo_terreno'];
	$tipoFutbol = $reg['rela_formato_deporte'];
	$estado 	= $reg['rela_estado_zona'];
	$sucursal	= $reg['rela_sucursal'];

}

if (isset($_POST['modificacion'])) {
				$zona = $_POST['descripcion'];
				$terreno = $_POST['terreno'];
				$tipoFutbol = $_POST['tipo_futbol'];
				$estado = $_POST['estado'];
				$sucursal = $id_sucursal;
	$sql = "UPDATE
				zona
			SET 
				descripcion_zona = '$zona',
				rela_tipo_terreno = '$terreno',
				rela_formato_deporte = '$tipoFutbol',
				rela_estado_zona = $estado,
				rela_sucursal = $sucursal,
				rela_servicio = 1
			WHERE
				id_zona = $id";
	if ($conexion->query($sql)) {
		header("Location: tablaZonas.php?id_sucursal=$id_sucursal");
	}




}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODIFICACION ZONA</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F0F4F8;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            margin: 0 auto;
            font-size: 16px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 8px rgba(74, 144, 226, 0.2);
            outline: none;
        }

        button {
            background-color: #4A90E2;
            color: #FFFFFF;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #357ABD;
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
	<h1 style="text-align: center; margin-top: 25px; margin-bottom: 20px; color: white;">Modulo de Modificacion de Zona</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']. '?id_zona='. $id . '&id_sucursal='. $id_sucursal;?>" method="post" onsubmit="return confirmModification();">
        <label for="descripcion">C&oacute;digo:</label>
        <input type="text" id="descripcion" name="descripcion" value="<?php echo $zona; ?>" required>

        <label for="terreno">Terreno:</label>
        <select id="terreno" name="terreno" required>
            <option value="" disabled selected>Seleccione un Terreno...</option>
            <?php foreach ($registrosTerreno as $reg) : ?>
                <option value="<?= $reg['id_tipo_terreno'];?>"     
                	<?php if($terreno == $reg['id_tipo_terreno']) {echo 'selected';} ?>
                >
                	<?= $reg['descripcion_tipo_terreno'] ?></option>
            <?php endforeach; ?>
            
        </select>

        <label for="tipo_futbol">Tipo de Fútbol:</label>
        <select id="tipo_futbol" name="tipo_futbol" required>
            <option value="" disabled selected>Seleccione una categoria...</option>
            <?php foreach ($registrosFutbol as $reg) : ?>
                <option value="<?= $reg['id_formato_deporte'];  ?>"
                	<?php if ($reg['id_formato_deporte'] == $tipoFutbol) {echo 'selected';} ?>
                >
                	<?= $reg['descripcion_formato_deporte'] ?>
                	
                </option>
            <?php endforeach; ?>
        </select>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
        	<option value="" disabled selected>Seleccione un estado...</option>
        	<?php foreach ($registrosEstado as $reg) : ?>
        		<option value="<?php echo $reg['id_estado_zona']; ?>" <?php if ($estado == $reg['id_estado_zona']) {echo 'selected';} ?>>
        			<?php echo $reg['descripcion_estado_zona'];?>
        		</option>
        	<?php endforeach; ?>
        </select>


        <!-- VEREMOS ESTO SE TENDRIA QUE RECIBIR POR GET -->
        <!-- <label for="complejo">Sucursal:</label>
        <select id="complejo" name="complejo" required>
            <option value="" disabled selected>Seleccione un complejo...</option>
            <?php// foreach ($registrosComplejo as $reg) : ?>
                <option value="<?php// echo $reg['id_sucursal']; ?>">
                    <?php// echo $reg['descripcion_sucursal'];?>
                </option>
            <?php// endforeach; ?>
        </select> -->

        <button type="submit" name="modificacion">Enviar</button>
    </form>

    <script>
        function confirmModification() {
            var respuesta = confirm("¿Estás seguro de que deseas aplicar las modificaciones?");
            return respuesta;
        }
    </script>
</body>
</html>
