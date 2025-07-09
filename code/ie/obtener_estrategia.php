<?php
include '../../conexion.php';

if (isset($_GET['cod_dane_sede'])) {
    $cod_dane_sede = $_GET['cod_dane_sede'];
    $aliado = $_GET['aliado'] ?? '';
    $eje = $_GET['eje'] ?? '';
    $especificar_aliado = $_GET['especificar_aliado'] ?? '';

    if (!empty($aliado) && !empty($eje)) {
        // Si el aliado es "Entre Otros" y hay especificación, buscar por especificación también
        if ($aliado === 'Entre Otros' && !empty($especificar_aliado)) {
            $stmt = $mysqli->prepare("SELECT * FROM estrategia_ju WHERE cod_dane_sede = ? AND aliado = ? AND eje = ? AND especificar_aliado = ?");
            $stmt->bind_param("ssss", $cod_dane_sede, $aliado, $eje, $especificar_aliado);
        } else {
            // Buscar por cod_dane_sede, aliado Y eje específicos
            $stmt = $mysqli->prepare("SELECT * FROM estrategia_ju WHERE cod_dane_sede = ? AND aliado = ? AND eje = ?");
            $stmt->bind_param("sss", $cod_dane_sede, $aliado, $eje);
        }
    } else {
        // Si no hay aliado o eje, devolver null (para limpiar el formulario)
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
