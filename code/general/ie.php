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
                $html .= "<a href='" . $archivoPath . "' title='Ver Archivo' target='_blank'>".$nro."-" . $archivo . "</a><br>";
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
    $archivosIe = ""; // Inicializamos una cadena vacía
    $sql = "SELECT * FROM colegios WHERE id_cole = '$id_cole'";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nit_cole = $row['nit_cole'];
           
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

    return $archivosIe;
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