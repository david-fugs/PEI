<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../access.php");
    exit;
}

// Configurar codificación de caracteres
header("Content-Type: text/html; charset=UTF-8");
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Obtener parámetros
$id_archivo = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_cole = $_SESSION['id_cole'];

if ($id_archivo <= 0) {
    die("ERROR: ID de archivo no válido. ID recibido: " . $_GET['id']);
}

// Conectar a la base de datos
include("../../conexion.php");

// Asegurar que la conexión use UTF-8
if (isset($mysqli)) {
    $mysqli->set_charset("utf8");
}

// Consultar el archivo en la base de datos
$query = "SELECT * FROM convivencia_escolar WHERE id = ? AND id_cole = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $id_archivo, $id_cole);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("ERROR: Archivo no encontrado en la base de datos o no tienes permisos para acceder a él. ID: $id_archivo, Colegio: $id_cole");
}

$archivo = $result->fetch_assoc();

// Construir la ruta del archivo
$storedPath = $archivo['ruta_archivo'];
$serverPath = __DIR__ . '/' . $storedPath;

// Verificar que el archivo existe
if (!file_exists($serverPath)) {
    die("ERROR: El archivo no existe en el servidor.<br>
         Ruta esperada: $serverPath<br>
         Ruta en BD: $storedPath<br>
         Directorio actual: " . __DIR__ . "<br>
         Archivo: " . $archivo['nombre_archivo']);
}

// Obtener información del archivo
$filename = $archivo['nombre_archivo'];
$filesize = filesize($serverPath);
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $serverPath);
finfo_close($finfo);

// Si no se puede determinar el tipo MIME, usar uno por defecto
if (!$mime_type) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    switch ($extension) {
        case 'pdf':
            $mime_type = 'application/pdf';
            break;
        case 'doc':
            $mime_type = 'application/msword';
            break;
        case 'docx':
            $mime_type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            break;
        case 'xls':
            $mime_type = 'application/vnd.ms-excel';
            break;
        case 'xlsx':
            $mime_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            break;
        case 'jpg':
        case 'jpeg':
            $mime_type = 'image/jpeg';
            break;
        case 'png':
            $mime_type = 'image/png';
            break;
        default:
            $mime_type = 'application/octet-stream';
    }
}

// Limpiar cualquier salida anterior
if (ob_get_level()) {
    ob_end_clean();
}

// Establecer las cabeceras para la descarga
header('Content-Type: ' . $mime_type);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . $filesize);
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Expires: 0');

// Leer y enviar el archivo
$handle = fopen($serverPath, 'rb');
if ($handle) {
    while (!feof($handle)) {
        echo fread($handle, 8192);
        flush();
    }
    fclose($handle);
} else {
    die("Error al abrir el archivo");
}

exit;
?>