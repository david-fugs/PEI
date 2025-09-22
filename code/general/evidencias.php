<?php
// Funciones para validar Evidencias

function tieneEvidencias($id_cole, $mysqli) {
    // Las evidencias pueden ser archivos en una carpeta específica o enlaces externos
    // Por ahora validaremos si hay algún tipo de registro relacionado con evidencias
    
    // Verificar si existe una tabla de evidencias
    $sql = "SHOW TABLES LIKE 'evidencias'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $sql_count = "SELECT COUNT(*) as count FROM evidencias WHERE id_cole = '$id_cole'";
        $result_count = mysqli_query($mysqli, $sql_count);
        if ($result_count) {
            $row = mysqli_fetch_assoc($result_count);
            return $row['count'] > 0;
        }
    }
    
    // Si no hay tabla de evidencias, verificar archivos en directorio
    $evidencias_path = "../../uploads/evidencias/" . $id_cole;
    if (is_dir($evidencias_path)) {
        $files = scandir($evidencias_path);
        $valid_files = array_filter($files, function($file) use ($evidencias_path) {
            return $file !== '.' && $file !== '..' && is_file($evidencias_path . '/' . $file);
        });
        return count($valid_files) > 0;
    }
    
    return false;
}

function mostrarArchivosEvidencias($id_cole, $mysqli) {
    $archivos = "";
    
    // Verificar si existe tabla de evidencias
    $sql = "SHOW TABLES LIKE 'evidencias'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Verificar qué columnas tiene la tabla
        $sql_describe = "DESCRIBE evidencias";
        $result_describe = mysqli_query($mysqli, $sql_describe);
        $columns = array();
        while ($row = mysqli_fetch_assoc($result_describe)) {
            $columns[] = $row['Field'];
        }
        
        // Construir la consulta según las columnas disponibles
        $select_fields = array();
        if (in_array('archivo', $columns)) $select_fields[] = 'archivo';
        if (in_array('titulo', $columns)) $select_fields[] = 'titulo';
        if (in_array('nombre', $columns)) $select_fields[] = 'nombre';
        if (in_array('descripcion', $columns)) $select_fields[] = 'descripcion';
        if (in_array('ruta_archivo', $columns)) $select_fields[] = 'ruta_archivo';
        
        if (!empty($select_fields)) {
            $sql_files = "SELECT " . implode(', ', $select_fields) . " FROM evidencias WHERE id_cole = '$id_cole'";
            $result_files = mysqli_query($mysqli, $sql_files);
            
            if ($result_files) {
                while ($row = mysqli_fetch_assoc($result_files)) {
                    $archivo_campo = '';
                    $titulo_campo = '';
                    
                    // Determinar cuál campo usar para archivo
                    if (isset($row['archivo']) && !empty($row['archivo'])) {
                        $archivo_campo = $row['archivo'];
                    } elseif (isset($row['ruta_archivo']) && !empty($row['ruta_archivo'])) {
                        $archivo_campo = $row['ruta_archivo'];
                    }
                    
                    // Determinar cuál campo usar para título
                    if (isset($row['titulo']) && !empty($row['titulo'])) {
                        $titulo_campo = $row['titulo'];
                    } elseif (isset($row['nombre']) && !empty($row['nombre'])) {
                        $titulo_campo = $row['nombre'];
                    } elseif (isset($row['descripcion']) && !empty($row['descripcion'])) {
                        $titulo_campo = $row['descripcion'];
                    } else {
                        $titulo_campo = 'Evidencia';
                    }
                    
                    if (!empty($archivo_campo)) {
                        $archivos .= "<a href='../evidencias/" . htmlspecialchars($archivo_campo) . "' target='_blank'>" . 
                                   htmlspecialchars($titulo_campo) . "</a><br>";
                    } else {
                        $archivos .= htmlspecialchars($titulo_campo) . " (Registrado)<br>";
                    }
                }
            }
        }
    } else {
        // Verificar archivos en directorio
        $evidencias_path = "../../uploads/evidencias/" . $id_cole;
        if (is_dir($evidencias_path)) {
            $files = scandir($evidencias_path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && is_file($evidencias_path . '/' . $file)) {
                    $archivos .= "<a href='../../uploads/evidencias/" . $id_cole . "/" . htmlspecialchars($file) . "' target='_blank'>" . 
                               htmlspecialchars($file) . "</a><br>";
                }
            }
        }
    }
    
    if (empty($archivos)) {
        $archivos = "Enlaces externos: <a href='https://www.mineducacion.gov.co/portal/men/Publicaciones/Guias/339480:Guia-No-49-Guias-pedagogicas-para-la-convivencia-escolar' target='_blank'>Guía 49 Ministerio de Educación</a>";
    }
    
    return $archivos;
}
?>