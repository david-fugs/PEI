<?php
include '../../conexion.php';

if (isset($_GET['cod_dane_sede'])) {
    $cod_dane_sede = $_GET['cod_dane_sede'];

    $stmt = $mysqli->prepare("SELECT * FROM estrategia_ju WHERE cod_dane_sede = ?");
    $stmt->bind_param("s", $cod_dane_sede);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        echo json_encode($fila);
    } else {
        echo json_encode(null);
    }
}
?>
