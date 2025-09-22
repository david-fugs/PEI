<?php
// Funciones para validar archivos de Convivencia

function tieneManualConvivencia($id_cole, $mysqli) {
    // Verificar si la tabla existe
    $sql = "SHOW TABLES LIKE 'manual_convivencia'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Verificar qué columnas tiene la tabla
        $sql_describe = "DESCRIBE manual_convivencia";
        $result_describe = mysqli_query($mysqli, $sql_describe);
        $columns = array();
        while ($row = mysqli_fetch_assoc($result_describe)) {
            $columns[] = $row['Field'];
        }
        
        // Determinar qué columna usar para id_cole
        $id_column = '';
        if (in_array('id_cole', $columns)) {
            $id_column = 'id_cole';
        } elseif (in_array('colegio_id', $columns)) {
            $id_column = 'colegio_id';
        } elseif (in_array('institucion_id', $columns)) {
            $id_column = 'institucion_id';
        } elseif (in_array('id_institucion', $columns)) {
            $id_column = 'id_institucion';
        }
        
        if ($id_column) {
            $sql_count = "SELECT COUNT(*) as count FROM manual_convivencia WHERE $id_column = '$id_cole'";
            $result_count = mysqli_query($mysqli, $sql_count);
            if ($result_count) {
                $row = mysqli_fetch_assoc($result_count);
                return $row['count'] > 0;
            }
        } else {
            // Si no hay columna de ID, verificar si hay registros en general
            $sql_count = "SELECT COUNT(*) as count FROM manual_convivencia";
            $result_count = mysqli_query($mysqli, $sql_count);
            if ($result_count) {
                $row = mysqli_fetch_assoc($result_count);
                return $row['count'] > 0;
            }
        }
    }
    return false;
}

function tieneConvivenciaEscolar($id_cole, $mysqli) {
    // Verificar si la tabla existe
    $sql = "SHOW TABLES LIKE 'convivencia_escolar'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Verificar qué columnas tiene la tabla
        $sql_describe = "DESCRIBE convivencia_escolar";
        $result_describe = mysqli_query($mysqli, $sql_describe);
        $columns = array();
        while ($row = mysqli_fetch_assoc($result_describe)) {
            $columns[] = $row['Field'];
        }
        
        // Determinar qué columna usar para id_cole
        $id_column = '';
        if (in_array('id_cole', $columns)) {
            $id_column = 'id_cole';
        } elseif (in_array('colegio_id', $columns)) {
            $id_column = 'colegio_id';
        } elseif (in_array('institucion_id', $columns)) {
            $id_column = 'institucion_id';
        } elseif (in_array('id_institucion', $columns)) {
            $id_column = 'id_institucion';
        }
        
        if ($id_column) {
            $sql_count = "SELECT COUNT(*) as count FROM convivencia_escolar WHERE $id_column = '$id_cole'";
            $result_count = mysqli_query($mysqli, $sql_count);
            if ($result_count) {
                $row = mysqli_fetch_assoc($result_count);
                return $row['count'] > 0;
            }
        } else {
            // Si no hay columna de ID, verificar si hay registros en general
            $sql_count = "SELECT COUNT(*) as count FROM convivencia_escolar";
            $result_count = mysqli_query($mysqli, $sql_count);
            if ($result_count) {
                $row = mysqli_fetch_assoc($result_count);
                return $row['count'] > 0;
            }
        }
    }
    return false;
}

function tieneCircular($id_cole, $mysqli) {
    // Verificar si la tabla existe
    $sql = "SHOW TABLES LIKE 'circulares'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Verificar qué columnas tiene la tabla
        $sql_describe = "DESCRIBE circulares";
        $result_describe = mysqli_query($mysqli, $sql_describe);
        $columns = array();
        while ($row = mysqli_fetch_assoc($result_describe)) {
            $columns[] = $row['Field'];
        }
        
        // Determinar qué columna usar para id_cole
        $id_column = '';
        if (in_array('id_cole', $columns)) {
            $id_column = 'id_cole';
        } elseif (in_array('colegio_id', $columns)) {
            $id_column = 'colegio_id';
        } elseif (in_array('institucion_id', $columns)) {
            $id_column = 'institucion_id';
        } elseif (in_array('id_institucion', $columns)) {
            $id_column = 'id_institucion';
        }
        
        if ($id_column) {
            $sql_count = "SELECT COUNT(*) as count FROM circulares WHERE $id_column = '$id_cole'";
            $result_count = mysqli_query($mysqli, $sql_count);
            if ($result_count) {
                $row = mysqli_fetch_assoc($result_count);
                return $row['count'] > 0;
            }
        } else {
            // Si no hay columna de ID, verificar si hay registros en general
            $sql_count = "SELECT COUNT(*) as count FROM circulares";
            $result_count = mysqli_query($mysqli, $sql_count);
            if ($result_count) {
                $row = mysqli_fetch_assoc($result_count);
                return $row['count'] > 0;
            }
        }
    }
    return false;
}

