<?php
include("./../../../conexion.php");
require_once './../../../sessionCheck.php';

$id_usu = $_SESSION['user']['id'];
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($project_id == 0) {
    header("Location: userViewProject.php");
    exit;
}

// Obtener información del usuario y colegio
$sql_id_cole = "SELECT id_cole FROM usuarios WHERE id = $id_usu";
$result = mysqli_query($mysqli, $sql_id_cole);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_cole = $row['id_cole'];
} else {
    echo "No se encontró el id_cole asociado a este usuario.";
    exit;
}

// Obtener información del proyecto
$sql_project = "SELECT * FROM proyec_pedag_transv WHERE Id_proyec_pedag_transv = $project_id AND id_cole = $id_cole";
$result_project = mysqli_query($mysqli, $sql_project);

if (!$result_project || mysqli_num_rows($result_project) == 0) {
    echo "Proyecto no encontrado.";
    exit;
}

$project = mysqli_fetch_assoc($result_project);

// Obtener el nombre del colegio
$sql = "SELECT nombre_cole FROM colegios WHERE id_cole = $id_cole";
$result = mysqli_query($mysqli, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $nombre_cole = $row['nombre_cole'];
} else {
    echo "Error en la consulta: " . mysqli_error($mysqli);
}

include("../../../questions.php");
include("../../../answers.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto</title>
    <link rel="stylesheet" href="./../../../css/viewProject.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .question {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .answer {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #007bff;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .project-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <center style="margin-top: 20px;">
        <img src='../../../img/logo_educacion_fondo_azul.png' width="500" height="200" class="responsive">
    </center>
    <br />
    
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="userViewProject.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
            <div>
                <a href="editProject.php?id=<?php echo $project_id; ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar Proyecto
                </a>
                <?php
                $nameProject = $project['selec_proyec_transv'];
                $nroProject = 0;
                switch ($nameProject) {
                    case "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC":
                        $nroProject = 1;
                        break;
                    case "PROYECTO DE EDUCACION AMBIENTAL PRAE":
                        $nroProject = 2;
                        break;
                    case "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS":
                        $nroProject = 3;
                        break;
                    case "PROYECTO DE EDUCACION VIAL":
                        $nroProject = 4;
                        break;
                }
                if ($nroProject > 0) {
                    echo '<a href="./admin/excel.php?id_cole=' . $id_cole . '&nombre_cole=' . $nombre_cole . '&nroProject=' . $nroProject . '" class="btn btn-success ml-2">';
                    echo '<i class="fas fa-file-excel"></i> Exportar Excel';
                    echo '</a>';
                }
                ?>
                <button type="button" class="btn btn-danger ml-2" onclick="deleteProject(<?php echo $project_id; ?>, '<?php echo addslashes($nameProject); ?>')">
                    <i class="fas fa-trash"></i> Eliminar Proyecto
                </button>
            </div>
        </div>

        <div class="project-header">
            <h1><i class="fas fa-project-diagram"></i> <?php echo htmlspecialchars($project['selec_proyec_transv']); ?></h1>
            <h4><?php echo htmlspecialchars($nombre_cole); ?></h4>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-info-circle"></i> Información Detallada del Proyecto</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        foreach ($answers as $index => $columnName) {
                            if (!empty($project[$columnName])) {
                                echo '<div class="question">' . $questions[$index] . '</div>';
                                echo '<div class="answer">' . htmlspecialchars($project[$columnName]) . '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-folder-open"></i> Archivos del Proyecto</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $archivos = array();
                        if ($nroProject >= 1 && $nroProject <= 4) {
                            $directorio = './../projectFiles/' . $id_cole . '/' . $nroProject . '/';
                            if (is_dir($directorio)) {
                                $archivos = scandir($directorio);
                                $archivos = array_diff($archivos, array('.', '..'));
                            }
                        }

                        if (empty($archivos)) {
                            echo '<div class="alert alert-info">';
                            echo '<i class="fas fa-info-circle"></i> No se han cargado archivos para este proyecto.';
                            echo '</div>';
                        } else {
                            echo '<div class="list-group">';
                            foreach ($archivos as $archivo) {
                                $file_path = $directorio . $archivo;
                                $file_size = filesize($file_path);
                                $file_size_mb = round($file_size / 1024 / 1024, 2);
                                
                                echo '<a href="' . $file_path . '" target="_blank" class="list-group-item list-group-item-action">';
                                echo '<div class="d-flex w-100 justify-content-between">';
                                echo '<h6 class="mb-1"><i class="fas fa-file"></i> ' . htmlspecialchars($archivo) . '</h6>';
                                echo '<small>' . $file_size_mb . ' MB</small>';
                                echo '</div>';
                                echo '</a>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-bar"></i> Resumen Rápido</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Líder:</strong></td>
                                <td><?php echo htmlspecialchars($project['nomb_lid_proy'] ?? 'No asignado'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Años de implementación:</strong></td>
                                <td><?php echo htmlspecialchars($project['num_anos_implem'] ?? 'No especificado'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Estudiantes vinculados 2023:</strong></td>
                                <td><?php echo htmlspecialchars($project['num_est_vin_23'] ?? '0'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Integrado al PEI:</strong></td>
                                <td><?php echo htmlspecialchars($project['si_pei'] ?? 'No especificado'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Archivos cargados:</strong></td>
                                <td><?php echo count($archivos); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-4 bg-light text-center">
        <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión PEI</p>
    </footer>

    <script>
        function deleteProject(projectId, projectName) {
            if (confirm('¿Está seguro de que desea eliminar el proyecto "' + projectName + '"?\n\nEsta acción no se puede deshacer y eliminará también todos los archivos asociados.')) {
                window.location.href = 'deleteProject.php?id=' + projectId;
            }
        }
    </script>

</body>

</html>
