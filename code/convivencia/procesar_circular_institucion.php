<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['id'];
    $id_cole = $_SESSION['id_cole'];
    $circular_id = intval($_POST['circular_id']);
    $accion = $_POST['accion'];

    // Helper local para comprobar admin (acepta 'admin' o '3')
    function isAdminLocal($t) { return ($t === 'admin' || $t === '3' || $t === 3 || $t === 'ADMIN'); }
    
    // Validar que la circular existe y está activa
    $sql_circular = "SELECT * FROM circulares WHERE id = $circular_id AND estado = 'activa'";
    $result_circular = mysqli_query($mysqli, $sql_circular);
    
    if (mysqli_num_rows($result_circular) == 0) {
        echo json_encode(['success' => false, 'message' => 'Circular no válida o inactiva']);
        exit();
    }
    
    try {
        if ($accion == 'subir_archivo') {
            // Validar que se subió un archivo
            if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] != UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'message' => 'Error al subir el archivo']);
                exit();
            }
            
            $archivo = $_FILES['archivo'];
            $nombre_original = $archivo['name'];
            $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
            $tamaño = $archivo['size'];
            
            // Validar extensión
            $extensiones_permitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
            if (!in_array($extension, $extensiones_permitidas)) {
                echo json_encode(['success' => false, 'message' => 'Formato de archivo no permitido']);
                exit();
            }
            
            // Validar tamaño (10MB)
            if ($tamaño > 10 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'El archivo excede el tamaño máximo de 10MB']);
                exit();
            }
            
            // Crear directorio si no existe
            $directorio_base = '../../uploads/circulares/';
            $directorio_circular = $directorio_base . $circular_id . '/';
            $directorio_institucion = $directorio_circular . $id_cole . '/';
            
            if (!file_exists($directorio_base)) {
                mkdir($directorio_base, 0755, true);
            }
            if (!file_exists($directorio_circular)) {
                mkdir($directorio_circular, 0755, true);
            }
            if (!file_exists($directorio_institucion)) {
                mkdir($directorio_institucion, 0755, true);
            }
            
            // Generar nombre único para el archivo
            $nombre_archivo = time() . '_' . $id_cole . '.' . $extension;
            $ruta_completa = $directorio_institucion . $nombre_archivo;
            $ruta_relativa = 'uploads/circulares/' . $circular_id . '/' . $id_cole . '/' . $nombre_archivo;
            
            // Mover archivo
            if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
                // Verificar si ya existe un registro para esta institución y circular
                $sql_check = "SELECT id FROM circular_instituciones WHERE circular_id = $circular_id AND id_cole = $id_cole";
                $result_check = mysqli_query($mysqli, $sql_check);
                
                $nombre_original_esc = mysqli_real_escape_string($mysqli, $nombre_original);
                $ruta_relativa_esc = mysqli_real_escape_string($mysqli, $ruta_relativa);
                $extension_esc = mysqli_real_escape_string($mysqli, $extension);
                
                if (mysqli_num_rows($result_check) > 0) {
                    // Actualizar registro existente
                    $sql = "UPDATE circular_instituciones SET 
                            nombre_archivo = '$nombre_original_esc',
                            ruta_archivo = '$ruta_relativa_esc',
                            tipo_archivo = '$extension_esc',
                            tamaño_archivo = $tamaño,
                            estado_institucion = 'enviado',
                            fecha_actualizacion = CURRENT_TIMESTAMP,
                            usuario_subida = $id_usuario
                            WHERE circular_id = $circular_id AND id_cole = $id_cole";
                } else {
                    // Crear nuevo registro
                    $sql = "INSERT INTO circular_instituciones 
                            (circular_id, id_cole, nombre_archivo, ruta_archivo, tipo_archivo, tamaño_archivo, 
                             estado_institucion, usuario_subida) 
                            VALUES ($circular_id, $id_cole, '$nombre_original_esc', '$ruta_relativa_esc', 
                                   '$extension_esc', $tamaño, 'enviado', $id_usuario)";
                }
                
                if (mysqli_query($mysqli, $sql)) {
                    echo json_encode(['success' => true, 'message' => 'Archivo subido correctamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al guardar la información del archivo: ' . mysqli_error($mysqli)]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al mover el archivo al servidor']);
            }
            
        } elseif ($accion == 'guardar_observaciones') {
            $observaciones = mysqli_real_escape_string($mysqli, $_POST['observaciones']);
            
            // Verificar si ya existe un registro para esta institución y circular
            $sql_check = "SELECT id FROM circular_instituciones WHERE circular_id = $circular_id AND id_cole = $id_cole";
            $result_check = mysqli_query($mysqli, $sql_check);
            
            if (mysqli_num_rows($result_check) > 0) {
                // Actualizar registro existente
                $sql = "UPDATE circular_instituciones SET 
                        observaciones = '$observaciones',
                        fecha_actualizacion = CURRENT_TIMESTAMP
                        WHERE circular_id = $circular_id AND id_cole = $id_cole";
            } else {
                // Crear nuevo registro
                $sql = "INSERT INTO circular_instituciones 
                        (circular_id, id_cole, observaciones, estado_institucion) 
                        VALUES ($circular_id, $id_cole, '$observaciones', 'pendiente')";
            }
            
            if (mysqli_query($mysqli, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Observaciones guardadas correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar las observaciones: ' . mysqli_error($mysqli)]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

mysqli_close($mysqli);
?>