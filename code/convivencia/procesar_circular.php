<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['id'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    
    // Helper local para comprobar admin (acepta 'admin' o '3')
    function isAdminLocal($t) { return ($t === 'admin' || $t === '3' || $t === 3 || $t === 'ADMIN'); }

    // Solo admin puede crear circulares
    if (!isAdminLocal($tipo_usuario)) {
        echo json_encode(['success' => false, 'message' => 'No tiene permisos para crear circulares']);
        exit();
    }
    
    $titulo = mysqli_real_escape_string($mysqli, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($mysqli, $_POST['descripcion']);
    $fecha_inicio = mysqli_real_escape_string($mysqli, $_POST['fecha_inicio']);
    $fecha_fin = mysqli_real_escape_string($mysqli, $_POST['fecha_fin']);
    
    // Validaciones
    if (empty($titulo) || empty($descripcion) || empty($fecha_inicio) || empty($fecha_fin)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit();
    }
    
    // Validar que la fecha de fin sea mayor a la de inicio
    if (strtotime($fecha_fin) <= strtotime($fecha_inicio)) {
        echo json_encode(['success' => false, 'message' => 'La fecha de fin debe ser posterior a la fecha de inicio']);
        exit();
    }
    
    try {
        $sql = "INSERT INTO circulares (titulo, descripcion, fecha_inicio, fecha_fin, estado, usuario_creacion) 
                VALUES ('$titulo', '$descripcion', '$fecha_inicio', '$fecha_fin', 'activa', $id_usuario)";
        
        if (mysqli_query($mysqli, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Circular creada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear la circular: ' . mysqli_error($mysqli)]);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

mysqli_close($mysqli);
?>