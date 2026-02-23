<?php
include("./../../conexion.php");
include("./../../sessionCheck.php");

date_default_timezone_set("America/Bogota");
$fecha = date("d/m/Y");

// Personalizar nombre del archivo según el tipo de usuario
if ($tipo_usuario == "2") {
    // Obtener el nombre de la institución del usuario
    $query_colegio = "SELECT nombre_cole FROM colegios WHERE id_cole = '$id_cole'";
    $result_colegio = mysqli_query($mysqli, $query_colegio);
    $nombre_institucion = "Mi_Institucion";
    if ($result_colegio && $row = mysqli_fetch_assoc($result_colegio)) {
        $nombre_institucion = str_replace(" ", "_", $row['nombre_cole']);
    }
    $filename = "Informe_PEI_" . $nombre_institucion . "_" . $fecha . ".xls";
} else {
    $filename = "Informe cargue de archivos PEI "."-" . $fecha . ".xls";
}

header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . $filename . "");
?>
include("./teologico.php");
include("./mallas.php");
include("./siee.php");
include("./transversal.php");
include("./proyectoPlanes.php");
include("./educacionInicial.php");
include("./planAula.php");
include("./integral.php");
include("./ie.php");
include("./proyectoPedagogico.php");
include("./observacion.php");
include("./convivencia.php");
include("./intensidadHoraria.php");



$consulta = "SELECT * FROM colegios";

// Si el usuario es tipo 2, filtrar automáticamente por su institución
if ($tipo_usuario == "2") {
    $consulta = "SELECT * FROM colegios WHERE id_cole = '$id_cole'";
} elseif (isset($_POST['filtrar'])) {
    $filtro = $_POST['filtro'];
    $consulta = "SELECT * FROM colegios WHERE nombre_cole LIKE '%$filtro%' OR id_cole = '$filtro'";
}

$resultados = mysqli_query($mysqli, $consulta);
echo '<style>
    /* Define tus estilos CSS aquí */
    .verde {
        /* background-color: #c6ffbb; */
        /* color: rgb(14, 2, 2); */
        text-align: center;
    }

    .rojo {
        background-color: #ffc7ce;
        text-align: center;
    }
</style>';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe cargue de archivos PEI</title>
    <style>
    .verde {
        /* background-color: #c6ffbb; */
        /* color: rgb(14, 2, 2); */
         text-align: center;
        }

        .rojo {
        background-color: #ffc7ce;
        text-align: center;
        
        }

        thead {
        position: sticky;
        top: 0;
        background-color: #4472c4;
        text-align: center;
        }

        th {
        background-color: #3498db;
        color: #fff;
        }

        td{
            text-align: center;
            vertical-align: middle;
        }
        
 
    
</style>
    
</head>

