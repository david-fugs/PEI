<?php 
include("./../../../conexion.php");
require_once './../../../sessionCheck.php';
$id_usu = $_SESSION['user']['id']; 

$sql_id_cole = "SELECT id_cole FROM usuarios WHERE id = $id_usu"; 
$result = mysqli_query($mysqli, $sql_id_cole);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_cole = $row['id_cole'];

    // echo "Cole_id: " . $id_cole;
} else {
    echo "No se encontró el id_cole asociado a este usuario.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar proyectos de colegio</title>
    <!-- <link rel="stylesheet" href="./../../../../css/editProject.css"> -->
    <link rel="stylesheet" href="./../../../css/listProyect.css">
    
</head>
<body>
   

    <?php
    // Obtener el nombre del colegio
    $sql = "SELECT nombre_cole FROM colegios WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $nombre_cole = $row['nombre_cole'];
    } else {
        echo "Error en la consulta: " . mysqli_error($mysqli);
    }
    ?>
<?php
include("../../../questions.php");
include("../../../answers.php");

$sql = "SELECT * FROM proyec_pedag_transv WHERE id_cole = $id_cole";
$result = mysqli_query($mysqli, $sql);
$numProjects = 0;

if ($result && mysqli_num_rows($result) > 0) {
   
   
    echo '<div class="container">';
    echo '<div class="college">';
    echo '<h2>' . $nombre_cole . '</h2>';
    echo '</div>';
    echo '<div class="cards-container">'; // Nuevo contenedor para las tarjetas

    while ($row = mysqli_fetch_assoc($result)) {
        
        $nameProject = $selec_proyec_transv = $row['selec_proyec_transv'];
        $numProjects++;

        $id_proyecto = $row['Id_proyec_pedag_transv'];
       
        echo '<a href="./userEditProject.php?id_proyecto=' . $id_proyecto . '&id_cole=' . $id_cole . '" class="project-link">';
        echo '<div class="project-card">';
        echo '<h2 class="project-title">' . $nameProject . '</h2>';
        echo '</div>';
        echo '</a>';
        
      
       
    }
    echo'<div class="back">';
    echo '<button type="reset"  role="link" onclick="window.location.href=\'./../../../access.php\';">';
    echo '<img src="./../../../img/atras.png" width="27" height="27"> REGRESAR';
    echo '</button>';
    echo'</div>';
}
else {
    echo '<div class="container">';
    echo '<h2>' . $nombre_cole . '</h2>';
    echo "No se encontraron proyectos para este colegio.";
    echo '</div>';
    echo'<div class="back">';
    echo '<button type="reset"  role="link" onclick="window.location.href=\'./../../../access.php\';">';
    echo '<img src="./../../../../img/atras.png" width="27" height="27"> REGRESAR';
    echo '</button>';
    echo'</div>';
   
}
?>

</body>
</html>
