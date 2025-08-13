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

// Procesar formulario de actualización
if ($_POST) {
    $nombre_proy_plan = mysqli_real_escape_string($mysqli, $_POST['nombre_proy_plan']);
    $tipo_proy_plan = mysqli_real_escape_string($mysqli, $_POST['tipo_proy_plan']);
    $obs_proy_plan = mysqli_real_escape_string($mysqli, $_POST['obs_proy_plan']);
    $fecha_edit_proy_plan = date('Y-m-d H:i:s');
    
    $update_sql = "UPDATE proyectos_planes SET 
                   nombre_proy_plan = '$nombre_proy_plan', 
                   tipo_proy_plan = '$tipo_proy_plan', 
                   obs_proy_plan = '$obs_proy_plan',
                   fecha_edit_proy_plan = '$fecha_edit_proy_plan'
                   WHERE id_proy_plan = $plan_id";
    
    if (mysqli_query($mysqli, $update_sql)) {
        // Procesar archivos nuevos si se suben
        if (isset($_FILES["archivo"]) && !empty($_FILES["archivo"]['tmp_name'][0])) {
            foreach ($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
                if ($_FILES["archivo"]["name"][$key]) {
                    $filename = $_FILES["archivo"]["name"][$key];
                    $source = $_FILES["archivo"]["tmp_name"][$key];

                    $directorio = './../plans/files/' . $plan_id . '/';
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }

                    $target_path = $directorio . $filename;

                    if (!move_uploaded_file($source, $target_path)) {
                        $error_message = "Ha ocurrido un error al subir el archivo: " . $filename;
                    }
                }
            }
        }
        
        if (!isset($error_message)) {
            $_SESSION['message'] = "Plan actualizado exitosamente.";
            $_SESSION['message_type'] = "success";
            header("Location: viewPlanDetails.php?id=$plan_id");
            exit;
        }
    } else {
        $error_message = "Error al actualizar el plan: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Plan</title>
    <link rel="stylesheet" href="./../../../css/viewProject.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .form-section {
            margin-bottom: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
        }
        .section-title {
            color: #495057;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .project-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .file-item {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <center style="margin-top: 20px;">
        <img src='../../../img/logo_educacion_fondo_azul.png' width="500" height="200" class="responsive">
    </center>
    <br />
    
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="viewPlanDetails.php?id=<?php echo $plan_id; ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Detalles
            </a>
            <a href="userViewProject.php" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> Lista de Proyectos
            </a>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="project-header">
            <h1><i class="fas fa-edit"></i> Editar Plan</h1>
            <h4><?php echo htmlspecialchars($plan['nombre_proy_plan']); ?></h4>
            <p class="mb-0"><strong>Colegio:</strong> <?php echo htmlspecialchars($nombre_cole); ?></p>
        </div>

        <form method="POST" id="editPlanForm" enctype="multipart/form-data">
            <!-- Información Básica -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-info-circle"></i> Información Básica</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre_proy_plan" class="form-label"><strong>Nombre del Proyecto/Plan</strong></label>
                            <input type="text" class="form-control" id="nombre_proy_plan" name="nombre_proy_plan" 
                                   value="<?php echo htmlspecialchars($plan['nombre_proy_plan']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tipo_proy_plan" class="form-label"><strong>Tipo</strong></label>
                            <select class="form-control" id="tipo_proy_plan" name="tipo_proy_plan" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="Proyecto" <?php echo ($plan['tipo_proy_plan'] == 'Proyecto') ? 'selected' : ''; ?>>Proyecto</option>
                                <option value="Plan" <?php echo ($plan['tipo_proy_plan'] == 'Plan') ? 'selected' : ''; ?>>Plan</option>
                                <option value="Programa" <?php echo ($plan['tipo_proy_plan'] == 'Programa') ? 'selected' : ''; ?>>Programa</option>
                                <option value="Otro" <?php echo ($plan['tipo_proy_plan'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="obs_proy_plan" class="form-label"><strong>Observaciones</strong></label>
                    <textarea class="form-control" id="obs_proy_plan" name="obs_proy_plan" rows="4"><?php echo htmlspecialchars($plan['obs_proy_plan'] ?? ''); ?></textarea>
                </div>
            </div>

            <!-- Archivos Existentes -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-folder"></i> Archivos Actuales</h3>
                <?php
                $archivos = array();
                $directorio = './../plans/files/' . $plan_id . '/';
                if (is_dir($directorio)) {
                    $archivos = scandir($directorio);
                    $archivos = array_diff($archivos, array('.', '..'));
                }

                if (empty($archivos)) {
                    echo '<div class="alert alert-info">';
                    echo '<i class="fas fa-info-circle"></i> No hay archivos cargados actualmente.';
                    echo '</div>';
                } else {
                    foreach ($archivos as $archivo) {
                        $file_path = $directorio . $archivo;
                        $file_size = filesize($file_path);
                        $file_size_mb = round($file_size / 1024 / 1024, 2);
                        
                        echo '<div class="file-item">';
                        echo '<div class="d-flex align-items-center flex-grow-1">';
                        echo '<i class="fas fa-file me-2"></i>';
                        echo '<div>';
                        echo '<strong>' . htmlspecialchars($archivo) . '</strong><br>';
                        echo '<small class="text-muted">' . $file_size_mb . ' MB</small>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div>';
                        echo '<a href="' . $file_path . '" target="_blank" class="btn btn-sm btn-primary me-2">';
                        echo '<i class="fas fa-download"></i> Descargar';
                        echo '</a>';
                        echo '<button type="button" class="btn btn-sm btn-danger" onclick="deleteFile(\'' . $archivo . '\')">';
                        echo '<i class="fas fa-trash"></i> Eliminar';
                        echo '</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <!-- Subir Nuevos Archivos -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-upload"></i> Agregar Nuevos Archivos</h3>
                <div class="mb-3">
                    <label for="archivo" class="form-label"><strong>Seleccionar archivos</strong></label>
                    <input type="file" class="form-control" id="archivo" name="archivo[]" multiple>
                    <div class="form-text">Puede seleccionar múltiples archivos manteniendo presionada la tecla Ctrl.</div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="viewPlanDetails.php?id=<?php echo $plan_id; ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <footer class="mt-5 py-4 bg-light text-center">
        <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión PEI</p>
    </footer>

    <script>
        // Confirmar antes de enviar el formulario
        document.getElementById('editPlanForm').addEventListener('submit', function(e) {
            if (!confirm('¿Está seguro de que desea guardar los cambios realizados?')) {
                e.preventDefault();
            }
        });

        // Función para eliminar archivos
        function deleteFile(filename) {
            if (confirm('¿Está seguro de que desea eliminar el archivo "' + filename + '"?')) {
                // Aquí puedes implementar la lógica para eliminar el archivo
                // Por ahora solo mostramos una alerta
                alert('Funcionalidad de eliminación de archivos pendiente de implementar.');
            }
        }
    </script>

</body>

</html>
