<?php
require_once("../../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");

if (isset($_GET['id_sucursal'])) {
    $sucursal_id = $_GET['id_sucursal'];
    $sql = "SELECT p.nombre, p.apellido, d.descripcion_documento, con.descripcion_contacto AS contacto, e.empleado_cargo FROM empleado e 
            JOIN persona p ON e.rela_persona = p.id_persona
            JOIN contacto con ON con.rela_persona = p.id_persona
            JOIN documento d ON d.rela_persona = p.id_persona
            JOIN sucursal s ON e.rela_sucursal = s.id_sucursal
            JOIN complejo c ON s.rela_complejo = c.id_complejo 
            WHERE id_sucursal = $sucursal_id";

    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>nombre</th><th>apellido</th><th>dni</th><th>contacto</th><th>cargo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['nombre']}</td><td>{$row['apellido']}</td><td>{$row['descripcion_documento']}</td><td>{$row['contacto']}</td><td>{$row['empleado_cargo']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay empleados en esta sucursal.";
    }
}