function mostrarArchivosManualConvivencia($id_cole, $mysqli) {
    // Verificar si la tabla existe
    $sql_check = "SHOW TABLES LIKE 'manual_convivencia'";
    $result_check = mysqli_query($mysqli, $sql_check);
    
    if (mysqli_num_rows($result_check) == 0) {
        return "Tabla no existe";
    }
    
    // Verificar qué columnas tiene la tabla
    $sql_describe = "DESCRIBE manual_convivencia";
    $result_describe = mysqli_query($mysqli, $sql_describe);
    $columns = array();
    while ($row = mysqli_fetch_assoc($result_describe)) {
        $columns[] = $row['Field'];
    }
    
    // Determinar qué columna usar para id_cole
    $id_column = '';
    if (in_array('id_cole', $columns)) {
        $id_column = 'id_cole';
    } elseif (in_array('colegio_id', $columns)) {
        $id_column = 'colegio_id';
    } elseif (in_array('institucion_id', $columns)) {
        $id_column = 'institucion_id';
    } elseif (in_array('id_institucion', $columns)) {
        $id_column = 'id_institucion';
    }
    
    // Construir la consulta según las columnas disponibles
    $select_fields = array();
    if (in_array('archivo', $columns)) $select_fields[] = 'archivo';
    if (in_array('titulo', $columns)) $select_fields[] = 'titulo';
    if (in_array('nombre', $columns)) $select_fields[] = 'nombre';
    if (in_array('descripcion', $columns)) $select_fields[] = 'descripcion';
    if (in_array('ruta_archivo', $columns)) $select_fields[] = 'ruta_archivo';
    
    if (empty($select_fields)) {
        return "No hay campos de archivo disponibles";
    }
    
    $where_clause = $id_column ? "WHERE $id_column = '$id_cole'" : "";
    $sql = "SELECT " . implode(', ', $select_fields) . " FROM manual_convivencia $where_clause";
    $result = mysqli_query($mysqli, $sql);
    $archivos = "";
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
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
                $titulo_campo = 'Manual de Convivencia';
            }
            
            if (!empty($archivo_campo)) {
                $archivos .= "<a href='../convivencia/" . htmlspecialchars($archivo_campo) . "' target='_blank'>" . 
                           htmlspecialchars($titulo_campo) . "</a><br>";
            } else {
                $archivos .= htmlspecialchars($titulo_campo) . " (Registrado)<br>";
            }
        }
    }
    
    return $archivos ?: "No hay archivos";
}

function mostrarArchivosConvivenciaEscolar($id_cole, $mysqli) {
    // Verificar si la tabla existe
    $sql_check = "SHOW TABLES LIKE 'convivencia_escolar'";
    $result_check = mysqli_query($mysqli, $sql_check);
    
    if (mysqli_num_rows($result_check) == 0) {
        return "Tabla no existe";
    }
    
    // Verificar qué columnas tiene la tabla
    $sql_describe = "DESCRIBE convivencia_escolar";
    $result_describe = mysqli_query($mysqli, $sql_describe);
    $columns = array();
    while ($row = mysqli_fetch_assoc($result_describe)) {
        $columns[] = $row['Field'];
    }
    
    // Determinar qué columna usar para id_cole
    $id_column = '';
    if (in_array('id_cole', $columns)) {
        $id_column = 'id_cole';
    } elseif (in_array('colegio_id', $columns)) {
        $id_column = 'colegio_id';
    } elseif (in_array('institucion_id', $columns)) {
        $id_column = 'institucion_id';
    } elseif (in_array('id_institucion', $columns)) {
        $id_column = 'id_institucion';
    }
    
    // Construir la consulta según las columnas disponibles
    $select_fields = array();
    if (in_array('archivo', $columns)) $select_fields[] = 'archivo';
    if (in_array('titulo', $columns)) $select_fields[] = 'titulo';
    if (in_array('nombre', $columns)) $select_fields[] = 'nombre';
    if (in_array('descripcion', $columns)) $select_fields[] = 'descripcion';
    if (in_array('ruta_archivo', $columns)) $select_fields[] = 'ruta_archivo';
    
    if (empty($select_fields)) {
        return "No hay campos de archivo disponibles";
    }
    
    $where_clause = $id_column ? "WHERE $id_column = '$id_cole'" : "";
    $sql = "SELECT " . implode(', ', $select_fields) . " FROM convivencia_escolar $where_clause";
    $result = mysqli_query($mysqli, $sql);
    $archivos = "";
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
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
                $titulo_campo = 'Convivencia Escolar';
            }
            
            if (!empty($archivo_campo)) {
                $archivos .= "<a href='../convivencia/" . htmlspecialchars($archivo_campo) . "' target='_blank'>" . 
                           htmlspecialchars($titulo_campo) . "</a><br>";
            } else {
                $archivos .= htmlspecialchars($titulo_campo) . " (Registrado)<br>";
            }
        }
    }
    
    return $archivos ?: "No hay archivos";
}

