<?php 


function tieneArchivosTeologico($id_cole) {
    $path = "./../teleologico/files/" . $id_cole;

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



function mostrarListaArchivos($id_cole) {
    $path = "./../teleologico/files/" . $id_cole;
    $html = "<td class='oculto'>";

    // Si hay archivos, muestra la lista de archivos con enlaces para ver o descargar
    if (file_exists($path)) {
        $directorio = opendir($path);
        $html .= "<ol>";

        $nro = 0;
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                $archivoPath = $path . "/" . $archivo;
                $nro++;
                $html .= "<a href='" . $archivoPath . "' title='Ver/Archivo' target='_blank'>".$nro."-" . $archivo . "</a><br>";
            }
        }
        $html .= "</ol>";
        closedir($directorio);
    } else {
        // Si no hay archivos, muestra "Sin archivos cargados"
        $html .= "Sin archivos cargados";
    }

    $html .= "</td>";

    return $html;
}




?>