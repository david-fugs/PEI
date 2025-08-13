<?php
include("./../../../conexion.php");
require_once './../../../sessionCheck.php';

$id_usu = $_SESSION['user']['id'];
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($project_id == 0) {
    $_SESSION['message'] = "ID de proyecto inválido.";
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

// Verificar que el proyecto pertenece al colegio del usuario
$sql_project = "SELECT * FROM proyec_pedag_transv WHERE Id_proyec_pedag_transv = $project_id AND id_cole = $id_cole";
$result_project = mysqli_query($mysqli, $sql_project);

if (!$result_project || mysqli_num_rows($result_project) == 0) {
    $_SESSION['message'] = "Proyecto no encontrado o no tiene permisos para eliminarlo.";
    $_SESSION['message_type'] = "danger";
    header("Location: userViewProject.php");
    exit;
}

$project = mysqli_fetch_assoc($result_project);
$nameProject = $project['selec_proyec_transv'];

// Determinar número de proyecto para eliminar archivos
$nroProject = 0;
switch ($nameProject) {
    case "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC":
        $nroProject = 1;
        break;
    case "PROYECTO DE EDUCACIÓN AMBIENTAL PRAE":
        $nroProject = 2;
        break;
    case "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS":
        $nroProject = 3;
        break;
    case "PROYECTO DE EDUCACION VIAL":
        $nroProject = 4;
        break;
}

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

// Eliminar archivos asociados al proyecto
if ($nroProject >= 1 && $nroProject <= 4) {
    $directorio = './../projectFiles/' . $id_cole . '/' . $nroProject . '/';
    if (is_dir($directorio)) {
        deleteDirectory($directorio);
    }
}

// Eliminar el proyecto de la base de datos
$delete_sql = "DELETE FROM proyec_pedag_transv WHERE Id_proyec_pedag_transv = $project_id";

if (mysqli_query($mysqli, $delete_sql)) {
    $_SESSION['message'] = "El proyecto '" . $nameProject . "' ha sido eliminado exitosamente junto con todos sus archivos.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error al eliminar el proyecto: " . mysqli_error($mysqli);
    $_SESSION['message_type'] = "danger";
}

header("Location: userViewProject.php");
exit;
?>
