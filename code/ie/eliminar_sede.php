<?php
include '../../conexion.php'; // ajusta la ruta si es necesario

if (isset($_GET['cod_dane_sede'])) {
    $cod_dane = $_GET['cod_dane_sede'];
    $stmt = $mysqli->prepare("DELETE FROM sedes WHERE cod_dane_sede = ?");
    $stmt->bind_param("s", $cod_dane);
    if ($stmt->execute()) {
        header("Location: showIe.php?mensaje=eliminado");
    } else {
        echo "Error al eliminar.";
    }
    $stmt->close();
} else {
    echo "Código DANE no proporcionado.";
}
?>
