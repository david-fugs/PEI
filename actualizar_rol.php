<?php
include 'conexion.php'; // Asegúrate de incluir la conexión a la BD
if (isset($_POST['id_usuario']) && isset($_POST['tipo_usuario'])) {
    $id_usuario = intval($_POST['id_usuario']);
    $tipo_usuario = intval($_POST['tipo_usuario']);

    $query = "UPDATE usuarios SET tipo_usuario = ? WHERE id= ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $tipo_usuario, $id_usuario);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Error al actualizar";
    }

    $stmt->close();
}
?>
