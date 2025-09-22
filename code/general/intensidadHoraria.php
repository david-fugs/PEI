<?php
// Funciones para validar Intensidad Horaria Semanal

function tieneIntensidadHoraria($id_cole, $mysqli) {
    // Verificar si existe tabla de intensidad horaria
    $sql = "SHOW TABLES LIKE 'intensidad_horaria'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $sql_count = "SELECT COUNT(*) as count FROM intensidad_horaria WHERE id_cole = '$id_cole'";
        $result_count = mysqli_query($mysqli, $sql_count);
        if ($result_count) {
            $row = mysqli_fetch_assoc($result_count);
            return $row['count'] > 0;
        }
    }
    
    // Verificar si hay archivos en directorio de hours
    $hours_path = "../../uploads/hours/" . $id_cole;
    if (is_dir($hours_path)) {
        $files = scandir($hours_path);
        $valid_files = array_filter($files, function($file) use ($hours_path) {
            return $file !== '.' && $file !== '..' && is_file($hours_path . '/' . $file);
        });
        return count($valid_files) > 0;
    }
    
    return false;
}

function mostrarArchivosIntensidadHoraria($id_cole, $mysqli) {
    $archivos = "";
    
    // Verificar si existe tabla de intensidad horaria
    $sql = "SHOW TABLES LIKE 'intensidad_horaria'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Primero verificar qué columnas tiene la tabla
        $sql_describe = "DESCRIBE intensidad_horaria";
        $result_describe = mysqli_query($mysqli, $sql_describe);
        $columns = array();
        while ($row = mysqli_fetch_assoc($result_describe)) {
            $columns[] = $row['Field'];
        }
        
        // Construir la consulta según las columnas disponibles
        $select_fields = array();
        if (in_array('grado', $columns)) $select_fields[] = 'grado';
        if (in_array('area', $columns)) $select_fields[] = 'area';
        if (in_array('asignatura', $columns)) $select_fields[] = 'asignatura';
        if (in_array('horas', $columns)) $select_fields[] = 'horas';
        if (in_array('archivo', $columns)) $select_fields[] = 'archivo';
        
        if (!empty($select_fields)) {
            $sql_files = "SELECT " . implode(', ', $select_fields) . " FROM intensidad_horaria WHERE id_cole = '$id_cole'";
            $result_files = mysqli_query($mysqli, $sql_files);
            
            if ($result_files) {
                while ($row = mysqli_fetch_assoc($result_files)) {
                    $descripcion = "";
                    if (isset($row['grado'])) $descripcion .= $row['grado'];
                    if (isset($row['area'])) $descripcion .= " - " . $row['area'];
                    if (isset($row['asignatura'])) $descripcion .= " - " . $row['asignatura'];
                    if (isset($row['horas'])) $descripcion .= " (" . $row['horas'] . "h)";
                    
                    if (isset($row['archivo']) && !empty($row['archivo'])) {
                        $archivos .= "<a href='../hours/" . htmlspecialchars($row['archivo']) . "' target='_blank'>" . 
                                   htmlspecialchars($descripcion) . "</a><br>";
                    } else {
                        $archivos .= htmlspecialchars($descripcion) . " (Configurado)<br>";
                    }
                }
            }
        }
    } else {
        // Verificar archivos en directorio
        $hours_path = "../../uploads/hours/" . $id_cole;
        if (is_dir($hours_path)) {
            $files = scandir($hours_path);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && is_file($hours_path . '/' . $file)) {
                    $archivos .= "<a href='../../uploads/hours/" . $id_cole . "/" . htmlspecialchars($file) . "' target='_blank'>" . 
                               htmlspecialchars($file) . "</a><br>";
                }
            }
        }
    }
    
    return $archivos ?: "No hay configuración de intensidad horaria";
}
?>