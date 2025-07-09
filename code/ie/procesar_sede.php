<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}

$nombre         = $_SESSION['nombre'];
$tipo_usuario   = $_SESSION['tipo_usuario'];
$id = $_SESSION['id'];

include("../../conexion.php");
date_default_timezone_set("America/Bogota");
//commprobar que trae algo post
if (isset($_POST)) {
    print_r($_SESSION);
    $id_cole = $_POST['id_cole'] ?? '';
    $codigo_dane = $_POST['codigo_dane'] ?? '';
    $nombre_sede = $_POST['nombre_sede'] ?? '';
    $zona = $_POST['zona'] ?? '';
    //ejecutar consulta en sedes
    $sql = "INSERT INTO sedes (id_cole, cod_dane_sede, nombre_sede, zona_sede, estado, fecha_alta_sede) VALUES ('$id_cole', '$codigo_dane', '$nombre_sede', '$zona', 'activo', NOW())";
    $resultado = $mysqli->query($sql);
    if ($resultado) {
        //si se inserto correctamente
        echo "<script>alert('Sede registrada correctamente');</script>";
        echo "<script>window.location.href='showIe.php';</script>";
    } else {
        //si no se inserto
        echo "<script>alert('Error al registrar la sede');</script>";
        echo "<script>window.location.href='showIe.php';</script>";
    }
} else {
    //si no se recibieron datos por post
    echo "<script>alert('No se recibieron datos');</script>";
    echo "<script>window.location.href='showIe.php';</script>";
}
