<?php
	// Configurar la codificación antes de la conexión
	ini_set('default_charset', 'UTF-8');
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	
	$mysqli = new mysqli("localhost", 'profesional2', 'sVb0t2Y5rHAAAEd', 'profesional2');
	
	if ($mysqli->connect_error) {
		die("Error de conexión: " . $mysqli->connect_error);
	}
	
	// Configurar charset a UTF-8
	$mysqli->set_charset('utf8mb4');
	
	// Configuración adicional para asegurar UTF-8
	$mysqli->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
	$mysqli->query("SET CHARACTER SET utf8mb4");
	$mysqli->query("SET character_set_connection=utf8mb4");
	$mysqli->query("SET character_set_results=utf8mb4");
	$mysqli->query("SET character_set_client=utf8mb4");
?>
