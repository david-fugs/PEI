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
    <title>Detalles del Colegio</title>
    <link rel="stylesheet" href="./../../../css/viewProject.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
    <center style="margin-top: 20px;">
        <img src='../../../img/logo_educacion_fondo_azul.png' width="500" height="200" class="responsive">
    </center>
    <br />
    <center>
        <a href="../../ie/showIe.php"><img src='../../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>
    </center>

    <?php
    include("../../../conexion.php");
    require_once '../../../sessionCheck.php';


    ?>

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
        echo '<div class="college " style="margin-top: 25px;">';
        echo '<h2>' . $nombre_cole . '</h2>';

        echo '</div>';
        //preguntar si es necesario el agregar pedagogico transversal
        echo '			<div class="d-flex justify-content-end p-3 mr-1" style="margin-right: 45px;"  >
				<a href="../proyect_transv1.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow  pl-3 mr-4">
					<i class="fas fa-plus"></i>
					<span>Agregar Proyecto pedagogico transversal </span>
				</a>
                <a href="userListFiles.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow  pl-3 mr-4">
					<i class="fas fa-plus"></i>
					<span>Ver Archivos </span>
				</a>

                    <a href="userListProject.php" class="btn btn-warning btn-lg d-flex align-items-center gap-2 rounded-pill shadow  pl-3 mr-4">
					<i class="fas fa-plus"></i>
					<span>Editar  </span>
				</a>

			</div>
        ';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="container">';
            $nameProject = $selec_proyec_transv = $row['selec_proyec_transv'];
            $numProjects++;
            $id_project = $id_proyecto = $row['Id_proyec_pedag_transv'];
            // echo '<h2>' . $id_project . '</h2>';
            foreach ($answers as $index => $columnName) {
                echo '<div class="project">';
                echo '<div class="question">' . $questions[$index] . '</div>';
                echo '<div class="answer">' . $row[$columnName] . '</div>';
                echo '</div>';
            }
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
                $directorio = './../projectFiles/' . $id_cole . '/' . $nroProject . '/';

                if (is_dir($directorio)) {
                    $archivos = scandir($directorio);
                    $archivos = array_diff($archivos, array('.', '..'));
                }
            }
            echo '<h4>Archivos Cargados en el proyecto ' . $nameProject . ':</h4>';
            echo '<ul>';
            if (empty($archivos)) {
                echo '<li>No se han cargado archivos</li>';
            } else {
                echo '<ul>';
                if (empty($archivos)) {
                    echo '<li>Carpeta vacía</li>';
                } else {
                    foreach ($archivos as $archivo) {
                        echo '<li><a href="' . $directorio . '/' . $archivo . '" target="_blank">' . $archivo . '</a></li>';
                    }
                }
                echo '</ul>';
            }
            echo '</ul>';

            $iconStyle = "style='width: 40px; height: 40px; max-width: 100%; '";
            $ruteIcon = "./../../../../img/excel.png";
            $excel = "<a href='./admin/excel.php?id_cole=" . $id_cole . "&nombre_cole=" . $nombre_cole . "&nroProject=" . $nroProject . "'>Descargar archivo Excel</a>";
            echo '<div class="excel-container">';
            echo "$excel";

            echo '</div>';
            echo '</div>';
            $iconStyle = "style='width: 40px; height: 40px; max-width: 100%;'";
            $ruteIcon = "./../../../../img/excel.png";
            $excels = "<a class='excel-button' href='./admin/excels.php?id_cole=" . $id_cole . "&nombre_cole=" . $nombre_cole . "&nroProject=" . $nroProject . "'>Descargar Excel de todos los proyectos</a>";
            echo '<div class="project-separator">
        
        </div>';
        }
        echo '<div class="report">';
        echo $excels;
        echo '</div>';
        echo '<div class="back">';
        echo '<button type="reset"  role="link" onclick="window.location.href=\'./../../../access.php\';">';
        echo '<img src="./../../../img/atras.png" width="27" height="27"> REGRESAR';
        echo '</button>';
        echo '</div>';

        echo '<footer class="site-footer">';
        echo '<p></p>';
        echo '</footer>';
    } else {
        echo '<div class="container">';
        echo '<h2>' . $nombre_cole . '</h2>';
        echo '			<div class="d-flex justify-content-end p-3 mr-1" style="margin-right: 45px;"  >
				<a href="../proyect_transv1.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow  pl-3 mr-4">
					<i class="fas fa-plus"></i>
					<span>Agregar Proyectos pedagogicos tranversales </span>
				</a>
			</div>
        ';
        echo "No se encontraron proyectos para este colegio.";
        echo '</div>';
    }
    ?>

</body>

</html>