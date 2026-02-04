<?php

function tieneArchivosEducacionInicial($id_edu_ini) {
    $path = "./../initial/educa/files/" . $id_edu_ini;

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

function tieneEducacionInicial($id_cole, $mysqli) {

    $sql = "SELECT * FROM educa_inicial WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    
   
    if (mysqli_num_rows($result) > 0) {
       
        $tieneEducacionInicial = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $id_edu_ini = $row['id_edu_ini'];
            if (tieneArchivosEducacionInicial($id_edu_ini)) {
                $tieneEducacionInicial = true;
                
                break;
            }
        }
    
    } else {
        $tieneEducacionInicial = false;
    }
    return $tieneEducacionInicial;
}

function mostrarListaArchivosEducacionInicial($id_edu_ini) {
    $path = "./../initial/educa/files/" . $id_edu_ini;
    $html = "<ol>";
    if (file_exists($path)) {
        $directorio = opendir($path);
        $nro = 0;
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                $archivoPath = $path . "/" . $archivo;
                $nro++;
                $html .= "<a href='" . $archivoPath . "' title='Ver Archivo' target='_blank'>" .$nro."-". $archivo . "</a><br>";
            }
        }
        closedir($directorio);
    } else {
       
        $html .= "Sin archivos cargados";
    }

    $html .= "</ol>";

    return $html;
}



function mostrarArchivosEducacionInicial($id_cole, $mysqli) {
    include_once("archivosHelper.php");
    
    $educacionInicial = "";
    $totalArchivos = 0;
    $sql = "SELECT * FROM educa_inicial WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) == 0) {
        return "No hay registros de educación inicial disponibles";
    }
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id_edu_ini = $row['id_edu_ini'];
        $path = "./../initial/files/" . $id_edu_ini;
        
        // Contar archivos reales
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
            $educacionInicial .= "Educación Inicial $id_edu_ini: $archivosHtml<br>";
        }
    }
    
    if ($totalArchivos == 0) {
        return "Sin archivos cargados";
    }

    return generarArchivosColapsables($educacionInicial, $totalArchivos, $id_cole, 'educa_inicial');
}



