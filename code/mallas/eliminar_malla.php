<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

if (!isset($_GET['id_mc'])) {
    echo "<div style='color:red; font-weight:bold; text-align:center;'>ID de malla no especificado.</div>";
    exit();
}

$id_mc = intval($_GET['id_mc']);

// Buscar la malla para obtener el id_cole y validar existencia
$sql = "SELECT * FROM mallas_curriculares WHERE id_mc = $id_mc";
$result = $mysqli->query($sql);
if (!$result || $result->num_rows == 0) {
    echo "<div style='color:red; font-weight:bold; text-align:center;'>Registro no encontrado.</div>";
    exit();
}
$row = $result->fetch_assoc();

// Eliminar archivos relacionados
$directorio = '../../files/' . $id_mc . '/';
function eliminarDirectorio($dir) {
    if (!file_exists($dir)) return;
    $archivos = scandir($dir);
    foreach ($archivos as $archivo) {
        if ($archivo != '.' && $archivo != '..') {
            $ruta = $dir . $archivo;
            if (is_dir($ruta)) {
                eliminarDirectorio($ruta . '/');
            } else {
                unlink($ruta);
            }
        }
    }
    rmdir($dir);
}
eliminarDirectorio($directorio);

// Eliminar registro de la base de datos
$sql_delete = "DELETE FROM mallas_curriculares WHERE id_mc = $id_mc";
if ($mysqli->query($sql_delete)) {
    echo "<div style='color:green; font-weight:bold; text-align:center;'>Registro y archivos eliminados correctamente.<br><a href='addmallas.php'>Volver</a></div>";
} else {
    echo "<div style='color:red; font-weight:bold; text-align:center;'>Error al eliminar: " . $mysqli->error . "<br><a href='addmallas.php'>Volver</a></div>";
}
?>
