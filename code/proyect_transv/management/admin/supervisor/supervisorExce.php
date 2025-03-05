<?php
date_default_timezone_set("America/Bogota");
$fecha = date("d/m/Y");
header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
$filename = "Seguimiento_Proyectos_pedagogicos "."-" . $fecha . ".xls";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . $filename . "");
?>

<?php 
include("./../../../../../conexion.php");
include("./../../../../../answers.php");
require_once './../../../../../sessionCheck.php';
// require_once './../../../../OnlyAdmin.php';

$id_cole = $_GET['id_cole'];
$consulta = "SELECT * FROM colegios where id_cole=$id_cole";


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
    <style>
    
body {
    /* background-color: #f0f0f0;  */
    background-color: #fffdfd; 
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
  }
  


table {
    border-collapse: collapse;
    border:  #ddd; 
    width: 100%;
    max-width: 900%;
    margin: 20px auto;
    font-family: Arial, sans-serif;
   
  }
  
  th, td {
    padding: 5px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    text-align:center;
  }
  
  th {
    background-color: #3498db;
    color: #fff;
  }
  
  /* Estilos para las celdas alternas */
  tr:nth-child(even) {
    background-color: rgba(56, 165, 238, 0.1);
  }
  
  /* Estilos para el encabezado flotante */
  thead {
    position: sticky;
    top: 0;
    background-color: #8f8aee;
  }
  
  /* Estilos para el hover de las filas */
  tr:hover {
    background-color: rgba(38, 156, 234, 0.865);
    transition: background-color 0.3s ease-in-out;
  }
  
 

/* Estilos para el formulario de filtrado */
form {
    text-align: center;
    margin: 20px 0;
  }

  
  input[type="text"] {
    padding: 10px;
    border: 2px solid #60b4df;
    border-radius: 5px;
    font-size: 16px;
    color: #333;
    outline: none;
  }
  
  input[type="submit"] {
    padding: 10px 20px;
    background-color: #60b4df;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
  }
  
  input[type="submit"]:hover {
    background-color: #3498db;
  }
  
  /* Estilos para el título */
  h2 {
    font-size: 24px;
    color: #3498db;
    margin-bottom: 10px;
  }
  
  
  .back {
    text-align: center;
    margin-top: 30px;
}

.back button {
    background-color: #3498db;
    border: none;
    padding: 10px 20px;
    color: rgb(255, 253, 253);
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.back button img {
    vertical-align: middle;
    margin-right: 5px;
}

.back button:hover {
    background-color: #82cef3;
}

.green-cell {
    background-color: rgba(32, 246, 32, 0.729);
    
}

.red-cell {
    background-color: rgba(226, 78, 78, 0.695);
    
}

.blue-cell:hover {
  background-color: rgba(38, 156, 234, 0.865);
}

    </style>

</head>
<body>
    
    <div class="container">
        <div class="centered-content">
          
        <form action="#" method="post">
        <h2 style="text-align: center;">Seguimiento Proyectos pedagógicos.<?php echo $fecha?></h2>
       

    <p style="font-family: Arial, sans-serif; font-size: 14px; color: #333; line-height: 1.5;">
    A continuación se pueden observar El colegio que ha participado activamente 
    en la carga de proyectos.
    Un sí en la tabla indica que el colegio ha cargado por lo menos un proyecto,
    mientras que un no significa que no se ha cargado ningún proyecto en ese colegio.
</p>
   
   
</form>

        <?php
       
        if ($resultados && mysqli_num_rows($resultados) > 0) {
            echo "<br>";
            echo "<table border class=center-table>";
            echo "<thead>";
            echo "<tr>";
            echo "<td align='center'><b>No</b></td>";
            echo "<td align='center'><b>Nombre del Colegio</b></td>";
            echo "<td align='center'><b>PROYECTO PARA LA EDUCACIÓN SEXUAL Y CONSTRUCCIÓN DE CIUDADANÍA PESCC</b></td>";
            echo "<td align='center'><b>PROYECTO DE EDUCACIÓN AMBIENTAL PRAE</b></td>";
            echo "<td align='center'><b>PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS</b></td>";
            echo "<td align='center'><b>PROYECTO DE EDUCACIÓN VIAL</b></td>";
            echo "</tr>";

           
            // echo "<td><b>Descargar Reporte</b></td>";
           
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            // $id_proyecto = "";
            while ($fila = mysqli_fetch_assoc($resultados)) {
                echo "<tr ALIGN=center>";
                echo "<td>".$fila['id_cole']."</td>";
                echo "<td style='text-align: left;'>".$fila['nombre_cole']."</td>";

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
                //  echo "<td>" . ($projectCounts[1] > 0 ? $projectCounts[1] : "0") . "</td>";
                echo "<td class='" . ($hasProjects2 ? 'green-cell' : 'red-cell') . "'>" . ($hasProjects2 ? 'SI' : 'NO') . "</td>";
                // echo "<td>" . ($projectCounts[2] > 0 ? $projectCounts[2] : "0") . "</td>";
                echo "<td class='" . ($hasProjects3 ? 'green-cell' : 'red-cell') . "'>" . ($hasProjects3 ? 'SI' : 'NO') . "</td>";
                // echo "<td>" . ($projectCounts[3] > 0 ? $projectCounts[3] : "0") . "</td>";
                echo "<td class='" . ($hasProjects4 ? 'green-cell' : 'red-cell') . "'>" . ($hasProjects4 ? 'SI' : 'NO') . "</td>";
                // echo "<td>" . ($projectCounts[4] > 0 ? $projectCounts[4] : "0") . "</td>";
                

               




            
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

