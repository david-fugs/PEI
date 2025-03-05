<?php
$nombre_cole = $_GET['nombre_cole'];
date_default_timezone_set("America/Bogota");
$fecha = date("d/m/Y");

header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
$filename = "Proyectos Pedagógicos ".$nombre_cole."-" .$fecha . ".xls";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . $filename . "");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel report</title>
</head>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        background-color: #000000;
    }

   
</style>

<body>
    <?php
    include("../../../../conexion.php");
    require_once '../../../../sessionCheck.php';
   
    $id_cole = $_GET['id_cole'];

  
    $sql = "SELECT nombre_cole FROM colegios WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $nombre_cole = $row['nombre_cole'];
    } else {
        echo "Error en la consulta: " . mysqli_error($mysqli);
    }
    echo "<h1>$nombre_cole</h1> <h3>$fecha</h3>";

   
    include("../../../../questions.php");
    include("../../../../answers.php");

    $sql = "SELECT * FROM proyec_pedag_transv WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    $numProjects = 0;

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nameProject = $selec_proyec_transv = $row['selec_proyec_transv'];
            $numProjects++;

            echo "<h2>$nameProject</h2>";
        
            echo "<table>";
            echo "<tr></tr>";
          
            echo "<tr style='border: 1px solid black;'><th>Número</th><th>Pregunta</th><th>Respuesta</th></tr>";

            foreach ($answers as $index => $columnName) {
                $question = $questions[$index];
                $answer = $row[$columnName];
                $index = $index + 1;

                echo "<tr><td style='text-align: left; border: 1px solid #555;'>$index</td><td style='text-align: left; border: 1px solid #555;'>$question</td><td style='text-align: left; border: 1px solid #555;'>$answer</td></tr>";
                
            }

            echo "</table>";

        }
    } else {
        echo '<div class="container">';
        echo '<h2>' . $nombre_cole . '</h2>';
        echo "No se encontraron proyectos para este colegio.";
        echo '</div>';
    }
    ?>
</body>
</html>
