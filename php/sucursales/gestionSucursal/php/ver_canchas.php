<?php
require_once("../../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

if (isset($_GET['sucursal_id'])) {
    $sucursal_id = $_GET['sucursal_id'];
    $sql = "SELECT * FROM zona 
            JOIN sucursal ON zona.rela_sucursal = sucursal.id_sucursal 
            JOIN formato_deporte ON zona.rela_formato_deporte = formato_deporte.id_formato_deporte 
            WHERE rela_sucursal = $sucursal_id";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Cancha</th><th>Direccion</th><th>Formato Deporte</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['descripcion_zona']}</td><td>{$row['direccion']}</td><td>{$row['descripcion_formato_deporte']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay canchas en esta sucursal.";
    }
}
