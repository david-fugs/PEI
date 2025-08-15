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

// Procesar formulario de actualización
if ($_POST) {
    $fields_to_update = array();
    
    // Lista de campos editables (basado en answers.php)
    $editable_fields = array(
        'num_est_trans', 'num_est_pri', 'num_est_secun', 'num_est_media',
        'inter_doc', 'nac_doc', 'dep_doc', 'local_doc', 'insti_doc',
        'inter_doc_norm', 'nac_doc_norm', 'dep_doc_norm', 'local_doc_norm', 'insti_doc_norm',
        'num_anos_implem', 'si_pei', 'Tem_curr_proy', 'Prob_curr_proy', 'activ_curr_proy',
        'otros', 'si_mes_trab', 'si_prob', 'fuert_prob', 'otro_prob', 'si_sol_prob',
        'fuert_art_areas', 'num_revis_proy', 'anos_rev_proyec', 'fec_act_proyecto',
        'exist_niv_proy', 'exist_niv_proy_1', 'si_pmi', 'si_proy_vin', 'num_est_vin_23',
        'si_vin_conv_esc', 'nomb_lid_proy', 'area_form_proy'
    );
    
    foreach ($editable_fields as $field) {
        if (isset($_POST[$field])) {
            $value = mysqli_real_escape_string($mysqli, $_POST[$field]);
            $fields_to_update[] = "$field = '$value'";
        }
    }
    
    if (!empty($fields_to_update)) {
        $update_sql = "UPDATE proyec_pedag_transv SET " . implode(', ', $fields_to_update) . " WHERE Id_proyec_pedag_transv = $project_id";
        
        if (mysqli_query($mysqli, $update_sql)) {
            // Procesar archivos nuevos si se suben
            if (isset($_FILES["archivo"]) && !empty($_FILES["archivo"]['tmp_name'][0])) {
                // Determinar número de proyecto para archivos
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
                    foreach ($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
                        if ($_FILES["archivo"]["name"][$key]) {
                            $filename = $_FILES["archivo"]["name"][$key];
                            $source = $_FILES["archivo"]["tmp_name"][$key];

                            $directorio = './../projectFiles/' . $id_cole . '/' . $nroProject . '/';
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
            }
            
            if (!isset($error_message)) {
                $_SESSION['message'] = "Proyecto actualizado exitosamente.";
                $_SESSION['message_type'] = "success";
                header("Location: viewProjectDetails.php?id=$project_id");
                exit;
            }
        } else {
            $error_message = "Error al actualizar el proyecto: " . mysqli_error($mysqli);
        }
    }
}

include("../../../questions.php");
include("../../../answers.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
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
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="viewProjectDetails.php?id=<?php echo $project_id; ?>" class="btn btn-secondary">
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
            <h1><i class="fas fa-edit"></i> Editar Proyecto</h1>
            <h4><?php echo htmlspecialchars($project['selec_proyec_transv']); ?></h4>
            <p class="mb-0"><strong>Colegio:</strong> <?php echo htmlspecialchars($nombre_cole); ?></p>
        </div>

        <form method="POST" id="editProjectForm" enctype="multipart/form-data">
            <!-- Información Básica -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-info-circle"></i> Información Básica</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Nombre del Proyecto</strong></label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($project['selec_proyec_transv']); ?>" readonly>
                            <small class="text-muted">El nombre del proyecto no se puede modificar</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomb_lid_proy" class="form-label"><strong>Líder del Proyecto</strong></label>
                            <input type="text" class="form-control" id="nomb_lid_proy" name="nomb_lid_proy" 
                                   value="<?php echo htmlspecialchars($project['nomb_lid_proy'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="area_form_proy" class="form-label"><strong>Área de Formación</strong></label>
                            <input type="text" class="form-control" id="area_form_proy" name="area_form_proy" 
                                   value="<?php echo htmlspecialchars($project['area_form_proy'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="num_anos_implem" class="form-label"><strong>Años de Implementación</strong></label>
                            <input type="number" class="form-control" id="num_anos_implem" name="num_anos_implem" 
                                   value="<?php echo htmlspecialchars($project['num_anos_implem'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estudiantes Vinculados -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-users"></i> Estudiantes Vinculados</h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="num_est_trans" class="form-label"><strong>Transición</strong></label>
                            <input type="number" class="form-control" id="num_est_trans" name="num_est_trans" 
                                   value="<?php echo htmlspecialchars($project['num_est_trans'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="num_est_pri" class="form-label"><strong>Primaria</strong></label>
                            <input type="number" class="form-control" id="num_est_pri" name="num_est_pri" 
                                   value="<?php echo htmlspecialchars($project['num_est_pri'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="num_est_secun" class="form-label"><strong>Secundaria</strong></label>
                            <input type="number" class="form-control" id="num_est_secun" name="num_est_secun" 
                                   value="<?php echo htmlspecialchars($project['num_est_secun'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="num_est_media" class="form-label"><strong>Media</strong></label>
                            <input type="number" class="form-control" id="num_est_media" name="num_est_media" 
                                   value="<?php echo htmlspecialchars($project['num_est_media'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="num_est_vin_23" class="form-label"><strong>Estudiantes Vinculados 2023</strong></label>
                            <input type="number" class="form-control" id="num_est_vin_23" name="num_est_vin_23" 
                                   value="<?php echo htmlspecialchars($project['num_est_vin_23'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos de Soporte -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-file-alt"></i> Documentos de Soporte</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Documentos de Apoyo</h5>
                        <div class="mb-3">
                            <label for="inter_doc" class="form-label">Internacionales</label>
                            <textarea class="form-control" id="inter_doc" name="inter_doc" rows="2"><?php echo htmlspecialchars($project['inter_doc'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nac_doc" class="form-label">Nacionales</label>
                            <textarea class="form-control" id="nac_doc" name="nac_doc" rows="2"><?php echo htmlspecialchars($project['nac_doc'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dep_doc" class="form-label">Departamentales</label>
                            <textarea class="form-control" id="dep_doc" name="dep_doc" rows="2"><?php echo htmlspecialchars($project['dep_doc'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="local_doc" class="form-label">Locales</label>
                            <textarea class="form-control" id="local_doc" name="local_doc" rows="2"><?php echo htmlspecialchars($project['local_doc'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="insti_doc" class="form-label">Institucionales</label>
                            <textarea class="form-control" id="insti_doc" name="insti_doc" rows="2"><?php echo htmlspecialchars($project['insti_doc'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Documentos Normativos</h5>
                        <div class="mb-3">
                            <label for="inter_doc_norm" class="form-label">Internacionales</label>
                            <textarea class="form-control" id="inter_doc_norm" name="inter_doc_norm" rows="2"><?php echo htmlspecialchars($project['inter_doc_norm'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nac_doc_norm" class="form-label">Nacionales</label>
                            <textarea class="form-control" id="nac_doc_norm" name="nac_doc_norm" rows="2"><?php echo htmlspecialchars($project['nac_doc_norm'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dep_doc_norm" class="form-label">Departamentales</label>
                            <textarea class="form-control" id="dep_doc_norm" name="dep_doc_norm" rows="2"><?php echo htmlspecialchars($project['dep_doc_norm'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="local_doc_norm" class="form-label">Locales</label>
                            <textarea class="form-control" id="local_doc_norm" name="local_doc_norm" rows="2"><?php echo htmlspecialchars($project['local_doc_norm'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="insti_doc_norm" class="form-label">Institucionales</label>
                            <textarea class="form-control" id="insti_doc_norm" name="insti_doc_norm" rows="2"><?php echo htmlspecialchars($project['insti_doc_norm'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Integración y Articulación -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-link"></i> Integración y Articulación</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="si_pei" class="form-label"><strong>¿Está integrado al PEI?</strong></label>
                            <select class="form-control" id="si_pei" name="si_pei">
                                <option value="">Seleccione...</option>
                                <option value="Sí" <?php echo ($project['si_pei'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                                <option value="No" <?php echo ($project['si_pei'] == 'No') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="si_pmi" class="form-label"><strong>¿Hace parte del PMI 2023?</strong></label>
                            <select class="form-control" id="si_pmi" name="si_pmi">
                                <option value="">Seleccione...</option>
                                <option value="Sí" <?php echo ($project['si_pmi'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                                <option value="No" <?php echo ($project['si_pmi'] == 'No') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="si_proy_vin" class="form-label"><strong>¿Vinculado al Servicio Social?</strong></label>
                            <select class="form-control" id="si_proy_vin" name="si_proy_vin">
                                <option value="">Seleccione...</option>
                                <option value="Sí" <?php echo ($project['si_proy_vin'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                                <option value="No" <?php echo ($project['si_proy_vin'] == 'No') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="si_vin_conv_esc" class="form-label"><strong>¿Vinculado a Convivencia Escolar?</strong></label>
                            <select class="form-control" id="si_vin_conv_esc" name="si_vin_conv_esc">
                                <option value="">Seleccione...</option>
                                <option value="Sí" <?php echo ($project['si_vin_conv_esc'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                                <option value="No" <?php echo ($project['si_vin_conv_esc'] == 'No') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ejes Curriculares -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-cogs"></i> Ejes de Trabajo Curricular</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Tem_curr_proy" class="form-label"><strong>Temas</strong></label>
                            <textarea class="form-control" id="Tem_curr_proy" name="Tem_curr_proy" rows="3"><?php echo htmlspecialchars($project['Tem_curr_proy'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="Prob_curr_proy" class="form-label"><strong>Problemas</strong></label>
                            <textarea class="form-control" id="Prob_curr_proy" name="Prob_curr_proy" rows="3"><?php echo htmlspecialchars($project['Prob_curr_proy'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="activ_curr_proy" class="form-label"><strong>Actividades</strong></label>
                            <textarea class="form-control" id="activ_curr_proy" name="activ_curr_proy" rows="3"><?php echo htmlspecialchars($project['activ_curr_proy'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="otros" class="form-label"><strong>Otros</strong></label>
                            <textarea class="form-control" id="otros" name="otros" rows="3"><?php echo htmlspecialchars($project['otros'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archivos del Proyecto -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-folder"></i> Archivos del Proyecto</h3>
                <?php
                // Determinar número de proyecto para archivos
                $nameProject = $project['selec_proyec_transv'];
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
                    echo '<i class="fas fa-info-circle"></i> No hay archivos cargados actualmente para este proyecto.';
                    echo '</div>';
                } else {
                    echo '<h5 class="mb-3">Archivos Actuales:</h5>';
                    foreach ($archivos as $archivo) {
                        $file_path = $directorio . $archivo;
                        $file_size = filesize($file_path);
                        $file_size_mb = round($file_size / 1024 / 1024, 2);
                        
                        echo '<div class="d-flex justify-content-between align-items-center p-3 border rounded mb-2">';
                        echo '<div class="d-flex align-items-center">';
                        echo '<i class="fas fa-file me-3"></i>';
                        echo '<div>';
                        echo '<strong>' . htmlspecialchars($archivo) . '</strong><br>';
                        echo '<small class="text-muted">' . $file_size_mb . ' MB</small>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div>';
                        echo '<a href="' . $file_path . '" target="_blank" class="btn btn-sm btn-primary me-2">';
                        echo '<i class="fas fa-download"></i> Descargar';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
                
                <div class="mt-4">
                    <h5>Agregar Nuevos Archivos:</h5>
                    <div class="mb-3">
                        <label for="archivo" class="form-label"><strong>Seleccionar archivos</strong></label>
                        <input type="file" class="form-control" id="archivo" name="archivo[]" multiple>
                        <div class="form-text">Puede seleccionar múltiples archivos manteniendo presionada la tecla Ctrl.</div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="viewProjectDetails.php?id=<?php echo $project_id; ?>" class="btn btn-secondary">
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
        document.getElementById('editProjectForm').addEventListener('submit', function(e) {
            if (!confirm('¿Está seguro de que desea guardar los cambios realizados?')) {
                e.preventDefault();
            }
        });
    </script>

</body>

</html>
