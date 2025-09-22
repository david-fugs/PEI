<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $id_cole = $_SESSION['id_cole'];
    
    // Verificar que el registro pertenece a este colegio usando nit
    $sql_colegio = "SELECT nit_cole FROM colegios WHERE id_cole = $id_cole";
    $res_colegio = mysqli_query($mysqli, $sql_colegio);
    $colegio = mysqli_fetch_assoc($res_colegio);
    $nit = mysqli_real_escape_string($mysqli, $colegio['nit_cole']);

    $sql_verify = "SELECT id FROM intensidad_horaria_semanal WHERE id = ? AND nit_establecimiento = ?";
    $stmt_verify = mysqli_prepare($mysqli, $sql_verify);
    mysqli_stmt_bind_param($stmt_verify, "is", $id, $nit);
    mysqli_stmt_execute($stmt_verify);
    $result_verify = mysqli_stmt_get_result($stmt_verify);
    
    if (mysqli_num_rows($result_verify) > 0) {
        $sql_delete = "DELETE FROM intensidad_horaria_semanal WHERE id = ?";
        $stmt_delete = mysqli_prepare($mysqli, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id);
        
        if (mysqli_stmt_execute($stmt_delete)) {
            echo json_encode(['success' => true, 'message' => 'Registro eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el registro']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Registro no encontrado o sin permisos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

mysqli_close($mysqli);
?>