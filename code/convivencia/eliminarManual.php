<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../access.php");
    exit;
}

// Configurar la codificación de caracteres
header("Content-Type: text/html; charset=UTF-8");
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

include("../../conexion.php");

// Asegurar que la conexión use UTF-8
if (isset($mysqli)) {
    $mysqli->set_charset("utf8mb4");
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_cole = $_SESSION['id_cole'];

if ($id <= 0) {
    die("Error: ID de manual no válido.");
}

// Verificar que el manual pertenece al colegio del usuario logueado
$check_sql = "SELECT * FROM manual_convivencia WHERE id = ? AND id_cole = ?";
$check_stmt = $mysqli->prepare($check_sql);
$check_stmt->bind_param("ii", $id, $id_cole);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Manual no encontrado o no tiene permisos para eliminarlo.");
}

$manual = $result->fetch_assoc();
$ruta_archivo = $manual['ruta_archivo'];

// Eliminar archivo físico si existe
if (file_exists($ruta_archivo)) {
    unlink($ruta_archivo);
}

// Eliminar registro de la base de datos
$delete_sql = "DELETE FROM manual_convivencia WHERE id = ? AND id_cole = ?";
$delete_stmt = $mysqli->prepare($delete_sql);
$delete_stmt->bind_param("ii", $id, $id_cole);

if ($delete_stmt->execute()) {
    // Éxito
    header("Location: manualConvivencia.php?mensaje=eliminado");
} else {
    // Error
    header("Location: manualConvivencia.php?error=eliminar");
}

$mysqli->close();
?>
