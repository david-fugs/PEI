<?php
include '../../conexion.php';

if (isset($_GET['cod_dane_sede'])) {
    $cod_dane_sede = $_GET['cod_dane_sede'];
    $aliado = $_GET['aliado'] ?? '';

    if (!empty($aliado)) {
        // Buscar por cod_dane_sede Y aliado específico
        $stmt = $mysqli->prepare("SELECT * FROM estrategia_ju WHERE cod_dane_sede = ? AND aliado = ?");
        $stmt->bind_param("ss", $cod_dane_sede, $aliado);
    } else {
        // Si no hay aliado, devolver null (para limpiar el formulario)
        echo json_encode(null);
        exit;
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        echo json_encode($fila);
    } else {
        echo json_encode(null);
    }
}
?>
