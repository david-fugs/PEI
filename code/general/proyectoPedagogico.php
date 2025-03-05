<?php
function obtenerArchivosProyecto($id_cole, $nroProject) {
    $archivos = array(); // Inicializar el array de archivos

    $directorio = './../proyect_transv/projectFiles/' . $id_cole . '/' . $nroProject;

    if (is_dir($directorio)) {
        $archivos = scandir($directorio);
        $archivos = array_diff($archivos, array('.', '..'));
    }
   

    return $archivos;
}


function mostrarArchivosDeProyectos($id_cole, $mysqli) {
    $sql = "SELECT * FROM proyec_pedag_transv WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $resultados = "Archivos Cargados para los Proyectos:<br>";

        while ($row = mysqli_fetch_assoc($result)) {
            $nameProject = $row['selec_proyec_transv'];
            $nroProject = obtenerNumeroProyecto($nameProject); // Función para obtener el número de proyecto

            $archivos = obtenerArchivosProyecto($id_cole, $nroProject);

            $resultados .= "$nameProject<br>";
            $path = './../proyect_transv/projectFiles/' . $id_cole . '/' . $nroProject;
           

            if (empty($archivos)) {
                $resultados .= "Sin archivos cargados<br>";
            } else {
                foreach ($archivos as $archivo) {
                    $resultados .= "<a href='$path/$archivo' target='_blank'>$archivo</a><br>";
                }
            }
        }
    } else {
        $resultados = "No se encontraron proyectos para este colegio.";
    }

    return $resultados;
}


function obtenerNumeroProyecto($nameProject) {
    // Implementa aquí la lógica para asignar el número de proyecto en función del nombre.
    // Por ejemplo, puedes usar un switch similar al que tenías en tu código original.
    switch ($nameProject) {
        case "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC":
            return 1;
        case "PROYECTO DE EDUCACIÓN AMBIENTAL PRAE":
            return 2;
        case "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS":
            return 3;
        case "PROYECTO DE EDUCACION VIAL":
            return 4;
        default:
            return 0; // Valor por defecto si no se encuentra un número válido.
    }
}

function obtenerArchivosDeProyectos($id_cole, $mysqli) {
    $resultados = ""; // Inicializamos una cadena vacía

    $sql = "SELECT * FROM proyec_pedag_transv WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
       

        while ($row = mysqli_fetch_assoc($result)) {
            $nameProject = $row['selec_proyec_transv'];
            $nroProject = obtenerNumeroProyecto($nameProject); // Función para obtener el número de proyecto

            $archivos = obtenerArchivosProyecto($id_cole, $nroProject);

            $resultados .= "$nameProject:";
            
            if (empty($archivos)) {
                $resultados .= " Sin archivos cargados";
            } else {
               
                foreach ($archivos as $archivo) {
                    $resultados .= "<a href='$archivo' target='_blank'>$archivo</a>";
                }
                
            }
            
           
        }

        
    } else {
        $resultados .= "No se encontraron proyectos para este colegio.";
    }

    return $resultados;
}

function tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli) {
     // Inicializa una variable para contar cuántos proyectos tienen archivos.
    $proyectosConArchivos = 0;

     // Itera a través de los cuatro proyectos posibles (números del 1 al 4).
    for ($i = 1; $i <= 4; $i++) {
         // Verifica si el proyecto actual ($i) tiene archivos usando la función tieneArchivosProyecto.
        if (tieneArchivosProyecto($id_cole, $i, $mysqli)) {
            $proyectosConArchivos++;
        }
    }

     // Compara si el contador de proyectos con archivos es igual a 4 (todos los proyectos).
    // Si es igual a 4, significa que todos los proyectos tienen archivos, por lo que devuelve true.
    return $proyectosConArchivos >= 1;
}

function tieneArchivosProyecto($id_cole, $nroProyecto, $mysqli) {
    $directorio = "./../proyect_transv/projectFiles/$id_cole/$nroProyecto/";

    if (is_dir($directorio)) {
        $archivos = scandir($directorio);
        $archivos = array_diff($archivos, array('.', '..'));

        return count($archivos) > 0;
    }

    return false;
}
