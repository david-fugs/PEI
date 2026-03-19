<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../../index.php");
    exit();
}

include("../../../conexion.php");

include_once(__DIR__ . '/../../../adminViewHelper.php');

$id_cole = $_SESSION['id_cole'];
if (isAdminViewMode() && $_SESSION['tipo_usuario'] == "1") {
    $id_cole = getEfectivoIdCole();
}

if (!isset($_GET['id_edu_ini'])) {
    header("Location: addeduca.php");
    exit();
}

$id_edu_ini = intval($_GET['id_edu_ini']);

if ($id_edu_ini <= 0) {
    header("Location: addeduca.php");
    exit();
}

// Verificar que el registro pertenece al colegio activo
$sql = "SELECT id_edu_ini FROM educa_inicial WHERE id_edu_ini = ? AND id_cole = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $id_edu_ini, $id_cole);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: addeduca.php");
    exit();
}
$stmt->close();

// Eliminar carpeta de archivos asociada
$directorio = __DIR__ . '/files/' . $id_edu_ini . '/';

function eliminarDirectorioEduIni($dir) {
    if (!is_dir($dir)) return;
    $archivos = scandir($dir);
    foreach ($archivos as $archivo) {
        if ($archivo === '.' || $archivo === '..') continue;
        $ruta = $dir . $archivo;
        if (is_dir($ruta)) {
            eliminarDirectorioEduIni($ruta . '/');
        } else {
            unlink($ruta);
        }
    }
    rmdir($dir);
}

eliminarDirectorioEduIni($directorio);

// Eliminar registro de la base de datos
$sql_delete = "DELETE FROM educa_inicial WHERE id_edu_ini = ? AND id_cole = ?";
$stmt_delete = $mysqli->prepare($sql_delete);
$stmt_delete->bind_param("ii", $id_edu_ini, $id_cole);
$stmt_delete->execute();
$stmt_delete->close();

$mysqli->close();

header("Location: addeduca.php");
exit();
?>
