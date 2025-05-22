<?php
include '../../conexion.php'; // Ajusta esto a tu ruta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $cod_dane_sede = $_POST['cod_dane_sede'];
    $nombre_sede = $_POST['nombre_sede'];
    $cod_dane_sede_old = $_POST['cod_dane_sede_old'];
    $zona_sede = $_POST['zona_sede'];
    //actualizar la sede
$sql = "UPDATE sedes SET cod_dane_sede = '$cod_dane_sede', nombre_sede = '$nombre_sede', zona_sede = '$zona_sede' WHERE cod_dane_sede = '$cod_dane_sede_old'";
$result = $mysqli->query($sql);

if ($result) {
    echo "<script>
        alert('¡Sede actualizada correctamente!');
      //  window.location.href = 'showIe.php';
    </script>";
} else {
    echo "<script>
        alert('Error al actualizar la sede: " . addslashes($mysqli->error) . "');
     //   window.location.href = 'showIe.php';
    </script>";
}


}