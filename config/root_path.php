<?php 

	#URL BASE PARA CSS
	$nombreProyecto = "PROYECTO_PP1_2023";
	define('BASE_URL', 'http://'. $_SERVER['HTTP_HOST']. '/'. $nombreProyecto. '/');

	#RUTA RAIZ PARA INCLUDES Y TODA ESA MADRE
	$rutaActual = __DIR__;
	define('RAIZ', realpath($rutaActual . '/..' . '/'));

 ?>