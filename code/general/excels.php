<?php
date_default_timezone_set("America/Bogota");
$fecha = date("d/m/Y");
header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
$filename = "Informe cargue de archivos PEI "."-" . $fecha . ".xls";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . $filename . "");
?>

<?php
include("./../../conexion.php");
include("./../../sessionCheck.php");
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



$consulta = "SELECT * FROM colegios";

if (isset($_POST['filtrar'])) {
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
                echo "<td><b>ID</b></td>";
                echo "<td ><b>Establecimiento Educativo</b></td>";
                echo "<td class='encabezado encabezado1' colSpan = 2><b>Modulo 1 I.E</b></td>";
                echo "<td class='encabezado encabezado2' colSpan = 1><b>Modulo 2 Teológico</b></td>";
                
                echo "<td class='encabezado encabezado3' colSpan = 2><b>Modulo 3 Pedagógico</b></td>";
                echo "<td class='encabezado encabezado4' colSpan = 3><b>Modulo 4 Planes|proyectos</b></td>";
                echo "<td class='encabezado encabezado5' colSpan = 3><b>Modulo 5 Transición</b></td>";
                echo "<td ><b>Observaciones</b></td>";
                // echo "<td></td>";
                echo "<tr ALIGN=center>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td ><b>Resolución</b></td>";
                echo "<td ><b>Establecimiento Educativo</b></td>";
               
                echo "<td ><b>Mision|vision pei</b></td>";
               
                echo "<td ><b>Mallas Plan de estudio</b></td>";
                
                echo "<td ><b>SIEE</b></td>";
               
                echo "<td ><b>trasversales<b></td>";
              

                echo "<td ><b>Proyectos y/o planes<b></td>";
              

                echo "<td ><b>Proyectos pedagogicos<b></td>";
                
                //transición
                echo "<td ><b>Educación inicial</b></td>";
               
                echo "<td ><b>Plan de aula</b></td>";
               
                echo "<td ><b>Seguimiento Desarrollo Integral</b></td>";
               
                

               
                echo "</tr>";
                
               
                echo "</thead>";
                echo "<tbody>";

                while ($fila = mysqli_fetch_assoc($resultados)) {
                    echo "<tr ALIGN=center>";
                    echo "<td>".$fila['id_cole']."</td>";
                    echo "<td>".$fila['nombre_cole']."</td>";
                    $id_cole = $fila['id_cole'];
                    $iconStyle = "style='width: 40px; height: 40px; max-width: 100%;'";
                    $icon = "./../../../../img/visualizar.png";
                    $icon_excel = "./../../../../img/excel.png";
                
                    //IE
                    $tieneResolucion=tieneResolucion($id_cole, $mysqli);
                    echo '<td ' . ($tieneResolucion ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneResolucion ? $tieneResolucion : 'No';
                    
                    echo '</td>';
                    // echo "<td>" . $tieneResolucion. "</td>";

                    $tieneArchivoIe=tieneIe($id_cole, $mysqli);
                    // echo "<td>" . ($tieneArchivoIe ? "Si" : "No") . "</td>";
                    echo '<td ' . ($tieneArchivoIe ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivoIe ? 'Si' : 'No';
                    echo '</td>';
                  

                    
                    //Teológico
                    $tieneArchivos = tieneArchivosTeologico($id_cole);
                    // echo "<td>" . ($tieneArchivos ? "Si" : "No") . "</td>";
                    echo '<td ' . ($tieneArchivos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivos ? 'Si' : 'No';
                    echo '</td>';

                    

                    //mallas
                    $tieneArchivosMallasColegio=tieneArchivosMallasColegio($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivosMallasColegio ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosMallasColegio ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneArchivosMallasColegio ? "Si" : "No") . "</td>";
                   
                   

                    //siee
                    $tieneArchivosSiee = tieneArchivosSiee($id_cole);
                    echo '<td ' . ($tieneArchivosSiee ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosSiee ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneArchivosSiee ? "Si" : "No") . "</td>";
                    


                    //transversal
                    $tieneProyectoTransversal = tieneProyectoTransversal($id_cole,$mysqli);
                    echo '<td ' . ($tieneProyectoTransversal ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneProyectoTransversal ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneProyectoTransversal ? "Si" : "No") . "</td>";
                    

                    
                    //proyectos y planes
                    $tienePlanesProyectos = tienePlanesProyectos($id_cole, $mysqli);
                    echo '<td ' . ($tienePlanesProyectos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanesProyectos ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tienePlanesProyectos ? "Si" : "No") . "</td>";
                   

                    //proyecto pedagógico
                    $tieneArchivosEnLosCuatro = tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli);

                    echo '<td ' . ($tieneArchivosEnLosCuatro ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosEnLosCuatro ? 'Si' : 'No';
                    echo '</td>';

                  
                   

                 
                    
                    //transicion

                    //educacion inicial
                    $tieneEducacionInicial = tieneEducacionInicial($id_cole, $mysqli);
                    echo '<td ' . ($tieneEducacionInicial ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneEducacionInicial ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneEducacionInicial ? "Si" : "No") . "</td>";
                   
                    //plan aula
                    $tienePlanAula = tienePlanAula($id_cole,$mysqli);
                    echo '<td ' . ($tienePlanAula ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanAula ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tienePlanAula ? "Si" : "No") . "</td>";
                   

                    //seguimiento desarrollo integral
                    $tieneIntegral = tieneIntegral($id_cole,$mysqli);
                    echo '<td ' . ($tieneIntegral ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneIntegral ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneIntegral ? "Si" : "No") . "</td>";

                    $contenido = MostrarInformacionObservacion($id_cole, $mysqli);

                    // Retira cualquier formato HTML y asegúrate de que el contenido sea seguro para Excel
                    $contenidoParaExcel = strip_tags($contenido);
                    
                    // Luego, puedes imprimir el contenido en la celda de Excel
                    echo '<td>' . $contenidoParaExcel . '</td>';
                    

                   


   
                 
                }

                echo "</tbody>";
                echo "</table>";
                ?>
                 <br>
                 <br>
                <?php

                //reportes generales
                // ...

                $modulo1Cargado = 0;
                $modulo2Cargado = 0;
                $modulo3Cargado = 0;
                $modulo4Cargado = 0;
                $modulo5Cargado = 0;
                $totalCargados = 0;
                $colegiosTotales = 0;

                $colegios = "SELECT * FROM colegios";
                $todos = mysqli_query($mysqli, $colegios);

                if ($todos && mysqli_num_rows($todos) > 0) {
                    while ($fila = mysqli_fetch_assoc($todos)) {
                        // Obtener los valores de $tieneResolucion y $tieneArchivoIe para cada colegio
                        $id_cole = $fila['id_cole'];
                        //IE

                        $tieneResolucion = tieneResolucion($id_cole, $mysqli);
                        $resolucionText = $tieneResolucion ? $tieneResolucion : 'No';

                        $tieneArchivoIe=tieneIe($id_cole, $mysqli);
                        $establecimientoText = $tieneArchivoIe ? 'Si' : 'No';

                        //Teológico
                        $tieneArchivos = tieneArchivosTeologico($id_cole);
                        $teologicoText = $tieneArchivos ? 'Si' : 'No';

                        //Pedagígico|mallas
                        $tieneArchivosMallasColegio=tieneArchivosMallasColegio($id_cole, $mysqli);
                        $mallasText = $tieneArchivosMallasColegio ? 'Si' : 'No';

                        $tieneArchivosSiee = tieneArchivosSiee($id_cole);
                        $sieeText = $tieneArchivosSiee ? 'Si' : 'No';

                        //planes|proyectos
                        $tieneProyectoTransversal = tieneProyectoTransversal($id_cole,$mysqli);
                        $transversalText = $tieneProyectoTransversal ? 'Si' : 'No';

                        $tienePlanesProyectos = tienePlanesProyectos($id_cole, $mysqli);
                        $planesText = $tienePlanesProyectos ? 'Si' : 'No';

                        //proyectos pedagógicos
                        $tieneArchivosEnLosCuatro =tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli);
                        $cuatroText = $tieneArchivosEnLosCuatro ? 'Si' : 'No';

                        //transición
                        $tieneEducacionInicial = tieneEducacionInicial($id_cole, $mysqli);
                        $educacionText = $tieneEducacionInicial ? 'Si' : 'No';

                        $tienePlanAula = tienePlanAula($id_cole,$mysqli);
                        $planAulaText = $tienePlanAula ? 'Si' : 'No';

                        $tieneIntegral = tieneIntegral($id_cole,$mysqli);
                        $integralText = $tieneIntegral ? 'Si' : 'No';

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
                        if ($transversalText != 'No' && $planesText != 'No' && $cuatroText  != 'No') {
                            $modulo4Cargado++;
                        }

                        if ($educacionText != 'No' && $planAulaText != 'No' && $integralText != 'No') {
                            $modulo5Cargado++;
                        }

                        if ($cuatroText  != 'No' && $educacionText != 'No' && $planAulaText != 'No' && $integralText != 'No'&& $transversalText != 'No' && $planesText != 'No' && $mallasText != 'No' && $sieeText != 'No' && $teologicoText != 'No' && $resolucionText != 'No' && $establecimientoText != 'No'&& $educacionText != 'No' && $planAulaText != 'No' && $integralText != 'No') {
                            $totalCargados++;
                        }

                        $colegiosTotales++;
                    }
                    

                    echo "<div class='resultado-final'>";
                    echo "<table border='1'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th></th>";
                    echo "<th>Módulo 1 I.E</th>";
                    echo "<th>Módulo 2 Teológico</th>";
                    echo "<th>Módulo 3 Pedagógico|Mallas</th>";
                    echo "<th>Módulo 4 Planes|proyectos</th>";
                    echo "<th>Módulo 5 Transición</th>";
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
                    echo "<td>{$totalCargados}</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>No han cargado</th>";
                    echo "<td>" . ($colegiosTotales - $modulo1Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo2Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo3Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo4Cargado) . "</td>";
                    echo "<td>" . ($colegiosTotales - $modulo5Cargado) . "</td>";
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
