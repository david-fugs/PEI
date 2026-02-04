<?php 


function tieneArchivosSiee($id_cole, $mysqli = null) {
    // Validar que tenga archivos
    $tieneArchivos = false;
    $path = "./../siee/files/" . $id_cole;

    if (file_exists($path)) {
        $directorio = opendir($path);
        while ($archivo = readdir($directorio)) {
            if (!is_dir($archivo)) {
                $tieneArchivos = true;
                break;
            }
        }
        closedir($directorio);
    }

    // Validar que tenga datos en el formulario
    $tieneDatos = false;
    if ($mysqli) {
        $sql = "SELECT * FROM siee WHERE id_cole = '$id_cole'";
        $result = mysqli_query($mysqli, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $tieneDatos = true;
        }
    }

    // Solo retorna true si tiene AMBOS: archivos Y datos
    return ($tieneArchivos && $tieneDatos);
}



function mostrarListaArchivosSiee($id_cole) {
    $path = "./../siee/files/" . $id_cole;
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