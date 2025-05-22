<?php 
include("./../../../../../conexion.php");
include("./../../../../../answers.php");
require_once './../../../../../sessionCheck.php';
// require_once './../../../../OnlyAdmin.php';


$consulta = "SELECT * FROM colegios";


if (isset($_POST['filtrar'])) {
    $filtro = $_POST['filtro'];
  
    $consulta = "SELECT * FROM colegios WHERE nombre_cole LIKE '%$filtro%'";
}

$resultados = mysqli_query($mysqli, $consulta);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento</title>
    <link rel="stylesheet" href="./../../../../../css/supervisor.css">
 

</head>
<body>
    
    <div class="container">
        <div class="centered-content">
            <div class="rigth">
             <a class='corner-button' href='./../../../../general/generalReport.php'><img src='./../../../../../img/project-management.png' width='70' height='70' title='Seguimiento archivos PEI' /></a>
            </div>
          

            
        <form action="#" method="post">
    <h2>Seguimiento Proyectos pedagógicos</h2>
    <input type="text" name="filtro" placeholder="Buscar por nombre del colegio">
    <input type="submit" name="filtrar" value="Buscar"><br>
   
</form>

        <?php
         echo'<div class="back">';
         echo '<button type="reset"  role="link" onclick="window.location.href=\'./../../../../../access.php\';">';
         echo '<img src="./../../../../../img/atras.png" width="27" height="27"> REGRESAR';
         echo '</button>';
         echo'</div>';
         echo'<div class="back">';
         echo '<button type="reset"  role="link" onclick="window.location.href=\'./supervisorExcel.php\';">';
         echo '<img src="./../../../../../img/excel.png" width="27" height="27"> Generar reportes';
         echo '</button>';
         echo'</div>';
         
         
        if ($resultados && mysqli_num_rows($resultados) > 0) {
            echo "<br>";
            echo "<table border class=center-table>";
            echo "<thead>";
            echo "<tr ALIGN=center>";
            echo "<td><b>No</b></td>";
            echo "<td><b>Nombre del Colegio</b></td>";
            echo "<td><b>PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC</b></td>";
            echo "<td>Cantidad</td>";
            echo "<td><b>PROYECTO DE EDUCACIÓN AMBIENTAL PRAE</b></td>";
            echo "<td>Cantidad</td>";
            echo "<td><b>PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS</b></td>";
            echo "<td>Cantidad</td>";
            echo "<td><b>PROYECTO DE EDUCACION VIAL</b></td>";
            echo "<td>Cantidad</td>";
            echo "<td>Generar reporte</td>";
           
           
            // echo "<td><b>Descargar Reporte</b></td>";
           
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            // $id_proyecto = "";
            while ($fila = mysqli_fetch_assoc($resultados)) {
                echo "<tr ALIGN=center>";
                echo "<td>".$fila['id_cole']."</td>";
                echo "<td>".$fila['nombre_cole']."</td>";
                $id_cole = $fila['id_cole'];
            

                //encontrar nombres de proyectos segun el id_cole
                //encontrar nombres de proyectos segun el id_cole
                $projects = "SELECT * FROM proyec_pedag_transv where id_cole=$id_cole";
                $resultsNames = mysqli_query($mysqli, $projects);

                $projectNumbers = array(); // Un array para almacenar los números de proyectos encontrados

                if ($resultsNames && mysqli_num_rows($resultsNames) > 0) {
                    while ($row = mysqli_fetch_assoc($resultsNames)) {
                        $nameProject = $row['selec_proyec_transv'];
                        $id_project = $row['Id_proyec_pedag_transv'];
                     
                       
                       
                        
                        switch ($nameProject) {
                            case "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC":
                                $projectNumbers[] = 1;
                                break;
                            case "PROYECTO DE EDUCACIÓN AMBIENTAL PRAE":
                                $projectNumbers[] = 2;
                                break;
                            case "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS":
                                $projectNumbers[] = 3;
                                break;
                            case "PROYECTO DE EDUCACION VIAL":
                                $projectNumbers[] = 4;
                                break;
                            default:
                                // Si hay otros proyectos que no estén en tu switch, puedes manejarlos aquí.
                                break;
                        }
                    }
                }

                // Llena el array con "no hay proyecto cargado" si hay menos de 4 proyectos encontrados
                while (count($projectNumbers) < 4) {
                    $projectNumbers[] = "no hay proyecto cargado";
                }

                // Imprime las celdas correspondientes a los proyectos
                $projectCounts = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);

                foreach ($projectNumbers as $projectNumber) {
                    if (isset($projectCounts[$projectNumber])) {
                        $projectCounts[$projectNumber]++;
                    }
                }

               
                //colores
                $hasProjects1 = $projectCounts[1] > 0;
                $hasProjects2 = $projectCounts[2] > 0;
                $hasProjects3 = $projectCounts[3] > 0;
                $hasProjects4 = $projectCounts[4] > 0;
                echo "<td class='" . ($hasProjects1 ? 'green-cell' : 'red-cell') . "'>" . ($hasProjects1 ? 'SI' : 'NO') . "</td>";
                 echo "<td>" . ($projectCounts[1] > 0 ? $projectCounts[1] : "0") . "</td>";
                echo "<td class='" . ($hasProjects2 ? 'green-cell' : 'red-cell') . "'>" . ($hasProjects2 ? 'SI' : 'NO') . "</td>";
                echo "<td>" . ($projectCounts[2] > 0 ? $projectCounts[2] : "0") . "</td>";
                echo "<td class='" . ($hasProjects3 ? 'green-cell' : 'red-cell') . "'>" . ($hasProjects3 ? 'SI' : 'NO') . "</td>";
                echo "<td>" . ($projectCounts[3] > 0 ? $projectCounts[3] : "0") . "</td>";
                echo "<td class='" . ($hasProjects4 ? 'green-cell' : 'red-cell') . "'>" . ($hasProjects4 ? 'SI' : 'NO') . "</td>";
                echo "<td>" . ($projectCounts[4] > 0 ? $projectCounts[4] : "0") . "</td>";

                $iconStyle = "style='width: 40px; height: 40px; max-width: 100%;'";
                $icon = "./../../../../img/visualizar.png";
                $icon_excel = "./../../../../../img/excel.png";
                echo "<td><a  href='./supervisorExce.php?id_cole=".$id_cole."'><img src='$icon_excel' alt='Visualizar' $iconStyle></a></td>";

            
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No se encontraron resultados.";
        }
        ?>
    </div>
</body>
</html>

