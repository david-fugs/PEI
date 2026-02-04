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
    // Los 4 tipos de archivos requeridos
    $tipos_requeridos = ['conformacion', 'reglamento', 'actas', 'planes_accion'];
    $tipos_encontrados = [];
    
    // Buscar en los directorios de convivencia escolar
    $base_path = "./../convivencia/files/" . $id_cole;
    
    if (!file_exists($base_path)) {
        return false;
    }
    
    // Recorrer los años (subdirectorios)
    $anios = scandir($base_path);
    foreach ($anios as $anio) {
        if ($anio == '.' || $anio == '..') continue;
        
        $path_anio = $base_path . '/' . $anio . '/convivencia_escolar';
        
        if (file_exists($path_anio)) {
            $archivos = scandir($path_anio);
            
            foreach ($archivos as $archivo) {
                if ($archivo == '.' || $archivo == '..') continue;
                
                // Verificar qué tipo de archivo es basándose en el nombre
                foreach ($tipos_requeridos as $tipo) {
                    if (stripos($archivo, $tipo) !== false && !in_array($tipo, $tipos_encontrados)) {
                        $tipos_encontrados[] = $tipo;
                    }
                }
            }
        }
    }
    
    // Retorna true solo si se encontraron los 4 tipos
    return count($tipos_encontrados) >= 4;
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
    include_once("archivosHelper.php");
    
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
    $totalArchivos = 0;
    
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
                $archivos .= "<div style='margin-bottom:5px;'><a href='../convivencia/uploads/circulares/" . htmlspecialchars($archivo_campo) . "' target='_blank'>" . 
                           htmlspecialchars($titulo_campo) . "</a></div>";
                $totalArchivos++;
            } else {
                $archivos .= "<div style='margin-bottom:5px;'>" . htmlspecialchars($titulo_campo) . " (Registrado)</div>";
                $totalArchivos++;
            }
        }
    }
    
    if (empty($archivos)) {
        return "No hay archivos";
    }
    
    return generarArchivosColapsables($archivos, $totalArchivos, $id_cole, 'manual_convivencia');
}

function mostrarArchivosConvivenciaEscolar($id_cole, $mysqli) {
    include_once("archivosHelper.php");
    
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
    $totalArchivos = 0;
    
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
                $archivos .= "<div style='margin-bottom:5px;'><a href='../convivencia/" . htmlspecialchars($archivo_campo) . "' target='_blank'>" . 
                           htmlspecialchars($titulo_campo) . "</a></div>";
                $totalArchivos++;
            } else {
                $archivos .= "<div style='margin-bottom:5px;'>" . htmlspecialchars($titulo_campo) . " (Registrado)</div>";
                $totalArchivos++;
            }
        }
    }
    
    if (empty($archivos)) {
        return "No hay archivos";
    }
    
    return generarArchivosColapsables($archivos, $totalArchivos, $id_cole, 'convivencia_escolar');
}

function mostrarArchivosCircular($id_cole, $mysqli) {
    include_once("archivosHelper.php");
    
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
    $totalArchivos = 0;
    
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
                $archivos .= "<div style='margin-bottom:5px;'><a href='../convivencia/uploads/circulares/" . htmlspecialchars($archivo_campo) . "' target='_blank'>" . 
                           htmlspecialchars($titulo_campo) . "</a></div>";
                $totalArchivos++;
            } else {
                $archivos .= "<div style='margin-bottom:5px;'>" . htmlspecialchars($titulo_campo) . " (Registrado)</div>";
                $totalArchivos++;
            }
        }
    }
    
    if (empty($archivos)) {
        return "No hay archivos";
    }
    
    return generarArchivosColapsables($archivos, $totalArchivos, $id_cole, 'circulares');
}
?>