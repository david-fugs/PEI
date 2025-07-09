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

// Validar que se reciba el ID del documento
if (!isset($_GET['id']) || empty($_GET['id'])) {
    mostrarError("ID de documento no válido.");
}

$id_documento = intval($_GET['id']);
$id_cole = $_SESSION['id_cole'];
$id_usuario = $_SESSION['id'];

// Verificar que el documento existe y pertenece al colegio del usuario
$sql = "SELECT * FROM convivencia_escolar WHERE id = ? AND id_cole = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    mostrarError("Error preparando la consulta: " . $mysqli->error);
}

$stmt->bind_param("ii", $id_documento, $id_cole);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    mostrarError("Documento no encontrado o no tienes permisos para eliminarlo.");
}

$documento = $result->fetch_assoc();
$stmt->close();

// Verificar permisos adicionales si es necesario
// (aquí puedes agregar lógica adicional de permisos)

// Intentar eliminar el archivo físico
$archivo_eliminado = false;
if (file_exists($documento['ruta_archivo'])) {
    $archivo_eliminado = unlink($documento['ruta_archivo']);
    if (!$archivo_eliminado) {
        // Log del error pero continuar con la eliminación de la base de datos
        error_log("No se pudo eliminar el archivo físico: " . $documento['ruta_archivo']);
    }
} else {
    // El archivo no existe físicamente, continuar con la eliminación de la base de datos
    $archivo_eliminado = true;
}

// Eliminar registro de la base de datos
$sql_delete = "DELETE FROM convivencia_escolar WHERE id = ? AND id_cole = ?";
$stmt_delete = $mysqli->prepare($sql_delete);

if (!$stmt_delete) {
    mostrarError("Error preparando la consulta de eliminación: " . $mysqli->error);
}

$stmt_delete->bind_param("ii", $id_documento, $id_cole);

if ($stmt_delete->execute()) {
    if ($stmt_delete->affected_rows > 0) {
        // Registro eliminado exitosamente
        $stmt_delete->close();
        $mysqli->close();
        
        // Registrar la eliminación (opcional)
        $log_message = "Usuario {$_SESSION['nombre']} eliminó documento de convivencia escolar: {$documento['nombre_original']} (ID: {$id_documento})";
        error_log($log_message);
        
        $mensaje_archivo = $archivo_eliminado ? "" : " (El archivo físico no pudo ser eliminado)";
        mostrarExito("Documento eliminado exitosamente" . $mensaje_archivo, $documento['tipo_documento']);
    } else {
        mostrarError("No se pudo eliminar el documento. Es posible que ya haya sido eliminado.");
    }
} else {
    mostrarError("Error al eliminar el documento: " . $stmt_delete->error);
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
                window.location.href = 'convivenciaEscolar.php?error=eliminar';
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
                title: 'Eliminado!',
                text: '<?php echo addslashes($mensaje); ?>',
                icon: 'success',
                confirmButtonText: 'Continuar'
            }).then((result) => {
                window.location.href = 'convivenciaEscolar.php?mensaje=eliminado&tipo=<?php echo urlencode($tipo_documento); ?>';
            });
        </script>
    </body>
    </html>
    <?php
    exit;
}
?>
