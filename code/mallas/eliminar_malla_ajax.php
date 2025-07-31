<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit();
}

header('Content-Type: application/json');
include("../../conexion.php");

if (!isset($_POST['id_mc'])) {
    echo json_encode(["success" => false, "message" => "ID de malla no especificado."]);
    exit();
}

$id_mc = intval($_POST['id_mc']);

// Buscar la malla para validar existencia
$sql = "SELECT * FROM mallas_curriculares WHERE id_mc = $id_mc";
$result = $mysqli->query($sql);
if (!$result || $result->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "Registro no encontrado."]);
    exit();
}

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
    echo json_encode(["success" => true, "message" => "Registro y archivos eliminados correctamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar: " . $mysqli->error]);
}
?>
