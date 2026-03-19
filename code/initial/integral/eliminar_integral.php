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

if (!isset($_GET['id_dllo_integ'])) {
    header("Location: addintegral.php");
    exit();
}

$id_dllo_integ = intval($_GET['id_dllo_integ']);

if ($id_dllo_integ <= 0) {
    header("Location: addintegral.php");
    exit();
}

// Verificar que el registro pertenece al colegio activo
$sql = "SELECT id_dllo_integ FROM dllo_integ WHERE id_dllo_integ = ? AND id_cole = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $id_dllo_integ, $id_cole);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: addintegral.php");
    exit();
}
$stmt->close();

// Eliminar carpeta de archivos asociada
$directorio = __DIR__ . '/files/' . $id_dllo_integ . '/';

function eliminarDirectorioDlloInteg($dir) {
    if (!is_dir($dir)) return;
    $archivos = scandir($dir);
    foreach ($archivos as $archivo) {
        if ($archivo === '.' || $archivo === '..') continue;
        $ruta = $dir . $archivo;
        if (is_dir($ruta)) {
            eliminarDirectorioDlloInteg($ruta . '/');
        } else {
            unlink($ruta);
        }
    }
    rmdir($dir);
}

eliminarDirectorioDlloInteg($directorio);

// Eliminar registro de la base de datos
$sql_delete = "DELETE FROM dllo_integ WHERE id_dllo_integ = ? AND id_cole = ?";
$stmt_delete = $mysqli->prepare($sql_delete);
$stmt_delete->bind_param("ii", $id_dllo_integ, $id_cole);
$stmt_delete->execute();
$stmt_delete->close();

$mysqli->close();

header("Location: addintegral.php");
exit();
?>
