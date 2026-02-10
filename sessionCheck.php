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

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$id             = $_SESSION['id'];
$nombre         = $_SESSION['nombre'];
$tipo_usuario   = $_SESSION['tipo_usuario'];
$id_cole        = $_SESSION['id_cole'];

// Incluir el helper de visualización de administrador
include_once(__DIR__ . '/adminViewHelper.php');

// Si está en modo administrador, sobrescribir el id_cole con el efectivo
if (isAdminViewMode() && $tipo_usuario == "1") {
    $id_cole = getEfectivoIdCole();
}

if ($tipo_usuario == "1") { // admin
    if (!is_array($_SESSION['admin'] ?? null)) {
        $_SESSION['admin'] = [];
    }
    $_SESSION['admin']['id'] = $id;
    $_SESSION['admin']['nombre'] = $nombre;
    $_SESSION['admin']['tipo_usuario'] = $tipo_usuario;
} else {
    if (!is_array($_SESSION['user'] ?? null)) {
        $_SESSION['user'] = [];
    }
    $_SESSION['user']['id'] = $id;
    $_SESSION['user']['nombre'] = $nombre;
    $_SESSION['user']['tipo_usuario'] = $tipo_usuario;
    $_SESSION['user']['id_cole'] = $id_cole;
}
?>