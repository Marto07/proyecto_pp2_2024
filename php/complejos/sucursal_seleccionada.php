<?php 

if (isset($_GET['id_sucursal'])) {
	echo $_GET['id_sucursal'] . " EXITOSSS";
} else {
	echo "ha ocurrido un error :("; 
	die;
}

?>