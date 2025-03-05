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
    // Llama a la función para verificar si el colegio tiene archivos en sus mallas curriculares
    $tieneArchivosMallasColegio = tieneArchivosMallasColegio($id_cole, $mysqli);

    // Muestra el resultado de si el colegio tiene archivos o no en una celda
    // echo "<td>" . ($tieneArchivosMallasColegio ? "Sí" : "No") . "</td>";

    // Inicializa una variable para almacenar las celdas de las mallas y archivos
    $mallasYArchivos = "";

    // Luego, recorre todas las mallas curriculares y muestra sus archivos
    $sql = "SELECT * FROM `mallas_curriculares` WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_mc = $row['id_mc'];

            // Llama a la función para mostrar la lista de archivos de la malla
            $archivosMalla = mostrarListaArchivosMallas($id_mc);

            // Agrega la información de la malla y archivos a la variable
            $mallasYArchivos .= "Malla $id_mc: $archivosMalla";
            
        }
    } else {
        // Si no hay mallas curriculares, muestra un mensaje
        $mallasYArchivos = "No hay mallas curriculares disponibles";
    }

    // Muestra las celdas de mallas y archivos en una sola celda
    return $mallasYArchivos;
}



?>