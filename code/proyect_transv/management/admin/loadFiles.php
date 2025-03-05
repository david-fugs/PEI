<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEI|Cargar Archivo</title>
    <link rel="stylesheet" href="./../../../css/table.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFzWZjJeIDr4r8W8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../../../../css/files.css">
    
</head>
<?php
include("./../../../../conexion.php");
require_once '../../../../sessionCheck.php';
$idProject = $_GET['id_proyecto'];


$sql = "SELECT selec_proyec_transv FROM proyec_pedag_transv where Id_proyec_pedag_transv =$idProject";
$result = mysqli_query($mysqli, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        $nameProject = $selec_proyec_transv = $row['selec_proyec_transv'];
    }

}


switch ($nameProject) {
    case "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC":
        $numberProject = 1;
        break;
    case "PROYECTO DE EDUCACIÓN AMBIENTAL PRAE":
        $numberProject = 2;
        break;
    case "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS":
        $numberProject = 3;
        break;
    case "PROYECTO DE EDUCACION VIAL":
        $numberProject = 4;
        break;
    // default:
   
    //     $nroProject = 0; 
}
if (isset($_GET['id_cole'])) {
    
    $id_cole = $_GET['id_cole'];

   

    $consulta_cole = "SELECT nombre_cole FROM colegios WHERE id_cole = $id_cole";
    $result_cole = mysqli_query($mysqli, $consulta_cole);
    $nombre_cole = "";

    if ($result_cole && mysqli_num_rows($result_cole) > 0) {
        $row_cole = mysqli_fetch_assoc($result_cole);
        $nombre_cole = $row_cole['nombre_cole'];
    }
}
?>
<body>
   
    <div class="centered-content" >
        <div class="title" >
            <h2><?php echo $nombre_cole?></h2>
            <h3><?php echo $nameProject?></h3>
        </div>
    
        <div class="form-container">
            
                <form action="#" method="post" enctype="multipart/form-data" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="100000000000">
                    <br>
                    <b>Cargar Documento</b>
                
                    <br>
                    <label class="custom-file-input">
                        <input name="userfile" type="file">
                    </label>
                    <br>
                    <input type="submit" value="Enviar">
                </form>
                
        </div>
        <div class="separator"></div>
        
    
        <div class="back-btn">
            <a href="./colleges.php">
                <img src="../../../../img/atras.png" width="72" height="72" title="Regresar" />
            </a>
        </div>
    
 <?php 
   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["userfile"]) && $_FILES["userfile"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = './../../projectFiles/' . $id_cole . '/'.$numberProject.'/';
        $fileName = $_FILES["userfile"]["name"];
        $tmpName = $_FILES["userfile"]["tmp_name"];
        $fileSize = $_FILES["userfile"]["size"];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = array('pdf', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'png', 'txt', 'csv');

        if (in_array($fileExt, $allowedExtensions)) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($tmpName, $filePath)) {
                echo "<p style='text-align: center; color: green;'>El archivo se ha cargado correctamente en el servidor.</p>";

               
                if (!isset($_SESSION['uploadedFiles'])) {
                    $_SESSION['uploadedFiles'] = array();
                }

                

            } else {
                echo "<p style='text-align: center; color: red;'>Hubo un error al cargar el archivo.</p>";
            }
        } else {
            echo "<p style='text-align: center; color: red;'>Error: Solo se permiten archivos en formato PDF, Excel (XLS, XLSX), Word (DOC, DOCX), PowerPoint (PPT, PPTX), imágenes (JPG, PNG), texto (TXT), y archivos CSV.</p>";
        }
    } else {
        // echo "<p style='text-align: center; color: red;'>Error: No se seleccionó ningún archivo o hubo un error al cargarlo.</p>";
    }
}

$uploadDir = './../../projectFiles/' . $id_cole . '/'.$numberProject.'/';
;


if (is_dir($uploadDir)) {
    $files = scandir($uploadDir);

   
    $files = array_diff($files, array('.', '..'));

    if (count($files) > 0) {
      
        echo "<table>";
        echo "<tr><th>Número</th><th>Nombre del Archivo</th><th>Descargar</th><th>Eliminar</th></tr>";
        $count = 1;
        foreach ($files as $file) {
            echo "<tr>";
            echo "<td>$count</td>";
            echo "<td>$file</td>";
            $estilo_icono = "width: 40px; height: 40px; max-width: 100%;"; 

            echo "<td><a href=\"$uploadDir$file\" download>";
            echo "<img src=\"./../../../../img/downloadd.png\" alt=\"Descargar\" style=\"$estilo_icono\">";
            echo "</a></td>";
            
          
            echo "<td>";
            echo "<form method=\"post\" class=\"eliminar-form\">"; 
            echo "<input type=\"hidden\" name=\"filename\" value=\"$file\">";
            echo "<input type=\"hidden\" name=\"filepath\" value=\"$uploadDir$file\">";
            echo "<button type=\"submit\" style=\"border: none; padding: 0; background: none;\">";
            echo "<img src=\"./../../../../img/delete.png\" alt=\"Eliminar\" style=\"$estilo_icono\">";
            echo "</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            $count++;
        }
        echo "</table>";


    } else {
        
       
        echo "La carpeta  del colegio $nombre_cole está vacía.";
    }

} else {
    
    echo "Aún no se han cargado archivos";
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filename"]) && isset($_POST["filepath"])) {
    $fileName = $_POST["filename"];
    $filePath = $_POST["filepath"];

  
    if (file_exists($filePath) && is_writable($filePath)) {
   
        if (unlink($filePath)) {
            echo "<p style='text-align: center; color: green;'>El archivo se ha eliminado correctamente.</p>";
            echo "<script>setTimeout(function(){window.location.reload();}, 1000);</script>"; 
        } else {
            echo "<p style='text-align: center; color: red;'>Error al eliminar el archivo.</p>";
        }
    } else {
        // echo "<p style='text-align: center; color: red;'>No se puede eliminar el archivo. Verifica los permisos de la carpeta.</p>";
    }
}
?>

    </div>
</body>
</html>




