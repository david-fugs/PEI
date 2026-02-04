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
    include_once("archivosHelper.php");
    
    $planesProyectosArchivos = "";
    $totalArchivos = 0;
    $sql = "SELECT * FROM plan_aula WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) == 0) {
        return "No hay planes de aula disponibles";
    }
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id_plan_aula = $row['id_plan_aula'];
        $path = "./../initial/aula/files/" . $id_plan_aula;
        
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
            $planesProyectosArchivos .= "Plan de Aula $id_plan_aula: $archivosHtml<br>";
        }
    }
    
    if ($totalArchivos == 0) {
        return "Sin archivos cargados";
    }

    return generarArchivosColapsables($planesProyectosArchivos, $totalArchivos, $id_cole, 'plan_aula');
}