<?php
include '../../conexion.php';

header('Content-Type: application/json');

if (isset($_GET['cod_dane_sede'])) {
    $cod_dane_sede = $_GET['cod_dane_sede'];
    $aliado = $_GET['aliado'] ?? '';

    if (!empty($aliado)) {
        // Obtener todos los ejes para un aliado específico en una sede
        $stmt = $mysqli->prepare("SELECT DISTINCT eje FROM estrategia_ju WHERE cod_dane_sede = ? AND aliado = ? ORDER BY eje");
        $stmt->bind_param("ss", $cod_dane_sede, $aliado);
    } else {
        // Obtener todas las combinaciones aliado-eje para una sede
        $stmt = $mysqli->prepare("SELECT DISTINCT aliado, eje FROM estrategia_ju WHERE cod_dane_sede = ? ORDER BY aliado, eje");
        $stmt->bind_param("s", $cod_dane_sede);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }
    
    echo json_encode($datos);
} else {
    echo json_encode([]);
}
?>
