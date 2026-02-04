<?php

function tieneArchivoIe($nit_cole) {
    $path = "./../ie/files/" . $nit_cole;

    if (file_exists($path)) {
        $directorio = opendir($path);
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                return true;
            }
        }
    }

    return false;
}

function tieneIe($id_cole, $mysqli) {

    $sql = "SELECT * FROM colegios WHERE id_cole = '$id_cole'";

    $result = mysqli_query($mysqli, $sql);
    
   
    if (mysqli_num_rows($result) > 0) {
       
        $tieneIe = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $nit_cole = $row['nit_cole'];
            if (tieneArchivoIe($nit_cole)) {
                $tieneIe = true;
                
                break;
            }
        }
    
    } else {
        $tieneIe = false;
    }
    return $tieneIe;
}

function mostrarListaArchivosIe($nit_cole) {
    $path = "./../ie/files/" . $nit_cole;
    $html = "<ol>";
    if (file_exists($path)) {
        $directorio = opendir($path);
        $nro = 0;
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                $archivoPath = $path . "/" . $archivo;
                $nro++;
                $html .= "<div style='margin-bottom:5px;'><a href='" . $archivoPath . "' title='Ver Archivo' target='_blank'>".($nro)."-" . $archivo . "</a></div>";
            }
        }
        closedir($directorio);
    } else {
       
        $html .= "Sin archivos cargados";
    }

    $html .= "</ol>";

    return $html;
}



function mostrarArchivosIe($id_cole, $mysqli) {
    include_once("archivosHelper.php");
    
    $archivosIe = ""; // Inicializamos una cadena vacía
    $totalArchivos = 0;
    $sql = "SELECT * FROM colegios WHERE id_cole = '$id_cole'";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nit_cole = $row['nit_cole'];
            
            // Contar archivos
            $path = "./../ie/files/" . $nit_cole;
            $totalArchivos += contarArchivosEnDirectorio($path);
           
            $archivosEstablecimiento = mostrarListaArchivosIe($nit_cole);
            if (empty($nit_cole)) {
                $archivosIe .= "Sin NIT registrado: $archivosEstablecimiento<br>";
            } elseif (!empty($archivosEstablecimiento)) {
                $archivosIe .= "NIT $nit_cole: $archivosEstablecimiento<br>";
            }
        }
    } else {
        $archivosIe = "No hay proyectos disponibles";
    }

    return generarArchivosColapsables($archivosIe, $totalArchivos, $id_cole, 'ie');
}



function tieneResolucion($id_cole, $mysqli){
    $sql = "SELECT * FROM colegios WHERE id_cole = '$id_cole'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $num_act_adm_cole = $row['num_act_adm_cole'];
            if ($num_act_adm_cole) {
                return $num_act_adm_cole; 
            }
        }
    }
    
    return false; 
}

// Nueva función: Verifica si tiene archivo de resolución
function tieneArchivoResolucion($id_cole, $mysqli) {
    $sql = "SELECT nit_cole FROM colegios WHERE id_cole = '$id_cole'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nit_cole = $row['nit_cole'];
        $path = "./../ie/files/" . $nit_cole;
        
        if (file_exists($path)) {
            $directorio = opendir($path);
            while ($archivo = readdir($directorio)) {
                if (!is_dir($archivo)) {
                    closedir($directorio);
                    return true;
                }
            }
            closedir($directorio);
        }
    }
    
    return false;
}

// Nueva función: Obtiene la ruta del primer archivo de resolución (para descarga)
function obtenerArchivoResolucion($id_cole, $mysqli) {
    $sql = "SELECT nit_cole FROM colegios WHERE id_cole = '$id_cole'";
    $result = mysqli_query($mysqli, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nit_cole = $row['nit_cole'];
        $path = "./../ie/files/" . $nit_cole;
        
        if (file_exists($path)) {
            $directorio = opendir($path);
            while ($archivo = readdir($directorio)) {
                if (!is_dir($archivo) && $archivo != '.' && $archivo != '..') {
                    closedir($directorio);
                    return "./../ie/files/" . $nit_cole . "/" . $archivo;
                }
            }
            closedir($directorio);
        }
    }
    
    return false;
}

// Nueva función: Verifica si tiene datos en los nuevos campos (ciclos, modelos, especialidades)
function tieneEstablecimientoCompleto($id_cole, $mysqli) {
    $sql = "SELECT tiene_ciclos, ciclo_0, ciclo_1, ciclo_2, ciclo_3, ciclo_4, ciclo_5, ciclo_6, 
            modelo_escuela_nueva, modelo_aceleracion, modelo_post_primaria, modelo_caminar_secundaria, 
            modelo_pensar_secundaria, modelo_media_rural, modelo_pensar_media, modelo_otro, modelo_otro_cual,
            especialidades_tecnica, especialidad_academica 
            FROM colegios WHERE id_cole = '$id_cole'";
    
    $result = mysqli_query($mysqli, $sql);
    
    // Validar que la consulta fue exitosa
    if (!$result) {
        // Si la consulta falla, retornar false
        return false;
    }
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verificar si tiene algún ciclo marcado
        $tieneCiclos = (isset($row['tiene_ciclos']) && $row['tiene_ciclos'] == 1) || 
                       (isset($row['ciclo_0']) && $row['ciclo_0'] == 1) || 
                       (isset($row['ciclo_1']) && $row['ciclo_1'] == 1) || 
                       (isset($row['ciclo_2']) && $row['ciclo_2'] == 1) || 
                       (isset($row['ciclo_3']) && $row['ciclo_3'] == 1) || 
                       (isset($row['ciclo_4']) && $row['ciclo_4'] == 1) || 
                       (isset($row['ciclo_5']) && $row['ciclo_5'] == 1) || 
                       (isset($row['ciclo_6']) && $row['ciclo_6'] == 1);
        
        // Verificar si tiene algún modelo educativo marcado
        $tieneModelos = (isset($row['modelo_escuela_nueva']) && $row['modelo_escuela_nueva'] == 1) || 
                        (isset($row['modelo_aceleracion']) && $row['modelo_aceleracion'] == 1) || 
                        (isset($row['modelo_post_primaria']) && $row['modelo_post_primaria'] == 1) || 
                        (isset($row['modelo_caminar_secundaria']) && $row['modelo_caminar_secundaria'] == 1) || 
                        (isset($row['modelo_pensar_secundaria']) && $row['modelo_pensar_secundaria'] == 1) || 
                        (isset($row['modelo_media_rural']) && $row['modelo_media_rural'] == 1) || 
                        (isset($row['modelo_pensar_media']) && $row['modelo_pensar_media'] == 1) || 
                        (isset($row['modelo_otro']) && $row['modelo_otro'] == 1) || 
                        (isset($row['modelo_otro_cual']) && !empty($row['modelo_otro_cual']) && trim($row['modelo_otro_cual']) != '');
        
        // Verificar si tiene especialidades
        $tieneEspecialidades = (isset($row['especialidades_tecnica']) && !empty($row['especialidades_tecnica']) && trim($row['especialidades_tecnica']) != '') || 
                               (isset($row['especialidad_academica']) && !empty($row['especialidad_academica']) && trim($row['especialidad_academica']) != '');
        
        // Si tiene al menos uno de los tres, retorna true
        return ($tieneCiclos || $tieneModelos || $tieneEspecialidades);
    }
    
    return false;
}