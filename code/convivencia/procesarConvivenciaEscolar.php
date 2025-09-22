<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../access.php");
    exit;
}

// Configurar la codificación de caracteres
header("Content-Type: text/html; charset=UTF-8");
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

include("../../conexion.php");
date_default_timezone_set("America/Bogota");

// Asegurar que la conexión use UTF-8
if (isset($mysqli)) {
    $mysqli->set_charset("utf8mb4");
}

// Validar que se reciban los datos por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: convivenciaEscolar.php?error=metodo_invalido");
    exit;
}

$id_cole = $_POST['id_cole'];
$tipo_documento = $_POST['tipo_documento'];
$anio_documento = intval($_POST['anio_documento']);
$version = !empty($_POST['version']) ? trim($_POST['version']) : '1.0';
$descripcion = !empty($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
$id_usuario = $_SESSION['id'];
$fecha_subida = date('Y-m-d H:i:s');

// Campos específicos para actas
$numero_acta = ($tipo_documento === 'actas' && !empty($_POST['numero_acta'])) ? trim($_POST['numero_acta']) : null;
$fecha_reunion = ($tipo_documento === 'actas' && !empty($_POST['fecha_reunion'])) ? $_POST['fecha_reunion'] : null;

// Validar datos requeridos
if (empty($id_cole) || empty($tipo_documento) || empty($anio_documento)) {
    mostrarError("Datos requeridos faltantes.");
}

// Validar tipo de documento
$tipos_validos = ['conformacion', 'reglamento', 'actas', 'planes_accion'];
if (!in_array($tipo_documento, $tipos_validos)) {
    mostrarError("Tipo de documento no válido.");
}

// Validar archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    mostrarError("No se pudo subir el archivo.");
}

$archivo = $_FILES['archivo'];
$nombre_original = $archivo['name'];
$tmp_name = $archivo['tmp_name'];
$size = $archivo['size'];
$type = $archivo['type'];

// Validar tipo de archivo
$tipos_permitidos = [
    'application/pdf', 
    'application/msword', 
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

if (!in_array($type, $tipos_permitidos)) {
    mostrarError("Tipo de archivo no permitido. Solo se permiten PDF, DOC y DOCX.");
}

// Validar tamaño (50MB máximo)
$max_size = 50 * 1024 * 1024; // 50MB en bytes
if ($size > $max_size) {
    mostrarError("El archivo es demasiado grande. Máximo 50MB permitido.");
}

// Crear nombre de archivo único para evitar duplicados
$extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
$timestamp = date('YmdHis');
$nombre_archivo = "{$tipo_documento}_{$anio_documento}_{$timestamp}." . $extension;

// Crear directorio si no existe
$directorio = "files/{$id_cole}/{$anio_documento}/convivencia_escolar/";
if (!file_exists($directorio)) {
    if (!mkdir($directorio, 0777, true)) {
        mostrarError("No se pudo crear el directorio de destino.");
    }
}

// Ruta completa del archivo
$ruta_archivo = $directorio . $nombre_archivo;

// Mover archivo al directorio de destino
if (move_uploaded_file($tmp_name, $ruta_archivo)) {
    // Escapar valores para evitar inyección SQL
    $id_cole_escaped = $mysqli->real_escape_string($id_cole);
    $tipo_documento_escaped = $mysqli->real_escape_string($tipo_documento);
    $anio_documento_escaped = $mysqli->real_escape_string($anio_documento);
    $nombre_archivo_escaped = $mysqli->real_escape_string($nombre_archivo);
    $nombre_original_escaped = $mysqli->real_escape_string($nombre_original);
    $version_escaped = $mysqli->real_escape_string($version);
    $descripcion_escaped = $mysqli->real_escape_string($descripcion);
    $numero_acta_escaped = $numero_acta ? "'" . $mysqli->real_escape_string($numero_acta) . "'" : "NULL";
    $fecha_reunion_escaped = $fecha_reunion ? "'" . $mysqli->real_escape_string($fecha_reunion) . "'" : "NULL";
    $ruta_archivo_escaped = $mysqli->real_escape_string($ruta_archivo);
    $size_escaped = $mysqli->real_escape_string($size);
    $fecha_subida_escaped = $mysqli->real_escape_string($fecha_subida);
    $id_usuario_escaped = $mysqli->real_escape_string($id_usuario);
    
    // Guardar información en la base de datos - Consulta plana
    $sql = "INSERT INTO convivencia_escolar (
                id_cole, 
                tipo_documento, 
                anio_documento, 
                nombre_archivo, 
                nombre_original, 
                version, 
                descripcion, 
                numero_acta, 
                fecha_reunion, 
                ruta_archivo, 
                tamano_archivo, 
                fecha_subida, 
                id_usuario
            ) VALUES (
                '$id_cole_escaped', 
                '$tipo_documento_escaped', 
                '$anio_documento_escaped', 
                '$nombre_archivo_escaped', 
                '$nombre_original_escaped', 
                '$version_escaped', 
                '$descripcion_escaped', 
                $numero_acta_escaped, 
                $fecha_reunion_escaped, 
                '$ruta_archivo_escaped', 
                '$size_escaped', 
                '$fecha_subida_escaped', 
                '$id_usuario_escaped'
            )";
    
    if ($mysqli->query($sql)) {
        // Éxito - Redireccionar con mensaje de éxito
        $mysqli->close();
        mostrarExito("Documento subido exitosamente", $tipo_documento);
    } else {
        // Error en la base de datos - eliminar archivo subido
        unlink($ruta_archivo);
        mostrarError("Error al guardar en la base de datos: " . $mysqli->error);
    }
} else {
    mostrarError("Error al mover el archivo al directorio de destino.");
}

function mostrarError($mensaje) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error - PEI SOFT</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Error',
                text: '<?php echo addslashes($mensaje); ?>',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                window.history.back();
            });
        </script>
    </body>
    </html>
    <?php
    exit;
}

function mostrarExito($mensaje, $tipo_documento) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Éxito - PEI SOFT</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Exito!',
                text: '<?php echo addslashes($mensaje); ?>',
                icon: 'success',
                confirmButtonText: 'Continuar'
            }).then((result) => {
                window.location.href = 'convivenciaEscolar.php?mensaje=subido&tipo=<?php echo urlencode($tipo_documento); ?>';
            });
        </script>
    </body>
    </html>
    <?php
    exit;
}
?>
