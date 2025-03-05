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
    $educacionInicial = ""; // Inicializamos una cadena vacía
    $sql = "SELECT * FROM educa_inicial WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_edu_ini = $row['id_edu_ini'];
           
            $archivosEducacionInicial = mostrarListaArchivosEducacionInicial($id_edu_ini);
            if (!empty($archivosEducacionInicial)) {
              
                $educacionInicial .= "Educacion inicial archivo $id_edu_ini: $archivosEducacionInicial<br>";
            }
        }
    } else {
        $educacionInicial = "No hay proyectos disponibles";
    }

    return $educacionInicial;
}



