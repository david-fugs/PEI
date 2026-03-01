<?php
include("./../../../conexion.php");
require_once './../../../sessionCheck.php';
include_once(__DIR__ . '/../../../adminViewHelper.php'); // Asegurar que esté disponible

// El $id_cole ya está definido correctamente en sessionCheck.php
// que incluye el adminViewHelper.php y maneja el modo administrador

// Validar que tengamos un id_cole válido
if (empty($id_cole)) {
    die("Error: No se pudo determinar la institución educativa. Por favor, contacte al administrador.");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .table th {
            background-color: #343a40;
            color: white;
            border: none;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .college h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .project-name {
            text-align: left !important;
            font-weight: 500;
        }

        .leader-name {
            text-align: left !important;
        }
    </style>

</head>

<body>
    <?php
    // Mostrar banner si está en modo administrador
    showAdminViewBanner();
    ?>

    <center style="margin-top: 20px;">
        <img src='../../../img/logo_educacion_fondo_azul.png' width="500" height="200" class="responsive">
    </center>
    <br />
    <center>
        <?php if (isAdminViewMode()): ?>
            <a href="javascript:window.close();"><img src='../../../img/atras.png' width="72" height="72" title="Cerrar Ventana" /></a><br>
        <?php else: ?>
            <a href="../../ie/showIe.php"><img src='../../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>
        <?php endif; ?>
    </center>

    <?php
    // Mostrar mensajes de éxito o error
    if (isset($_SESSION['message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php if ($_SESSION['message_type'] == 'success'): ?>
                    <i class="fas fa-check-circle"></i>
                <?php else: ?>
                    <i class="fas fa-exclamation-triangle"></i>
                <?php endif; ?>
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    endif; ?>

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
    $sql = "SELECT * FROM proyec_pedag_transv WHERE id_cole = $id_cole";
    $result = mysqli_query($mysqli, $sql);
    $numProjects = 0;

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<div class="college" style="margin-top: 25px;">';
        echo '<h2>' . $nombre_cole . '</h2>';
        echo '</div>';

        // Botones de acción
        echo '<div class="d-flex justify-content-center align-items-center p-3 gap-3" style="margin: 0 45px;">';
        echo '<a href="../proyect_transv1.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow px-4">';
        echo '<i class="fas fa-plus"></i>';
        echo '<span>Agregar Proyecto</span>';
        echo '</a>';
        echo '<a href="userListFiles.php" class="btn btn-info btn-lg d-flex align-items-center gap-2 rounded-pill shadow px-4">';
        echo '<i class="fas fa-folder"></i>';
        echo '<span>Ver Archivos</span>';
        echo '</a>';
        echo '<a href="./admin/excels.php?id_cole=' . $id_cole . '&nombre_cole=' . $nombre_cole . '" class="btn btn-secondary btn-lg d-flex align-items-center gap-2 rounded-pill shadow px-4">';
        echo '<i class="fas fa-file-excel"></i>';
        echo '<span>Exportar Todo</span>';
        echo '</a>';
        echo '</div>';

        // Tabla de proyectos
        echo '<div class="container mt-4">';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-hover">';
        echo '<thead class="table-dark">';
        echo '<tr>';
        echo '<th scope="col">#</th>';
        echo '<th scope="col">Nombre del Proyecto</th>';
        echo '<th scope="col">Líder del Proyecto</th>';
        echo '<th scope="col">Años de Implementación</th>';
        echo '<th scope="col">Estudiantes Vinculados 2023</th>';
        echo '<th scope="col">Archivos</th>';
        echo '<th scope="col">Acciones</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            $numProjects++;
            $id_project = $row['Id_proyec_pedag_transv'];
            $nameProject = $row['selec_proyec_transv'];
            $lider = $row['nomb_lid_proy'] ?? 'No asignado';
            $anos_implementacion = $row['num_anos_implem'] ?? 'No especificado';
            $estudiantes_vinculados = $row['num_est_vin_23'] ?? '0';

            // Determinar número de proyecto para archivos
            $nroProject = 0;
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

            // Contar archivos
            $num_archivos = 0;
            if ($nroProject >= 1 && $nroProject <= 4) {
                $directorio = './../projectFiles/' . $id_cole . '/' . $nroProject . '/';
                if (is_dir($directorio)) {
                    $archivos = scandir($directorio);
                    $archivos = array_diff($archivos, array('.', '..'));
                    $num_archivos = count($archivos);
                }
            }

            echo '<tr>';
            echo '<th scope="row">' . $numProjects . '</th>';
            echo '<td class="project-name"><strong>' . htmlspecialchars($nameProject) . '</strong></td>';
            echo '<td class="leader-name">' . htmlspecialchars($lider) . '</td>';
            echo '<td>' . htmlspecialchars($anos_implementacion) . '</td>';
            echo '<td>' . htmlspecialchars($estudiantes_vinculados) . '</td>';
            echo '<td>';
            if ($num_archivos > 0) {
                echo '<span class="badge bg-success">' . $num_archivos . ' archivo(s)</span>';
            } else {
                echo '<span class="badge bg-warning">Sin archivos</span>';
            }
            echo '</td>';
            echo '<td>';
            echo '<div class="btn-group" role="group">';
            echo '<a href="viewProjectDetails.php?id=' . $id_project . '" class="btn btn-primary btn-sm" title="Ver detalles">';
            echo '<i class="fas fa-eye"></i>';
            echo '</a>';
            echo '<a href="editProject.php?id=' . $id_project . '" class="btn btn-warning btn-sm" title="Editar">';
            echo '<i class="fas fa-edit"></i>';
            echo '</a>';
            if ($nroProject > 0) {
                echo '<a href="./admin/excel.php?id_cole=' . $id_cole . '&nombre_cole=' . $nombre_cole . '&nroProject=' . $nroProject . '" class="btn btn-success btn-sm" title="Exportar Excel">';
                echo '<i class="fas fa-file-excel"></i>';
                echo '</a>';
            }
            echo '<button type="button" class="btn btn-danger btn-sm" title="Eliminar" onclick="deleteProject(' . $id_project . ', \'' . addslashes($nameProject) . '\')">';
            echo '<i class="fas fa-trash"></i>';
            echo '</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';

        // Nueva tabla para Proyectos y Planes
        echo '<div class="container mt-5">';
        echo '<div class="d-flex justify-content-between align-items-center mb-3">';
        echo '<h3 class="text-primary"><i class="fas fa-project-diagram"></i> Proyectos y Planes</h3>';
        echo '<a href="../../plans/addplans1.php" class="btn btn-success d-flex align-items-center gap-2 rounded-pill shadow px-3">';
        echo '<i class="fas fa-plus"></i>';
        echo '<span>Agregar Proyecto/Plan</span>';
        echo '</a>';
        echo '</div>';

        // Consulta para proyectos y planes
        $sql_plans = "SELECT * FROM proyectos_planes WHERE id_cole = $id_cole";
        $result_plans = mysqli_query($mysqli, $sql_plans);

        if ($result_plans && mysqli_num_rows($result_plans) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-hover">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th scope="col">#</th>';
            echo '<th scope="col">Nombre del Proyecto/Plan</th>';
            echo '<th scope="col">Tipo</th>';
            echo '<th scope="col">Fecha de Creación</th>';
            echo '<th scope="col">Archivos</th>';
            echo '<th scope="col">Acciones</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $numPlans = 0;
            while ($plan = mysqli_fetch_assoc($result_plans)) {
                $numPlans++;
                $id_plan = $plan['id_proy_plan'];
                $nombre_plan = $plan['nombre_proy_plan'];
                $tipo_plan = $plan['tipo_proy_plan'];
                $fecha_creacion = date('d/m/Y', strtotime($plan['fecha_alta_proy_plan']));

                // Contar archivos del plan
                $directorio_plan = './../plans/files/' . $id_plan . '/';
                $num_archivos_plan = 0;
                if (is_dir($directorio_plan)) {
                    $archivos_plan = scandir($directorio_plan);
                    $archivos_plan = array_diff($archivos_plan, array('.', '..'));
                    $num_archivos_plan = count($archivos_plan);
                }

                echo '<tr>';
                echo '<th scope="row">' . $numPlans . '</th>';
                echo '<td class="project-name"><strong>' . htmlspecialchars($nombre_plan) . '</strong></td>';
                echo '<td>' . htmlspecialchars($tipo_plan) . '</td>';
                echo '<td>' . $fecha_creacion . '</td>';
                echo '<td>';
                if ($num_archivos_plan > 0) {
                    echo '<span class="badge bg-success">' . $num_archivos_plan . ' archivo(s)</span>';
                } else {
                    echo '<span class="badge bg-warning">Sin archivos</span>';
                }
                echo '</td>';
                echo '<td>';
                echo '<div class="btn-group" role="group">';
                echo '<a href="viewPlanDetails.php?id=' . $id_plan . '" class="btn btn-primary btn-sm" title="Ver detalles">';
                echo '<i class="fas fa-eye"></i>';
                echo '</a>';
                echo '<a href="editPlan.php?id=' . $id_plan . '" class="btn btn-warning btn-sm" title="Editar">';
                echo '<i class="fas fa-edit"></i>';
                echo '</a>';
                echo '<a href="../../plans/find_doc.php?id_proy_plan=' . $id_plan . '" class="btn btn-info btn-sm" title="Ver archivos">';
                echo '<i class="fas fa-folder"></i>';
                echo '</a>';
                echo '<button type="button" class="btn btn-danger btn-sm" title="Eliminar" onclick="deletePlan(' . $id_plan . ', \'' . addslashes($nombre_plan) . '\')">';
                echo '<i class="fas fa-trash"></i>';
                echo '</button>';
                echo '</div>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-info text-center">';
            echo '<h5>No se encontraron proyectos o planes para este colegio.</h5>';
            echo '<p>Comience agregando su primer proyecto o plan.</p>';
            echo '</div>';
        }
        echo '</div>';

        echo '<div class="back text-center mt-4">';
        echo '<button type="button" class="btn btn-secondary" onclick="window.location.href=\'./../../../access.php\';">';
        echo '<img src="./../../../img/atras.png" width="27" height="27"> REGRESAR';
        echo '</button>';
        echo '</div>';
    } else {
        echo '<div class="container">';
        echo '<h2>' . $nombre_cole . '</h2>';
        echo '<div class="d-flex justify-content-center align-items-center p-3 gap-3">';
        echo '<a href="../proyect_transv1.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow px-4">';
        echo '<i class="fas fa-plus"></i>';
        echo '<span>Agregar Proyectos Pedagógicos Transversales</span>';
        echo '</a>';
        echo '</div>';
        echo '<div class="alert alert-info text-center">';
        echo '<h4>No se encontraron proyectos para este colegio.</h4>';
        echo '<p>Comience agregando su primer proyecto pedagógico transversal.</p>';
        echo '</div>';

        // Mostrar tabla de proyectos y planes aunque no haya proyectos transversales
        echo '<div class="mt-5">';
        echo '<div class="d-flex justify-content-between align-items-center mb-3">';
        echo '<h3 class="text-primary"><i class="fas fa-project-diagram"></i> Proyectos y Planes</h3>';
        echo '<a href="../../plans/addplans1.php" class="btn btn-success d-flex align-items-center gap-2 rounded-pill shadow px-3">';
        echo '<i class="fas fa-plus"></i>';
        echo '<span>Agregar Proyecto/Plan</span>';
        echo '</a>';
        echo '</div>';

        // Consulta para proyectos y planes
        $sql_plans = "SELECT * FROM proyectos_planes WHERE id_cole = $id_cole";
        $result_plans = mysqli_query($mysqli, $sql_plans);

        if ($result_plans && mysqli_num_rows($result_plans) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-hover">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th scope="col">#</th>';
            echo '<th scope="col">Nombre del Proyecto/Plan</th>';
            echo '<th scope="col">Tipo</th>';
            echo '<th scope="col">Fecha de Creación</th>';
            echo '<th scope="col">Archivos</th>';
            echo '<th scope="col">Acciones</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $numPlans = 0;
            while ($plan = mysqli_fetch_assoc($result_plans)) {
                $numPlans++;
                $id_plan = $plan['id_proy_plan'];
                $nombre_plan = $plan['nombre_proy_plan'];
                $tipo_plan = $plan['tipo_proy_plan'];
                $fecha_creacion = date('d/m/Y', strtotime($plan['fecha_alta_proy_plan']));

                // Contar archivos del plan
                $directorio_plan = './../plans/files/' . $id_plan . '/';
                $num_archivos_plan = 0;
                if (is_dir($directorio_plan)) {
                    $archivos_plan = scandir($directorio_plan);
                    $archivos_plan = array_diff($archivos_plan, array('.', '..'));
                    $num_archivos_plan = count($archivos_plan);
                }

                echo '<tr>';
                echo '<th scope="row">' . $numPlans . '</th>';
                echo '<td class="project-name"><strong>' . htmlspecialchars($nombre_plan) . '</strong></td>';
                echo '<td>' . htmlspecialchars($tipo_plan) . '</td>';
                echo '<td>' . $fecha_creacion . '</td>';
                echo '<td>';
                if ($num_archivos_plan > 0) {
                    echo '<span class="badge bg-success">' . $num_archivos_plan . ' archivo(s)</span>';
                } else {
                    echo '<span class="badge bg-warning">Sin archivos</span>';
                }
                echo '</td>';
                echo '<td>';
                echo '<div class="btn-group" role="group">';
                echo '<a href="viewPlanDetails.php?id=' . $id_plan . '" class="btn btn-primary btn-sm" title="Ver detalles">';
                echo '<i class="fas fa-eye"></i>';
                echo '</a>';
                echo '<a href="editPlan.php?id=' . $id_plan . '" class="btn btn-warning btn-sm" title="Editar">';
                echo '<i class="fas fa-edit"></i>';
                echo '</a>';
                echo '<a href="../plans/find_doc.php?id_proy_plan=' . $id_plan . '" class="btn btn-info btn-sm" title="Ver archivos">';
                echo '<i class="fas fa-folder"></i>';
                echo '</a>';
                echo '<button type="button" class="btn btn-danger btn-sm" title="Eliminar" onclick="deletePlan(' . $id_plan . ', \'' . addslashes($nombre_plan) . '\')">';
                echo '<i class="fas fa-trash"></i>';
                echo '</button>';
                echo '</div>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-info text-center">';
            echo '<h5>No se encontraron proyectos o planes para este colegio.</h5>';
            echo '<p>Comience agregando su primer proyecto o plan.</p>';
            echo '</div>';
        }
        echo '</div>';

        echo '<div class="back text-center mt-4">';
        echo '<button type="button" class="btn btn-secondary" onclick="window.location.href=\'./../../../access.php\';">';
        echo '<img src="./../../../img/atras.png" width="27" height="27"> REGRESAR';
        echo '</button>';
        echo '</div>';
        echo '</div>';
    }
    ?>

    <script>
        function deleteProject(projectId, projectName) {
            if (confirm('¿Está seguro de que desea eliminar el proyecto "' + projectName + '"?\n\nEsta acción no se puede deshacer y eliminará también todos los archivos asociados.')) {
                window.location.href = 'deleteProject.php?id=' + projectId;
            }
        }

        function deletePlan(planId, planName) {
            if (confirm('¿Está seguro de que desea eliminar el proyecto/plan "' + planName + '"?\n\nEsta acción no se puede deshacer y eliminará también todos los archivos asociados.')) {
                window.location.href = 'deletePlan.php?id=' + planId;
            }
        }
    </script>

</body>

</html>