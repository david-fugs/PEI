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
    $id_cole = $_POST['id_cole'] ?? '';
    $codigo_dane = $_POST['codigo_dane'] ?? '';
    $nombre_sede = $_POST['nombre_sede'] ?? '';
    $zona = $_POST['zona'] ?? '';
    // Validar si el código DANE ya existe
    $check = $mysqli->query("SELECT 1 FROM sedes WHERE cod_dane_sede = '$codigo_dane' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        echo "<script>alert('El código DANE ya se encuentra usado por otra sede');</script>";
        echo "<script>window.location.href='showIe.php';</script>";
    } else {
        //ejecutar consulta en sedes
        $sql = "INSERT INTO sedes (id_cole, cod_dane_sede, nombre_sede, zona_sede, estado, fecha_alta_sede,id_usu) VALUES ('$id_cole', '$codigo_dane', '$nombre_sede', '$zona', 'activo', NOW(),'$id')";
        $resultado = $mysqli->query($sql);
        if ($resultado) {
            //si se inserto correctamente
            echo "<script>alert('Sede registrada correctamente');</script>";
            echo "<script>window.location.href='showIe.php';</script>";
        } else {
            //si no se inserto
            $error = addslashes($mysqli->error);
            echo "<script>alert(\"Error al registrar la sede: $error\");</script>";
            echo "<script>window.location.href='showIe.php';</script>";
        }
    }
} else {
    //si no se recibieron datos por post
    echo "<script>alert('No se recibieron datos');</script>";
    echo "<script>window.location.href='showIe.php';</script>";
}