<body>

    <div class="container">
    
        <div class="centered-content">
       
       

            <?php
            if ($resultados && mysqli_num_rows($resultados) > 0) {
                echo "<br>";
                echo "<table border>";
                echo "<thead style='text-align: center;'>";
                echo "<tr>";
                echo "<td rowspan='2'><b>ID</b></td>";
                echo "<td rowspan='2'><b>Establecimiento Educativo</b></td>";
                echo "<td class='encabezado encabezado1' colspan='2'><b>INSTITUCIÓN EDUCATIVA</b></td>";
                echo "<td class='encabezado encabezado2' colspan='1'><b>TELEOLÓGICO</b></td>";
                echo "<td class='encabezado encabezado3' colspan='3'><b>PEDAGÓGICO</b></td>";
                echo "<td class='encabezado encabezado4' colspan='3'><b>PLANES-PROGRAMAS-PROYECTOS</b></td>";
                echo "<td class='encabezado encabezado5' colspan='3'><b>PREESCOLAR</b></td>";
                echo "<td class='encabezado encabezado6' colspan='2'><b>CONVIVENCIA</b></td>";
                echo "<td rowspan='2'><b>Observaciones</b></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><b>Resolución</b></td>";
                echo "<td><b>Actualizacion I.E.</b></td>";
                echo "<td><b>Teleológico</b></td>";
                echo "<td><b>Mallas</b></td>";
                echo "<td><b>Intensidad Horaria</b></td>";
                echo "<td><b>SIEE</b></td>";
                echo "<td><b>Transversales</b></td>";
                echo "<td><b>Planes-Programas</b></td>";
                echo "<td><b>Proyectos/Planes</b></td>";
                echo "<td><b>Educación Inicial</b></td>";
                echo "<td><b>Plan Estudios</b></td>";
                echo "<td><b>Desarrollo Integral</b></td>";
                echo "<td><b>Manual Convivencia</b></td>";
                echo "<td><b>Convivencia Escolar</b></td>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                $consecutivo = 1;
                while ($fila = mysqli_fetch_assoc($resultados)) {
                    echo "<tr ALIGN=center>";
                    echo "<td>".$consecutivo."</td>";
                    echo "<td>".$fila['nombre_cole']."</td>";
                    $id_cole = $fila['id_cole'];
                    $iconStyle = "style='width: 40px; height: 40px; max-width: 100%;'";
                    $icon = "./../../../../img/visualizar.png";
                    $icon_excel = "./../../../../img/excel.png";
                
                    //IE
                    $tieneResolucion=tieneArchivoResolucion($id_cole, $mysqli);
                    echo '<td ' . ($tieneResolucion ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneResolucion ? 'Si' : 'No';
                    
                    echo '</td>';

                    $tieneArchivoIe=tieneEstablecimientoCompleto($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivoIe ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivoIe ? 'Si' : 'No';
                    echo '</td>';
                  
                    //Teológico
                    $tieneArchivos = tieneArchivosTeologico($id_cole);
                    echo '<td ' . ($tieneArchivos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivos ? 'Si' : 'No';
                    echo '</td>';

                    //mallas
                    $tieneArchivosMallasColegio=tieneArchivosMallasColegio($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivosMallasColegio ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosMallasColegio ? 'Si' : 'No';
                    echo '</td>';

                    //intensidad horaria
                    $tieneIntensidadHoraria = tieneIntensidadHoraria($id_cole, $mysqli);
                    echo '<td ' . ($tieneIntensidadHoraria ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneIntensidadHoraria ? 'Si' : 'No';
                    echo '</td>';

                    //siee
                    $tieneArchivosSiee = tieneArchivosSiee($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivosSiee ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosSiee ? 'Si' : 'No';
                    echo '</td>';

                    //transversal
                    $tieneProyectoTransversal = tieneProyectoTransversal($id_cole,$mysqli);
                    echo '<td ' . ($tieneProyectoTransversal ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneProyectoTransversal ? 'Si' : 'No';
                    echo '</td>';

                    //proyecto pedagógico (Planes - Programas y Proyectos)
                    $tieneArchivosEnLosCuatro = tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivosEnLosCuatro ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosEnLosCuatro ? 'Si' : 'No';
                    echo '</td>';

                    //proyectos y planes
                    $tienePlanesProyectos = tienePlanesProyectos($id_cole, $mysqli);
                    echo '<td ' . ($tienePlanesProyectos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanesProyectos ? 'Si' : 'No';
                    echo '</td>';

                    //educacion inicial
                    $tieneEducacionInicial = tieneEducacionInicial($id_cole, $mysqli);
                    echo '<td ' . ($tieneEducacionInicial ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneEducacionInicial ? 'Si' : 'No';
                    echo '</td>';

                    //plan aula
                    $tienePlanAula = tienePlanAula($id_cole,$mysqli);
                    echo '<td ' . ($tienePlanAula ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanAula ? 'Si' : 'No';
                    echo '</td>';

                    //seguimiento desarrollo integral
                    $tieneIntegral = tieneIntegral($id_cole,$mysqli);
                    echo '<td ' . ($tieneIntegral ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneIntegral ? 'Si' : 'No';
                    echo '</td>';

                    //manual convivencia
                    $tieneManualConvivencia = tieneManualConvivencia($id_cole, $mysqli);
                    echo '<td ' . ($tieneManualConvivencia ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneManualConvivencia ? 'Si' : 'No';
                    echo '</td>';

                    //convivencia escolar
                    $tieneConvivenciaEscolar = tieneConvivenciaEscolar($id_cole, $mysqli);
                    echo '<td ' . ($tieneConvivenciaEscolar ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneConvivenciaEscolar ? 'Si' : 'No';
                    echo '</td>';

                    $contenido = MostrarInformacionObservacion($id_cole, $mysqli);

                    // Retira cualquier formato HTML y asegúrate de que el contenido sea seguro para Excel
                    $contenidoParaExcel = strip_tags($contenido);
                    
                    // Luego, puedes imprimir el contenido en la celda de Excel
                    echo '<td>' . $contenidoParaExcel . '</td>';
                    
                    echo "</tr>";
                    $consecutivo++;
                }

                echo "</tbody>";
                echo "</table>";
                ?>
                 <br>
                 <br>
                <?php

                //reportes generales

                $modulo1Cargado = 0;
                $modulo2Cargado = 0;
                $modulo3Cargado = 0;
                $modulo4Cargado = 0;
                $modulo5Cargado = 0;
                $modulo6Cargado = 0;
                $totalCargados = 0;
                $colegiosTotales = 0;

                $colegios = "SELECT * FROM colegios";
                $todos = mysqli_query($mysqli, $colegios);

                if ($todos && mysqli_num_rows($todos) > 0) {
                    while ($fila = mysqli_fetch_assoc($todos)) {
                        // Obtener los valores de $tieneResolucion y $tieneArchivoIe para cada colegio
                        $id_cole = $fila['id_cole'];
                        //IE

                        $tieneResolucion = tieneArchivoResolucion($id_cole, $mysqli);
                        $resolucionText = $tieneResolucion ? 'Si' : 'No';

                        $tieneArchivoIe=tieneEstablecimientoCompleto($id_cole, $mysqli);
                        $establecimientoText = $tieneArchivoIe ? 'Si' : 'No';

                        //Teológico
                        $tieneArchivos = tieneArchivosTeologico($id_cole);
                        $teologicoText = $tieneArchivos ? 'Si' : 'No';

                        //Pedagígico|mallas
                        $tieneArchivosMallasColegio=tieneArchivosMallasColegio($id_cole, $mysqli);
                        $mallasText = $tieneArchivosMallasColegio ? 'Si' : 'No';

                        $tieneArchivosSiee = tieneArchivosSiee($id_cole, $mysqli);
                        $sieeText = $tieneArchivosSiee ? 'Si' : 'No';

                        //planes|proyectos
                        $tieneProyectoTransversal = tieneProyectoTransversal($id_cole,$mysqli);
                        $transversalText = $tieneProyectoTransversal ? 'Si' : 'No';

                        $tienePlanesProyectos = tienePlanesProyectos($id_cole, $mysqli);
                        $planesText = $tienePlanesProyectos ? 'Si' : 'No';

                        //proyectos pedagógicos
                        $tieneArchivosEnLosCuatro =tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli);
                        $cuatroText = $tieneArchivosEnLosCuatro ? 'Si' : 'No';

                        //intensidad horaria
                        $tieneIntensidadHoraria = tieneIntensidadHoraria($id_cole, $mysqli);
                        $intensidadText = $tieneIntensidadHoraria ? 'Si' : 'No';

                        //transición
                        $tieneEducacionInicial = tieneEducacionInicial($id_cole, $mysqli);
                        $educacionText = $tieneEducacionInicial ? 'Si' : 'No';

                        $tienePlanAula = tienePlanAula($id_cole,$mysqli);
                        $planAulaText = $tienePlanAula ? 'Si' : 'No';

                        $tieneIntegral = tieneIntegral($id_cole,$mysqli);
                        $integralText = $tieneIntegral ? 'Si' : 'No';

                        //convivencia
                        $tieneManualConvivencia = tieneManualConvivencia($id_cole, $mysqli);
                        $manualConvivenciaText = $tieneManualConvivencia ? 'Si' : 'No';

                        $tieneConvivenciaEscolar = tieneConvivenciaEscolar($id_cole, $mysqli);
                        $convivenciaEscolarText = $tieneConvivenciaEscolar ? 'Si' : 'No';

                        // Módulo 1 I.E
                        if ($resolucionText != 'No' && $establecimientoText != 'No') {
                            $modulo1Cargado++;
                        }
                        if ($teologicoText != 'No') {
                            $modulo2Cargado++;
                        }
                        if ($mallasText != 'No' && $sieeText != 'No') {
                            $modulo3Cargado++;
                        }
                        if ($transversalText != 'No' && $planesText != 'No' && $cuatroText  != 'No' && $intensidadText != 'No') {
                            $modulo4Cargado++;
                        }

                        if ($educacionText != 'No' && $planAulaText != 'No' && $integralText != 'No') {
                            $modulo5Cargado++;
                        }

                        if ($manualConvivenciaText != 'No' && $convivenciaEscolarText != 'No') {
                            $modulo6Cargado++;
                        }

                        if ($cuatroText  != 'No' && $educacionText != 'No' && $planAulaText != 'No' && $integralText != 'No'&& $transversalText != 'No' && $planesText != 'No' && $mallasText != 'No' && $sieeText != 'No' && $teologicoText != 'No' && $resolucionText != 'No' && $establecimientoText != 'No' && $manualConvivenciaText != 'No' && $convivenciaEscolarText != 'No' && $intensidadText != 'No') {
                            $totalCargados++;
                        }

                        $colegiosTotales++;
                    }
                    

                    echo "<div class='resultado-final'>";
                    echo "<table border='1'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th></th>";
                    echo "<th>I.E</th>";
                    echo "<th>Teleológico</th>";
                    echo "<th>Pedagógico</th>";
                    echo "<th>Planes-Programas-Proyectos</th>";
                    echo "<th>Preescolar</th>";
                    echo "<th>Convivencia</th>";
                    echo "<th>Todos los módulos</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<th>Han cargado</th>";
                    echo "<td>{$modulo1Cargado}</td>";
                    echo "<td>{$modulo2Cargado}</td>";
                    echo "<td>{$modulo3Cargado}</td>";
                    echo "<td>{$modulo4Cargado}</td>";
                    echo "<td>{$modulo5Cargado}</td>";
                    echo "<td>{$modulo6Cargado}</td>";
                    echo "<td>{$totalCargados}</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>No han cargado</th>";
                    echo "<td>" . ($colegiosTotales - $modulo1Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo2Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo3Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo4Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo5Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo6Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $totalCargados) . "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                }

            } else {
                echo "No se encontraron resultados.";
            }
            ?>
            
        </div>
        <div class="separador"></div>
        

    </div>
    <script src="./js/generalReport.js"></script>
</body>
</html>