function mostrarArchivosCircular($id_cole, $mysqli) {
    // Verificar si la tabla existe
    $sql_check = "SHOW TABLES LIKE 'circulares'";
    $result_check = mysqli_query($mysqli, $sql_check);
    
    if (mysqli_num_rows($result_check) == 0) {
        return "Tabla no existe";
    }
    
    // Verificar qué columnas tiene la tabla
    $sql_describe = "DESCRIBE circulares";
    $result_describe = mysqli_query($mysqli, $sql_describe);
    $columns = array();
    while ($row = mysqli_fetch_assoc($result_describe)) {
        $columns[] = $row['Field'];
    }
    
    // Determinar qué columna usar para id_cole
    $id_column = '';
    if (in_array('id_cole', $columns)) {
        $id_column = 'id_cole';
    } elseif (in_array('colegio_id', $columns)) {
        $id_column = 'colegio_id';
    } elseif (in_array('institucion_id', $columns)) {
        $id_column = 'institucion_id';
    } elseif (in_array('id_institucion', $columns)) {
        $id_column = 'id_institucion';
    }
    
    // Construir la consulta según las columnas disponibles
    $select_fields = array();
    if (in_array('archivo', $columns)) $select_fields[] = 'archivo';
    if (in_array('titulo', $columns)) $select_fields[] = 'titulo';
    if (in_array('nombre', $columns)) $select_fields[] = 'nombre';
    if (in_array('descripcion', $columns)) $select_fields[] = 'descripcion';
    if (in_array('ruta_archivo', $columns)) $select_fields[] = 'ruta_archivo';
    if (in_array('nombre_archivo', $columns)) $select_fields[] = 'nombre_archivo';
    
    if (empty($select_fields)) {
        return "No hay campos de archivo disponibles";
    }
    
    $where_clause = $id_column ? "WHERE $id_column = '$id_cole'" : "";
    $sql = "SELECT " . implode(', ', $select_fields) . " FROM circulares $where_clause";
    $result = mysqli_query($mysqli, $sql);
    $archivos = "";
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $archivo_campo = '';
            $titulo_campo = '';
            
            // Determinar cuál campo usar para archivo
            if (isset($row['archivo']) && !empty($row['archivo'])) {
                $archivo_campo = $row['archivo'];
            } elseif (isset($row['ruta_archivo']) && !empty($row['ruta_archivo'])) {
                $archivo_campo = $row['ruta_archivo'];
            } elseif (isset($row['nombre_archivo']) && !empty($row['nombre_archivo'])) {
                $archivo_campo = $row['nombre_archivo'];
            }
            
            // Determinar cuál campo usar para título
            if (isset($row['titulo']) && !empty($row['titulo'])) {
                $titulo_campo = $row['titulo'];
            } elseif (isset($row['nombre']) && !empty($row['nombre'])) {
                $titulo_campo = $row['nombre'];
            } elseif (isset($row['descripcion']) && !empty($row['descripcion'])) {
                $titulo_campo = $row['descripcion'];
            } else {
                $titulo_campo = 'Circular';
            }
            
            if (!empty($archivo_campo)) {
                $archivos .= "<a href='../convivencia/uploads/circulares/" . htmlspecialchars($archivo_campo) . "' target='_blank'>" . 
                           htmlspecialchars($titulo_campo) . "</a><br>";
            } else {
                $archivos .= htmlspecialchars($titulo_campo) . " (Registrado)<br>";
            }
        }
    }
    
    return $archivos ?: "No hay archivos";
}
?>