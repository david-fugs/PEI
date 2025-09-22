<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

include("../../conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $id_cole = $_SESSION['id_cole'];
    
    // Verificar que el registro pertenece a este colegio usando nit
    $sql_colegio = "SELECT nit_cole FROM colegios WHERE id_cole = $id_cole";
    $res_colegio = mysqli_query($mysqli, $sql_colegio);
    $colegio = mysqli_fetch_assoc($res_colegio);
    $nit = mysqli_real_escape_string($mysqli, $colegio['nit_cole']);

    $sql = "SELECT ihs.* FROM intensidad_horaria_semanal ihs WHERE ihs.id = ? AND ihs.nit_establecimiento = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "is", $id, $nit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'success' => true,
            'datos' => $row
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Registro no encontrado'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID no especificado'
    ]);
}

mysqli_close($mysqli);
?>