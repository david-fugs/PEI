<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

include("../../conexion.php");

if (isset($_POST['area']) && !empty($_POST['area'])) {
    $area = mysqli_real_escape_string($mysqli, $_POST['area']);
    
    $sql = "SELECT asignatura FROM areas_asignaturas_config 
            WHERE area = '$area' AND activa = 1 
            ORDER BY orden_asignatura";
    
    $result = mysqli_query($mysqli, $sql);
    
    if ($result) {
        $asignaturas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $asignaturas[] = $row['asignatura'];
        }
        
        echo json_encode([
            'success' => true,
            'asignaturas' => $asignaturas
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al consultar las asignaturas'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Área no especificada'
    ]);
}

mysqli_close($mysqli);
?>