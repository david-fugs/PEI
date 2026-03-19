<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");
include_once(__DIR__ . '/../../adminViewHelper.php');

$id_cole = $_SESSION['id_cole'];
if (isAdminViewMode() && $_SESSION['tipo_usuario'] == "1") {
    $id_cole = getEfectivoIdCole();
}

if (!isset($_GET['id_ct'])) {
    header("Location: addteleologico.php");
    exit();
}

$id_ct = intval($_GET['id_ct']);
if ($id_ct <= 0) {
    header("Location: addteleologico.php");
    exit();
}

// Verificar que el registro pertenece al colegio
$sql = "SELECT id_ct, id_cole FROM componente_teleologico WHERE id_ct = ? AND id_cole = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $id_ct, $id_cole);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: addteleologico.php");
    exit();
}
$stmt->close();

// Eliminar carpeta de archivos asociada al id_cole (ruta usada por addteleologico2.php)
$directorio = __DIR__ . '/files/' . $id_cole . '/';

function eliminarDirectorio($dir) {
    if (!is_dir($dir)) return;
    $archivos = scandir($dir);
    foreach ($archivos as $archivo) {
        if ($archivo === '.' || $archivo === '..') continue;
        $ruta = $dir . $archivo;
        if (is_dir($ruta)) {
            eliminarDirectorio($ruta . '/');
        } else {
            @unlink($ruta);
        }
    }
    @rmdir($dir);
}

eliminarDirectorio($directorio);

// Eliminar registro de la base de datos
$sql_delete = "DELETE FROM componente_teleologico WHERE id_ct = ? AND id_cole = ?";
$stmt_delete = $mysqli->prepare($sql_delete);
$stmt_delete->bind_param("ii", $id_ct, $id_cole);
$stmt_delete->execute();
$stmt_delete->close();

$mysqli->close();

header("Location: addteleologico.php");
exit();
?>