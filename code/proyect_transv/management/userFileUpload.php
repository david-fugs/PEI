<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Archivo</title>
    <link rel="stylesheet" href="./../../css/table.css">
    <style>
         /* Estilos para el formulario de carga de archivos */
      

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }

        form b {
            font-size: 18px;
        }

        input[type="file"] {
            margin-top: 10px;
            font-size: 16px;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #60b4df;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #60b4df;
        }

        h3 {
            text-align: center;
            font-weight: normal;
            margin-top: 40px;
            font-size: 16px;
        }

        .back-btn {
            display: block;
            margin: 20px auto;
            text-align: center;
        }

        label {
        display: block;
        margin-bottom: 10px;
        
    }
      
       
    </style>
</head>
<?php
// Incluir el archivo de conexión a la base de datos
include("./../../../conexion.php");

// Verificar si los parámetros GET 'id' e 'id_cole' están definidos
if (isset($_GET['id']) && isset($_GET['id_cole'])) {
    // Obtener los valores de los parámetros GET
    // $id = $_GET['id'];
    $id_cole = $_GET['id_cole'];

    // Consultar la base de datos para obtener el nombre del colegio
    $consulta_cole = "SELECT nombre_cole FROM colegios WHERE id_cole = $id_cole";
    $result_cole = mysqli_query($mysqli, $consulta_cole);
    $nombre_cole = "";

    // Verificar si se obtuvieron resultados de la consulta y si hay al menos una fila
    if ($result_cole && mysqli_num_rows($result_cole) > 0) {
        // Obtener los datos del colegio desde el resultado de la consulta
        $row_cole = mysqli_fetch_assoc($result_cole);
        $nombre_cole = $row_cole['nombre_cole'];
    }
}
?>

<body>
    <h2 style="text-align: center;"><?php echo $nombre_cole?></h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="100000000000">
        <br>

        <b>Cargar Documento</b>
       
        <br>
        <input name="userfile" type="file">
        <br>
        <input type="submit" value="Enviar">
    </form>
   
   
    <div class="back-btn">
        <a href="./../../../access.php">
             <!-- Enlace para volver atrás -->
        
            <img src="./../../img/atras.png" width="72" height="72" title="Inicio" />
        </a>
    </div>
 <?php 
     // Procesar la carga de archivos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha seleccionado un archivo y si no hubo errores en la carga
    if (isset($_FILES["userfile"]) && $_FILES["userfile"]["error"] === UPLOAD_ERR_OK) {
        // Directorio de carga para los archivos del colegio
        $uploadDir = './../projectFiles/' . $id_cole;

        // Obtener el nombre original del archivo
        $fileName = $_FILES["userfile"]["name"];

        // Obtener la ubicación temporal del archivo cargado
        $tmpName = $_FILES["userfile"]["tmp_name"];

        // Obtener el tamaño del archivo cargado en bytes
        $fileSize = $_FILES["userfile"]["size"];
        

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        //archivos admitidos
        $allowedExtensions = array('pdf', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'png', 'txt', 'csv');

        if (in_array($fileExt, $allowedExtensions)) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Construir la ruta completa del archivo destino
            $filePath = $uploadDir . $fileName;

            // Intentar mover el archivo cargado a su ubicación final
            if (move_uploaded_file($tmpName, $filePath)) {
                // Mostrar un mensaje de éxito si el archivo se cargó correctamente
                echo "<p style='text-align: center; color: green;'>El archivo se ha cargado correctamente en el servidor.</p>";

                // Verificar si la variable de sesión 'uploadedFiles' está definida
                if (!isset($_SESSION['uploadedFiles'])) {
                    // Si no está definida, inicializarla como un array vacío
                    $_SESSION['uploadedFiles'] = array();
                }
                

            } else {
                echo "<p style='text-align: center; color: red;'>Hubo un error al cargar el archivo.</p>";
            }
        } else {
            echo "<p style='text-align: center; color: red;'>Error: Solo se permiten archivos en formato PDF, Excel (XLS, XLSX), Word (DOC, DOCX), PowerPoint (PPT, PPTX), imágenes (JPG, PNG), texto (TXT), y archivos CSV.</p>";
        }
    } else {
        echo "<p style='text-align: center; color: red;'>Error: No se seleccionó ningún archivo o hubo un error al cargarlo.</p>";
    }
}
// Construir la ruta completa del directorio de archivos del colegio
$uploadDir = './../projectFiles/' . $id_cole;

// Verificar si el directorio existe
if (is_dir($uploadDir)) {
    // Escanear el directorio y obtener la lista de archivos
    $files = scandir($uploadDir);

    // Eliminar las entradas "." y ".." del array de archivos
    $files = array_diff($files, array('.', '..'));

    // Verificar si hay archivos en el directorio
    if (count($files) > 0) {
        // Mostrar una tabla con la lista de archivos cargados
        echo "<table>";
        echo "<tr><th>Número</th><th>Nombre del Archivo</th><th>Descargar</th></tr>";
        $count = 1;
        foreach ($files as $file) {
            echo "<tr>";
            echo "<td>$count</td>";
            echo "<td>$file</td>";
            echo "<td><a href=\"$uploadDir$file\" download>";
            echo "<img src=\"./../../img/descarga.png\" alt=\"Descargar\" style=\"width: 20px; height: 20px;\">";
            echo "</a></td>";
            echo "</tr>";
            $count++;
        }
        echo "</table>";
    } else {
        // Si no hay archivos en el directorio, mostrar un mensaje
        echo "La carpeta del colegio $nombre_cole está vacía.";
    }
} else {
    // Si el directorio no existe, mostrar un mensaje
    echo "Aún no se han cargado archivos";
}
?>






