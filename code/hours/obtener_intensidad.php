<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

include("../../conexion.php");

$id_cole = $_SESSION['id_cole'];

$sql_colegio = "SELECT nit_cole FROM colegios WHERE id_cole = $id_cole";
$res_colegio = mysqli_query($mysqli, $sql_colegio);
$colegio = mysqli_fetch_assoc($res_colegio);

$nit = mysqli_real_escape_string($mysqli, $colegio['nit_cole']);

$sql = "SELECT ihs.* 
    FROM intensidad_horaria_semanal ihs
    WHERE ihs.nit_establecimiento = '$nit'
    ORDER BY ihs.area, ihs.asignatura";
$result = mysqli_query($mysqli, $sql);

if ($result) {
    $datos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $datos[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'datos' => $datos
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al cargar los datos: ' . mysqli_error($mysqli)
    ]);
}

mysqli_close($mysqli);
?>