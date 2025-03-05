<?php 
include("../../../../conexion.php");
require_once './../../../../sessionCheck.php';
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
    <title>Colegios</title>
    <link rel="stylesheet" href="./../../../../css/colleges.css">

</head>
<body>
    
    <div class="container">
        <div class="centered-content">
          

            
        <form action="#" method="post">
    <h2>Proyectos pedagógicos</h2>
    <input type="text" name="filtro" placeholder="Buscar por nombre del colegio">
    <input type="submit" name="filtrar" value="Buscar"><br>
   
</form>


      

        <?php
         echo'<div class="back">';
         echo '<button type="reset"  role="link" onclick="window.location.href=\'./../../../../accessAdmin.php\';">';
         echo '<img src="./../../../../img/atras.png" width="27" height="27"> REGRESAR';
         echo '</button>';
         echo'</div>';
        if ($resultados && mysqli_num_rows($resultados) > 0) {
            echo "<br>";
            echo "<table border class=center-table>";
            echo "<thead>";
            echo "<tr ALIGN=center>";
            echo "<td><b>No</b></td>";
            echo "<td><b>Nombre del Colegio</b></td>";
            echo "<td><b>Ver Proyectos</b></td>";
            echo "<td><b>Editar proyecto</b></td>";
            echo "<td><b>Descargar Proyectos</b></td>";
            echo "<td><b>Archivos</b></td>";
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
                $icon_edit = "./../../../../img/pencil.png";
                $icon_files = "./../../../../img/files.png";
               
                echo "<td><a  href='./viewProject.php?id_cole=".$id_cole."'><img src='$icon' alt='Visualizar' $iconStyle></a></td>";
                echo "<td><a  href='./listProject.php?id_cole=".$id_cole."'><img src='$icon_edit' alt='Editar' $iconStyle></a></td>";
                echo "<td><a  href='./excels.php?id_cole=".$id_cole."'><img src='$icon_excel' alt='Visualizar' $iconStyle></a></td>";
                echo "<td><a  href='./files.php?id_cole=".$id_cole."'><img src='$icon_files' alt='Visualizar' $iconStyle></a></td>";
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
