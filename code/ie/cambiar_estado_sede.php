<?php
header('Content-Type: application/json');
include '../../conexion.php';

// Configurar charset UTF-8 para la conexión
mysqli_set_charset($mysqli, 'utf8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod_dane_sede = $_POST['cod_dane_sede'] ?? '';
    $estado = $_POST['estado'] ?? '';
    
    // Validar datos
    if (empty($cod_dane_sede) || empty($estado)) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos incompletos'
        ]);
        exit;
    }
    
    // Validar estado
    if (!in_array($estado, ['activo', 'suspendido'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Estado inválido'
        ]);
        exit;
    }
    
    // Preparar consulta para evitar inyección SQL
    $stmt = $mysqli->prepare("UPDATE sedes SET estado = ? WHERE cod_dane_sede = ?");
    $stmt->bind_param("ss", $estado, $cod_dane_sede);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $mensaje = $estado === 'suspendido' ? 'Sede suspendida correctamente' : 'Sede activada correctamente';
            echo json_encode([
                'success' => true,
                'message' => $mensaje
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontró la sede o no se realizaron cambios'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar el estado: ' . $mysqli->error
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}

$mysqli->close();
?>
