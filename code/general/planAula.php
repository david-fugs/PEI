<?php

function tieneArchivosPlanAula($id_plan_aula) {
    $path = "./../initial/aula/files/" . $id_plan_aula;

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

function tienePlanAula($id_cole, $mysqli) {

    $sql = "SELECT * FROM plan_aula WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    
   
    if (mysqli_num_rows($result) > 0) {
       
        $tienePlanAula = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $id_plan_aula = $row['id_plan_aula'];
            if (tieneArchivosPlanAula($id_plan_aula)) {
                $tienePlanAula = true;
                
                break;
            }
        }
    
    } else {
        $tienePlanAula = false;
    }
    return $tienePlanAula;
}

function mostrarListaPlanAula($id_plan_aula) {
    $path = "./../initial/aula/files/" . $id_plan_aula;
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



function mostrarArchivosPlanAula($id_cole, $mysqli) {
    $planesProyectosArchivos = ""; // Inicializamos una cadena vacía
    $sql = "SELECT * FROM plan_aula WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_plan_aula = $row['id_plan_aula'];
           
            $archivosPlanAula = mostrarListaPlanAula($id_plan_aula);
            if (!empty($archivosPlanAula)) {
                
                $planesProyectosArchivos .= "Plan de Aula $id_plan_aula: $archivosPlanAula<br>";
            }
        }
    } else {
        $planesProyectosArchivos = "No hay planes de aula disponibles";
    }

    return $planesProyectosArchivos;
}