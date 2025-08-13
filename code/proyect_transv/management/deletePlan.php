<?php
include("./../../../conexion.php");
require_once './../../../sessionCheck.php';

$id_usu = $_SESSION['user']['id'];
$plan_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($plan_id == 0) {
    $_SESSION['message'] = "ID de plan inválido.";
    $_SESSION['message_type'] = "danger";
    header("Location: userViewProject.php");
    exit;
}

// Obtener información del usuario y colegio
$sql_id_cole = "SELECT id_cole FROM usuarios WHERE id = $id_usu";
$result = mysqli_query($mysqli, $sql_id_cole);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_cole = $row['id_cole'];
} else {
    $_SESSION['message'] = "No se encontró el id_cole asociado a este usuario.";
    $_SESSION['message_type'] = "danger";
    header("Location: userViewProject.php");
    exit;
}

// Verificar que el plan pertenece al colegio del usuario
$sql_plan = "SELECT * FROM proyectos_planes WHERE id_proy_plan = $plan_id AND id_cole = $id_cole";
$result_plan = mysqli_query($mysqli, $sql_plan);

if (!$result_plan || mysqli_num_rows($result_plan) == 0) {
    $_SESSION['message'] = "Plan no encontrado o no tiene permisos para eliminarlo.";
    $_SESSION['message_type'] = "danger";
    header("Location: userViewProject.php");
    exit;
}

$plan = mysqli_fetch_assoc($result_plan);
$nombre_plan = $plan['nombre_proy_plan'];

// Función para eliminar directorio y sus contenidos
function deleteDirectory($dirPath) {
    if (is_dir($dirPath)) {
        $files = array_diff(scandir($dirPath), array('.', '..'));
        foreach ($files as $file) {
            $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }
        return rmdir($dirPath);
    }
    return false;
}

// Eliminar archivos asociados al plan
$directorio = './../plans/files/' . $plan_id . '/';
if (is_dir($directorio)) {
    deleteDirectory($directorio);
}

// Eliminar el plan de la base de datos
$delete_sql = "DELETE FROM proyectos_planes WHERE id_proy_plan = $plan_id";

if (mysqli_query($mysqli, $delete_sql)) {
    $_SESSION['message'] = "El proyecto/plan '" . $nombre_plan . "' ha sido eliminado exitosamente junto con todos sus archivos.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error al eliminar el proyecto/plan: " . mysqli_error($mysqli);
    $_SESSION['message_type'] = "danger";
}

header("Location: userViewProject.php");
exit;
?>
