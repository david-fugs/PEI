<?php

function tieneArchivosPlanesProyectos($id_proy_trans) {
    $path = "./../plans/files/" . $id_proy_trans;

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

function tienePlanesProyectos($id_cole, $mysqli) {

    $sql = "SELECT * FROM `proyectos_planes` WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    
   
    if (mysqli_num_rows($result) > 0) {
       
        $archivoPlanesProyectos = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $id_proy_plan = $row['id_proy_plan'];
            if (tieneArchivosTransversales($id_proy_plan)) {
                $archivoPlanesProyectos = true;
                
                break;
            }
        }
    
    } else {
        $archivoPlanesProyectos = false;
    }
    return $archivoPlanesProyectos;
}

function mostrarListaArchivosPlanesProyectos($id_proy_trans) {
    $path = "./../plans/files/" . $id_proy_trans;
    $html = "<ol>";
    if (file_exists($path)) {
        $directorio = opendir($path);
        $nro = 0;
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                $archivoPath = $path . "/" . $archivo;
                $nro++;
                $html .= "<a href='" . $archivoPath . "' title='Ver/Archivo' target='_blank'>".$nro."-" . $archivo . "</a><br>";
            }
        }
        closedir($directorio);
    } else {
       
        $html .= "Sin archivos cargados";
    }

    $html .= "</ol>";

    return $html;
}



function mostrarArchivosPlanesProyectos($id_cole, $mysqli) {
    $planesProyectosArchivos = ""; // Inicializamos una cadena vacía
    $sql = "SELECT * FROM `proyectos_planes` WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_proy_plan = $row['id_proy_plan'];
           
            $archivosProyecto = mostrarListaArchivosPlanesProyectos($id_proy_plan);
            if (!empty($archivosProyecto)) {
                // Agregamos los archivos del proyecto actual a la cadena
                $planesProyectosArchivos .= "Plan o proyecto $id_proy_plan: $archivosProyecto<br>";
            }
        }
    } else {
        $planesProyectosArchivos = "No hay proyectos disponibles";
    }

    return $planesProyectosArchivos;
}



