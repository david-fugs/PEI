<?php
// Archivo: deleteproject.php
session_start();
if (!isset($_SESSION['id'])) {
	header("Location: ../../index.php");
	exit();
}
include("../../conexion.php");
if (isset($_GET['id_proy_trans'])) {
	$id = intval($_GET['id_proy_trans']);
	$query = "DELETE FROM proyectos_transversales WHERE id_proy_trans=$id";
	$mysqli->query($query);
}
header("Location: addproject.php");
exit();
?>
