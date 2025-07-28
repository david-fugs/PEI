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

	// Eliminar carpeta y archivos asociados
	$dir = __DIR__ . '/files/' . $id;
	if (is_dir($dir)) {
		// Función recursiva para eliminar todo el contenido
		function eliminarDir($carpeta) {
			foreach (glob($carpeta . '/*') as $archivo) {
				if (is_dir($archivo)) {
					eliminarDir($archivo);
				} else {
					unlink($archivo);
				}
			}
			rmdir($carpeta);
		}
		eliminarDir($dir);
	}
}
header("Location: addproject.php");
exit();
?>
