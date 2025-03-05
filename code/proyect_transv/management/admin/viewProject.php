<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Colegio</title>
    <link rel="stylesheet" href="./../../../../css/viewProject.css"> 
</head>
<body>
   
    

    <?php
    include("../../../../conexion.php");
    require_once '../../../../sessionCheck.php';
   
    $id_cole = $_GET['id_cole'];
    
    // Obtener el nombre del colegio
    $sql = "SELECT nombre_cole FROM colegios WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $nombre_cole = $row['nombre_cole'];
    } else {
        echo "Error en la consulta: " . mysqli_error($mysqli);
    }
   
include("../../../../questions.php");
include("../../../../answers.php");

$sql = "SELECT * FROM proyec_pedag_transv WHERE id_cole = $id_cole";
$result = mysqli_query($mysqli, $sql);
$numProjects = 0;

if ($result && mysqli_num_rows($result) > 0) {
    echo '<div class="college">';
    echo '<h2>' . $nombre_cole . '</h2>';
    echo '</div>';
   
   
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="container">';
        $nameProject = $selec_proyec_transv = $row['selec_proyec_transv'];
        $numProjects++;

        

        foreach ($answers as $index => $columnName) {
            echo '<div class="project">';
            echo '<div class="question">' . $questions[$index] . '</div>';
            echo '<div class="answer">' . $row[$columnName] . '</div>';
            echo '</div>';
        }

        // echo '<h1>Número de proyectos: ' . $numProjects . '</h1>';

        switch ($nameProject) {
            case "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC":
                $nroProject = 1;
                break;
            case "PROYECTO DE EDUCACIÓN AMBIENTAL PRAE":
                $nroProject = 2;
                break;
            case "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS":
                $nroProject = 3;
                break;
            case "PROYECTO DE EDUCACION VIAL":
                $nroProject = 4;
                break;
           
           
        }

        $archivos = array(); // Inicializar el array de archivos

        // Verificar si el proyecto tiene un número válido antes de intentar escanear el directorio
        if ($nroProject >= 1 && $nroProject <= 4) {
            $directorio = './../../projectFiles/'.$id_cole.'/'.$nroProject;
           
            if (is_dir($directorio)) {  
                $archivos = scandir($directorio);
                $archivos = array_diff($archivos, array('.', '..'));
            }
        }
        
        echo '<h4>Archivos Cargados en el proyecto '.$nameProject.':</h4>';
        echo '<ul>';
        if (empty($archivos)) {
            echo '<li>Carpeta vacía</li>';
       

    
        } else {
            // foreach ($archivos as $archivo) {
            //     echo '<li>'.$archivo.'</li>';
            // }
            
            echo '<ul>';
            if (empty($archivos)) {
                echo '<li>No se han cargado archivos</li>';
            } else {
                foreach ($archivos as $archivo) {
                    echo '<li><a href="' . $directorio . '/' . $archivo . '" target="_blank">' . $archivo . '</a></li>';
                }
            }
            echo '</ul>';

        }
        echo '</ul>';
        $iconStyle = "style='width: 40px; height: 40px; max-width: 100%; '";
        $ruteIcon="./../../../../img/excel.png";
        $excel = "<a href='./excel.php?id_cole=" . $id_cole . "&nombre_cole=" . $nombre_cole . "&nroProject=" . $nroProject . "'>Descargar archivo Excel</a>";
       
            
        
        echo'<div class="excel-container">';
        echo "$excel";
        
        echo '</div>';
        echo '</div>';
        $iconStyle = "style='width: 40px; height: 40px; max-width: 100%;'";
        $ruteIcon="./../../../../img/excel.png";
        $excels = "<a class='excel-button' href='./excels.php?id_cole=" . $id_cole . "&nombre_cole=" . $nombre_cole . "&nroProject=" . $nroProject . "'>Descargar Excel de todos los proyectos</a>";
      
      
        echo '<div class="project-separator">
        
        </div>';
       
       
       

    }
    echo'<div class="report">';
    echo $excels;
    echo'</div>';

    echo'<div class="back">';
    echo '<button type="reset"  role="link" onclick="window.location.href=\'./colleges.php\';">';
    echo '<img src="./../../../../img/atras.png" width="27" height="27"> REGRESAR';
    echo '</button>';
    echo'</div>';
}
else {
    echo '<div class="container">';
    echo '<h2>' . $nombre_cole . '</h2>';
    echo "No se encontraron proyectos para este colegio.";
    echo '</div>';
    echo'<div class="back">';
    echo '<button type="reset"  role="link" onclick="window.location.href=\'./colleges.php\';">';
    echo '<img src="./../../../../img/atras.png" width="27" height="27"> REGRESAR';
    echo '</button>';
    echo'</div>';
}
?>

</body>
</html>

