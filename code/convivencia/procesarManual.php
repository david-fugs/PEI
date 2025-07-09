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

$id_cole = $_POST['id_cole'];
$anio_manual = intval($_POST['anio_manual']);
$version = !empty($_POST['version']) ? trim($_POST['version']) : '1.0';
$descripcion = !empty($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
$id_usuario = $_SESSION['id'];
$fecha_subida = date('Y-m-d H:i:s');

// Validar datos requeridos
if (empty($id_cole) || empty($anio_manual)) {
    die("Error: Datos requeridos faltantes.");
}

// Validar archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    die("Error: No se pudo subir el archivo.");
}

$archivo = $_FILES['archivo'];
$nombre_original = $archivo['name'];
$tmp_name = $archivo['tmp_name'];
$size = $archivo['size'];
$type = $archivo['type'];

// Validar tipo de archivo
$tipos_permitidos = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
if (!in_array($type, $tipos_permitidos)) {
    die("Error: Tipo de archivo no permitido. Solo se permiten PDF, DOC y DOCX.");
}

// Validar tamaño (50MB máximo)
$max_size = 50 * 1024 * 1024; // 50MB en bytes
if ($size > $max_size) {
    die("Error: El archivo es demasiado grande. Máximo 50MB permitido.");
}

// Crear nombre de archivo único para evitar duplicados
$extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
$nombre_archivo = "Manual_Convivencia_{$anio_manual}_" . date('YmdHis') . "." . $extension;

// Crear directorio si no existe
$directorio = "files/{$id_cole}/{$anio_manual}/";
if (!file_exists($directorio)) {
    if (!mkdir($directorio, 0777, true)) {
        die("Error: No se pudo crear el directorio de destino.");
    }
}

// Ruta completa del archivo
$ruta_archivo = $directorio . $nombre_archivo;

// Verificar si ya existe un manual para este año (opcional: permitir múltiples versiones)
$check_sql = "SELECT id FROM manual_convivencia WHERE id_cole = ? AND anio_manual = ?";
$check_stmt = $mysqli->prepare($check_sql);
$check_stmt->bind_param("ii", $id_cole, $anio_manual);
$check_stmt->execute();
$existing = $check_stmt->get_result();

if ($existing->num_rows > 0) {
    // Ya existe un manual para este año, podemos permitir múltiples versiones o reemplazar
    // Por ahora permitiremos múltiples versiones
}

// Mover archivo al directorio de destino
if (move_uploaded_file($tmp_name, $ruta_archivo)) {
    // Guardar información en la base de datos
    $sql = "INSERT INTO manual_convivencia (id_cole, anio_manual, nombre_archivo, nombre_original, version, descripcion, ruta_archivo, `tamano_archivo`, fecha_subida, id_usuario) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iisssssssi", $id_cole, $anio_manual, $nombre_archivo, $nombre_original, $version, $descripcion, $ruta_archivo, $size, $fecha_subida, $id_usuario);
        
        if ($stmt->execute()) {
            // Éxito - Redireccionar con SweetAlert
            $mensaje_exito = true;
            $stmt->close();
            $mysqli->close();
            
            // Mostrar SweetAlert y redireccionar
            ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Manual Subido Exitosamente</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f8f9fa;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        margin: 0;
                    }
                    .loading {
                        text-align: center;
                        color: #28a745;
                    }
                </style>
            </head>
            <body>
                <div class="loading">
                    <h2>🎉 ¡Manual subido exitosamente!</h2>
                    <p>Redirigiendo...</p>
                </div>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Exito!',
                            html: `
                                <div style="text-align: left; margin: 20px 0;">
                                    <h4>Manual de Convivencia subido exitosamente</h4>
                                    <hr>
                                    <p><strong>📄 Archivo:</strong> <?php echo htmlspecialchars($nombre_original); ?></p>
                                    <p><strong>🔢 Version:</strong> <?php echo htmlspecialchars($version); ?></p>
                                    <p><strong>🕒 Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($fecha_subida)); ?></p>
                                    <?php if (!empty($descripcion)): ?>
                                        <p><strong>📝 Descripcion:</strong> <?php echo htmlspecialchars($descripcion); ?></p>
                                    <?php endif; ?>
                                </div>
                            `,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#007bff',
                            confirmButtonText: '📋 Ver todos los manuales',
                            cancelButtonText: '➕ Subir otro manual',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            width: '600px',
                            customClass: {
                                popup: 'swal-wide'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Ir a ver todos los manuales
                                window.location.href = 'manualConvivencia.php?mensaje=subido';
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                // Subir otro manual
                                window.location.href = 'subirManual.php';
                            }
                        });
                        
                        // Auto-redirect después de 10 segundos si no hay acción
                        setTimeout(function() {
                            window.location.href = 'manualConvivencia.php?mensaje=subido';
                        }, 10000);
                    });
                </script>
            </body>
            </html>
            <?php
            exit;
        } else {
            // Error al guardar en base de datos, eliminar archivo subido
            unlink($ruta_archivo);
            $error_message = "Error al guardar en la base de datos: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Error al preparar consulta, eliminar archivo subido
        unlink($ruta_archivo);
        $error_message = "Error al preparar la consulta: " . $mysqli->error;
    }
} else {
    $error_message = "Error: No se pudo mover el archivo al directorio de destino.";
}

// Si llegamos aquí, hubo un error
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error al subir Manual</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .error-loading {
            text-align: center;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="error-loading">
        <h2>❌ Error al subir el manual</h2>
        <p>Redirigiendo...</p>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '❌ Error',
                html: `
                    <div style="text-align: left; margin: 20px 0;">
                        <h4>No se pudo subir el manual de convivencia</h4>
                        <hr>
                        <p><strong>Error:</strong> <?php echo htmlspecialchars($error_message ?? 'Error desconocido'); ?></p>
                        <p><strong>Archivo:</strong> <?php echo htmlspecialchars($nombre_original ?? 'No especificado'); ?></p>
                        <p><strong>Año:</strong> <?php echo htmlspecialchars($anio_manual ?? 'No especificado'); ?></p>
                    </div>
                `,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '🔄 Intentar nuevamente',
                cancelButtonText: '🏠 Ir al inicio',
                allowOutsideClick: false,
                allowEscapeKey: false,
                width: '600px'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Intentar nuevamente
                    window.location.href = 'subirManual.php';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Ir al inicio
                    window.location.href = '../ie/showIe.php';
                }
            });
            
            // Auto-redirect después de 8 segundos si no hay acción
            setTimeout(function() {
                window.location.href = 'subirManual.php';
            }, 8000);
        });
    </script>
</body>
</html>
