<?php

function tieneArchivoIntegral($dllo_integ) {
    $path = "./../initial/integral/files/" . $dllo_integ;

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

function tieneIntegral($id_cole, $mysqli) {

    $sql = "SELECT * FROM dllo_integ WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    
   
    if (mysqli_num_rows($result) > 0) {
       
        $tieneIntegral = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $id_dllo_integ = $row['id_dllo_integ'];
            if (tieneArchivoIntegral($id_dllo_integ)) {
                $tieneIntegral = true;
                
                break;
            }
        }
    
    } else {
        $tieneIntegral = false;
    }
    return $tieneIntegral;
}

function mostrarListaArchivosIntegral($id_dllo_integ) {
    $path = "./../initial/integral/files/" . $id_dllo_integ;
    $html = "<ol>";
    if (file_exists($path)) {
        $directorio = opendir($path);
        $nro = 0;
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                $archivoPath = $path . "/" . $archivo;
                $nro++;
                $html .= "<a href='" . $archivoPath . "' title='Ver/Descargar Archivo' target='_blank'>" .$nro."-". $archivo . "</a><br>";
            }
        }
        closedir($directorio);
    } else {
       
        $html .= "Sin archivos cargados";
    }

    $html .= "</ol>";

    return $html;
}



function mostrarArchivosIntegral($id_cole, $mysqli) {
    include_once("archivosHelper.php");
    
    $IntegralArchivos = "";
    $totalArchivos = 0;
    $sql = "SELECT * FROM dllo_integ WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) == 0) {
        return "No hay seguimiento al desarrollo integral disponible";
    }
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id_dllo_integ = $row['id_dllo_integ'];
        $path = "./../initial/integral/files/" . $id_dllo_integ;
        
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
            $IntegralArchivos .= "Plan o proyecto $id_dllo_integ: $archivosHtml<br>";
        }
    }
    
    if ($totalArchivos == 0) {
        return "Sin archivos cargados";
    }

    return generarArchivosColapsables($IntegralArchivos, $totalArchivos, $id_cole, 'dllo_integ');
}
