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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe cargue de archivos PEI</title>
    <link rel="stylesheet" href="./../../css/generalReport.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>

    <div class="container">
        <div class="rigth">
            <a class='corner-button' href='./../proyect_transv/management/admin/supervisor/supervisor.php'><img src='./../../img/project-management.png' width='70' height='70' title='Seguimiento proyectos pedagógicos' /></a>
        
        </div>
    
    
        <div class="centered-content">
       
       
            <form action="#" method="post">
                <h2>Informe cargue de archivos PEI</h2>
                <input type="text" name="filtro" placeholder="Buscar por nombre del colegio">
                <input type="submit" name="filtrar" value="Buscar"><br>
            </form>


            <div class="botones">
                <div class="detalles">
            
                    <label
                        ><input type="checkbox" id="cbox1" value="mostrar_archivos" />Mostrar Archivos</label
                        ><br />
                </div>


                    

                <button class="button">
                <a href="./excels.php">Historia de excel</a>
                </button>

            </div>

            


            <div class="back">
                <button type="reset" role="link" onclick="window.location.href='./../../access.php';">
                    <img src="./../../img/atras.png" width="27" height="27"> REGRESAR
                </button>
            </div>

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
                echo "<td><b> Observaciones</b></td>";
                // echo "<td></td>";
                echo "<tr ALIGN=center>";
                echo "<td ></td>";
                echo "<td></td>";
                echo "<td ><b>Resolución</b></td>";
                echo "<td ><b>Establecimiento Educativo</b></td>";
                echo "<td class='oculto'>Archivos Establecimiento educativo</td>";
                echo "<td ><b>Mision|vision pei</b></td>";
                echo "<td class='oculto'>Archivos cargados para Teológico</td>";
                echo "<td ><b>Mallas Plan de estudio</b></td>";
                echo "<td class='oculto'>ARCHIVOS MALLAS</td>";
                echo "<td ><b>SIEE</b></td>";
                echo "<td class='oculto'>ARCHIVOS SIEE</td>";
                echo "<td ><b>trasversales<b></td>";
                echo "<td class='oculto'>archivos transversales</td>";

                echo "<td ><b>Proyectos y/o planes<b></td>";
                echo "<td class='oculto'>archivos PROYECTOS Y PLANES</td>";

                echo "<td ><b>Proyectos pedagogicos<b></td>";
                echo "<td class='oculto'><b>Archivo proyectos pedagogicos<b></td>";
                //transición
                echo "<td ><b>Educación inicial</b></td>";
                echo "<td class='oculto'>ARCHIVOS Educación inicial</td>";
                echo "<td ><b>Plan de aula</b></td>";
                echo "<td class='oculto'>ARCHIVOS Plan de aula</td>";
                echo "<td ><b>Seguimiento Desarrollo Integral</b></td>";
                echo "<td class='oculto'>ARCHIVOS Seguimiento Desarrollo Integral</td>";
                echo "<td></td>";
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
                    echo "<td class='oculto'>" .mostrarArchivosIe($id_cole, $mysqli). "</td>";

                    
                    //Teológico
                    $tieneArchivos = tieneArchivosTeologico($id_cole);
                    // echo "<td>" . ($tieneArchivos ? "Si" : "No") . "</td>";
                    echo '<td ' . ($tieneArchivos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivos ? 'Si' : 'No';
                    echo '</td>';

                    echo mostrarListaArchivos($id_cole);

                    //mallas
                    $tieneArchivosMallasColegio=tieneArchivosMallasColegio($id_cole, $mysqli);
                    echo '<td ' . ($tieneArchivosMallasColegio ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosMallasColegio ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneArchivosMallasColegio ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" .mostrarMallasYArchivos($id_cole, $mysqli). "</td>";
                   

                    //siee
                    $tieneArchivosSiee = tieneArchivosSiee($id_cole);
                    echo '<td ' . ($tieneArchivosSiee ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosSiee ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneArchivosSiee ? "Si" : "No") . "</td>";
                    echo mostrarListaArchivosSiee($id_cole);


                    //transversal
                    $tieneProyectoTransversal = tieneProyectoTransversal($id_cole,$mysqli);
                    echo '<td ' . ($tieneProyectoTransversal ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneProyectoTransversal ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneProyectoTransversal ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" . mostrarArchivosTransversales($id_cole,$mysqli). "</td>";

                    
                    //proyectos y planes
                    $tienePlanesProyectos = tienePlanesProyectos($id_cole, $mysqli);
                    echo '<td ' . ($tienePlanesProyectos ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanesProyectos ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tienePlanesProyectos ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" . mostrarArchivosPlanesProyectos($id_cole,$mysqli). "</td>";

                    //proyecto pedagógico
                    $tieneArchivosEnLosCuatro = tieneArchivosEnLosCuatroProyectos($id_cole, $mysqli);

                    echo '<td ' . ($tieneArchivosEnLosCuatro ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneArchivosEnLosCuatro ? 'Si' : 'No';
                    echo '</td>';

                  
                    
                    echo "<td class='oculto'>" . mostrarArchivosDeProyectos($id_cole, $mysqli). "</td>";

                 
                    
                    //transicion

                    //educacion inicial
                    $tieneEducacionInicial = tieneEducacionInicial($id_cole, $mysqli);
                    echo '<td ' . ($tieneEducacionInicial ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneEducacionInicial ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneEducacionInicial ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" .mostrarArchivosEducacionInicial($id_cole,$mysqli). "</td>";
                   

                    //plan aula
                    $tienePlanAula = tienePlanAula($id_cole,$mysqli);
                    echo '<td ' . ($tienePlanAula ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tienePlanAula ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tienePlanAula ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" .mostrarArchivosPlanAula($id_cole,$mysqli). "</td>";
                   

                    //seguimiento desarrollo integral
                    $tieneIntegral = tieneIntegral($id_cole,$mysqli);
                    echo '<td ' . ($tieneIntegral ? 'class="verde"' : 'class="rojo"') . '>';
                    echo $tieneIntegral ? 'Si' : 'No';
                    echo '</td>';
                    // echo "<td>" . ($tieneIntegral ? "Si" : "No") . "</td>";
                    echo "<td class='oculto'>" .mostrarArchivosIntegral($id_cole,$mysqli). "</td>";

                    // $observacion = Observacion($id_cole,$mysql,$contenido);
                    // echo'<td>'.$observacion.'</td>';
                   
                    $contenido = MostrarInformacionObservacion($id_cole, $mysqli);

                    // // Mostramos el contenido de la observación en un formulario
                    // echo '<form method="POST" action="./observacion.php">';
                    // echo '<input type="hidden" name="id_cole" value="' . $id_cole . '">';
                    // echo '<textarea name="nueva_observacion" class="td-textarea">' . htmlspecialchars($contenido) . '</textarea>'; // Usar htmlspecialchars para evitar problemas de seguridad
                    // echo '<input type="submit" value="Guardar">';
                    // echo '</form>';
                    // echo '</td>';
                    echo '<td class="observacion" >';
                    echo '<div class="observacion-form">';
                    echo '<input type="hidden" name="id_cole" value="' . $id_cole . '">';
                    echo '<textarea name="nueva_observacion" class="td-textarea">' . htmlspecialchars($contenido) . '</textarea>';
                    echo '<button class="buton-observacion" id="guardar-observacion-' . $id_cole . '">Guardar</button>';
                    echo '</div>';
                    echo '</td>';
                    



                
                }

                echo "</tbody>";
                echo "</table>";

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
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['id_cole']) && isset($_POST['nueva_observacion'])) {
        $id_cole = $_POST['id_cole'];
        $nueva_observacion = $_POST['nueva_observacion'];

        if (ActualizarObservacion($id_cole, $nueva_observacion, $mysqli)) {
            echo 'Observación actualizada exitosamente.';
        } else {
            // echo 'Error al actualizar la observación.';
        }
    } else {
        // echo 'Datos del formulario incompletos.';
    }
} else {
    // echo 'Acceso no permitido.';
}
?>

<script>
    $(document).ready(function () {
    $("button[id^='guardar-observacion']").click(function (e) {
        e.preventDefault();

        var id_cole = $(this).siblings("input[name='id_cole']").val();
        var nueva_observacion = $(this).siblings("textarea[name='nueva_observacion']").val();

        $.ajax({
    type: "POST",
    url: "./observacion.php",
    data: { id_cole: id_cole, nueva_observacion: nueva_observacion },
   
    error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error de conexión:", errorThrown);
    },
});

    });
});

</script>