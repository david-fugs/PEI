<?php
session_start();
include '../../conexion.php';

header('Content-Type: application/json; charset=UTF-8');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

$id = (int)$_POST['id'];
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$stmt = $mysqli->prepare("DELETE FROM estrategia_ju WHERE id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error preparando consulta']);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
