<?php
include("./../../../conexion.php");
require_once './../../../sessionCheck.php';

$id_usu = $_SESSION['user']['id'];
$plan_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($plan_id == 0) {
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

// Obtener información del plan
$sql_plan = "SELECT * FROM proyectos_planes WHERE id_proy_plan = $plan_id AND id_cole = $id_cole";
$result_plan = mysqli_query($mysqli, $sql_plan);

if (!$result_plan || mysqli_num_rows($result_plan) == 0) {
    echo "Plan no encontrado.";
    exit;
}

$plan = mysqli_fetch_assoc($result_plan);

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Plan</title>
    <link rel="stylesheet" href="./../../../css/viewProject.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .info-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #007bff;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .project-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
                <a href="editPlan.php?id=<?php echo $plan_id; ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar Plan
                </a>
                <a href="../plans/find_doc.php?id_proy_plan=<?php echo $plan_id; ?>" class="btn btn-info ml-2">
                    <i class="fas fa-folder"></i> Ver Archivos
                </a>
                <button type="button" class="btn btn-danger ml-2" onclick="deletePlan(<?php echo $plan_id; ?>, '<?php echo addslashes($plan['nombre_proy_plan']); ?>')">
                    <i class="fas fa-trash"></i> Eliminar Plan
                </button>
            </div>
        </div>

        <div class="project-header">
            <h1><i class="fas fa-clipboard-list"></i> <?php echo htmlspecialchars($plan['nombre_proy_plan']); ?></h1>
            <h4><?php echo htmlspecialchars($nombre_cole); ?></h4>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-info-circle"></i> Información del Plan</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-card">
                            <h5><strong>Nombre del Proyecto/Plan:</strong></h5>
                            <p><?php echo htmlspecialchars($plan['nombre_proy_plan']); ?></p>
                        </div>

                        <div class="info-card">
                            <h5><strong>Tipo:</strong></h5>
                            <p><?php echo htmlspecialchars($plan['tipo_proy_plan']); ?></p>
                        </div>

                        <div class="info-card">
                            <h5><strong>Observaciones:</strong></h5>
                            <p><?php echo htmlspecialchars($plan['obs_proy_plan'] ?? 'Sin observaciones'); ?></p>
                        </div>

                        <div class="info-card">
                            <h5><strong>Fechas:</strong></h5>
                            <p><strong>Fecha de creación:</strong> <?php echo date('d/m/Y H:i', strtotime($plan['fecha_alta_proy_plan'])); ?></p>
                            <?php if ($plan['fecha_edit_proy_plan'] != '0000-00-00 00:00:00'): ?>
                                <p><strong>Última edición:</strong> <?php echo date('d/m/Y H:i', strtotime($plan['fecha_edit_proy_plan'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-folder-open"></i> Archivos del Plan</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $archivos = array();
                        $directorio = './../plans/files/' . $plan_id . '/';
                        if (is_dir($directorio)) {
                            $archivos = scandir($directorio);
                            $archivos = array_diff($archivos, array('.', '..'));
                        }

                        if (empty($archivos)) {
                            echo '<div class="alert alert-info">';
                            echo '<i class="fas fa-info-circle"></i> No se han cargado archivos para este plan.';
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
                        <h5><i class="fas fa-chart-bar"></i> Resumen</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>ID del Plan:</strong></td>
                                <td><?php echo $plan_id; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Archivos cargados:</strong></td>
                                <td><?php echo count($archivos); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Estado:</strong></td>
                                <td>
                                    <?php if (count($archivos) > 0): ?>
                                        <span class="badge bg-success">Con archivos</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Sin archivos</span>
                                    <?php endif; ?>
                                </td>
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
        function deletePlan(planId, planName) {
            if (confirm('¿Está seguro de que desea eliminar el proyecto/plan "' + planName + '"?\n\nEsta acción no se puede deshacer y eliminará también todos los archivos asociados.')) {
                window.location.href = 'deletePlan.php?id=' + planId;
            }
        }
    </script>

</body>

</html>
