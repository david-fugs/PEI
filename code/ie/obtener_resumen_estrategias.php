<?php
include '../../conexion.php';

header('Content-Type: application/json; charset=UTF-8');
mysqli_set_charset($mysqli, 'utf8');

if (!isset($_GET['cod_dane_sede']) || trim($_GET['cod_dane_sede']) === '') {
    echo json_encode([]);
    exit;
}

$cod_dane_sede = trim($_GET['cod_dane_sede']);

$stmt = $mysqli->prepare("SELECT id, aliado, eje, especificar_aliado FROM estrategia_ju WHERE cod_dane_sede = ? ORDER BY id ASC");
if (!$stmt) {
    echo json_encode([]);
    exit;
}

$stmt->bind_param("s", $cod_dane_sede);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'id'                => (int)$row['id'],
        'aliado'            => $row['aliado'],
        'eje'               => $row['eje'],
        'especificar_aliado'=> $row['especificar_aliado']
    ];
}

$stmt->close();

echo json_encode($data, JSON_UNESCAPED_UNICODE);
