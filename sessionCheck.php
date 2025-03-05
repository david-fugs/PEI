
<!-- session_start();

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    
}

$id             = $_SESSION['id'];
// $usuario        = $_SESSION['usuario'];
$nombre         = $_SESSION['nombre'];
$tipo_usuario   = $_SESSION['tipo_usuario'];
$id_cole        = $_SESSION['id_cole']; -->

<!-- This file will verify the session and set the 
session variables based on the role of the user. -->
<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit();
}

$id             = $_SESSION['id'];
$nombre         = $_SESSION['nombre'];
$tipo_usuario   = $_SESSION['tipo_usuario'];
$id_cole        = $_SESSION['id_cole'];

if ($tipo_usuario === "1") {//admin
    $_SESSION['admin']['id'] = $id;
    $_SESSION['admin']['nombre'] = $nombre;
    $_SESSION['admin']['tipo_usuario'] = $tipo_usuario;
   
} else {
    $_SESSION['user']['id'] = $id;
    $_SESSION['user']['nombre'] = $nombre;
    $_SESSION['user']['tipo_usuario'] = $tipo_usuario;
    $_SESSION['user']['id_cole'] = $id_cole;
}
?>
