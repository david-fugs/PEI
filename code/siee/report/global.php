<?php
	$host = "localhost";
	$user = "profesional2";
	$pass = "sVb0t2Y5rHAAAEd";
	$db = "profesional2";

	$conexion = mysqli_connect($host,$user,$pass,$db);
	$acentos = $conexion->query("SET NAMES 'utf8'");

?>