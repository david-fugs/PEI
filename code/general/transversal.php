<?php

function tieneArchivosTransversales($id_proy_trans) {
    $path = "./../project/files/" . $id_proy_trans;

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





function tieneProyectoTransversal($id_cole,$mysqli){

    $sql = "SELECT * FROM `proyectos_transversales` WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    
   
    if (mysqli_num_rows($result) > 0) {
       
        $tieneArchivosTransversales = false;
    
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id_proy_trans = $row['id_proy_trans'];
            if (tieneArchivosTransversales($id_proy_trans)) {
                $tieneArchivosTransversales = true;
                
                break;
            }
        }
    
    } else {
        $tieneArchivosTransversales = false;
    }
    return $tieneArchivosTransversales;
}


function mostrarListaArchivosTransversales($id_proy_trans) {
    $path = "./../project/files/" . $id_proy_trans;
    $html = "<ol>";

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

    $html .= "</ol>";

    return $html;
}


function mostrarArchivosTransversales($id_cole, $mysqli) {
    $transversalesArchivos = "";

    // Luego, recorre todas las mallas curriculares y muestra sus archivos
    $sql = "SELECT * FROM `proyectos_transversales` WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_proy_trans = $row['id_proy_trans'];

            // Llama a la función para mostrar la lista de archivos de la malla
            $archivosTransversales = mostrarListaArchivosTransversales($id_proy_trans);

            // Agrega la información de la malla y archivos a la variable
            $transversalesArchivos .= "proyecto transversal $id_proy_trans: $archivosTransversales";
            
        }
    } else {
        // Si no hay mallas curriculares, muestra un mensaje
        $transversalesArchivos = "No hay proyectos transversales disponibles";
    }

    // Muestra las celdas de mallas y archivos en una sola celda
    return $transversalesArchivos;
}


?>
