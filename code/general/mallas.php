<?php 


function tieneArchivosMallasColegio($id_cole, $mysqli) {

    $sql = "SELECT * FROM `mallas_curriculares` WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    
    // Verifica si hay mallas curriculares
    if (mysqli_num_rows($result) > 0) {
        // Inicializa una variable para verificar si al menos una malla tiene archivos
        $tieneArchivosMallas = false;
    
        // Recorre todas las mallas curriculares
        while ($row = mysqli_fetch_assoc($result)) {
            $id_mc = $row['id_mc'];
    
            // Llama a la función para verificar si la malla tiene archivos
            if (tieneArchivosMallas($id_mc)) {
                $tieneArchivosMallas = true;
                // Si al menos una malla tiene archivos, puedes detener el bucle
                break;
            }
        }
    
    } else {
        $tieneArchivosMallas = false;
    }
    return $tieneArchivosMallas;
}

// Función para verificar si una malla curricular tiene archivos
function tieneArchivosMallas($id_mc) {
    $path = "./../mallas/files/" . $id_mc;

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



function mostrarListaArchivosMallas($id_mc) {
    $path = "./../mallas/files/" . $id_mc;

    $html = "<ul>";

    // Si hay archivos, muestra la lista de archivos con enlaces para ver o descargar
    if (file_exists($path)) {
        $directorio = opendir($path);
        // $html .= "<ul>";
        $nro = 0;
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                $archivoPath = $path . "/" . $archivo;
                $nro++;
                $html .= "<a href='" . $archivoPath . "' title='Ver/Archivo' target='_blank'>".$nro."-" . $archivo . "</a><br>";
            }
        }

        // $html .= "</ul>";
        closedir($directorio);
    } else {
        // Si no hay archivos, muestra "Sin archivos cargados"
        $html .= "Sin archivos cargados";
    }

    $html .= "</ul>";
   

    return $html;
}



function mostrarMallasYArchivos($id_cole, $mysqli) {
    include_once("archivosHelper.php");
    
    $sql = "SELECT * FROM `mallas_curriculares` WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) == 0) {
        return "No hay mallas curriculares disponibles";
    }
    
    $allContent = "";
    $totalArchivos = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id_mc = $row['id_mc'];
        
        // Contar archivos reales
        $path = "./../mallas/files/" . $id_mc;
        $numArchivos = 0;
        $archivosHtml = "";
        
        if (file_exists($path)) {
            $directorio = opendir($path);
            $nro = 0;
            while ($archivo = readdir($directorio)) {
                if (!is_dir($archivo)) {
                    $archivoPath = $path . "/" . $archivo;
                    $nro++;
                    $numArchivos++;
                    $archivosHtml .= "<div style='margin-bottom:5px;'><a href='" . $archivoPath . "' title='Ver/Archivo' target='_blank'>".($nro)."-" . $archivo . "</a></div>";
                }
            }
            closedir($directorio);
        }
        
        // Solo agregar si hay archivos reales
        if ($numArchivos > 0) {
            $totalArchivos += $numArchivos;
            $allContent .= "<div style='margin-bottom:8px;'><strong>Malla $id_mc:</strong> $archivosHtml</div>";
        }
    }
    
    // Si no hay archivos en ninguna malla
    if ($totalArchivos == 0) {
        return "Sin archivos cargados";
    }
    
    // Usar el helper para generar el HTML colapsable
    return generarArchivosColapsables($allContent, $totalArchivos, $id_cole, 'mallas');
}



?>