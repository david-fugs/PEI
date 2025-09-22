<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo "Error: Sesión no válida";
    exit();
}

include("../../conexion.php");

$circular_id = isset($_GET['circular_id']) ? intval($_GET['circular_id']) : 0;
$id_cole = $_SESSION['id_cole'];

if ($circular_id == 0) {
    echo "Error: ID de circular no válido";
    exit();
}

// Obtener información de la circular
$sql_circular = "SELECT * FROM circulares WHERE id = $circular_id";
$result_circular = mysqli_query($mysqli, $sql_circular);
$circular = mysqli_fetch_assoc($result_circular);

if (!$circular) {
    echo "Error: Circular no encontrada";
    exit();
}

// Obtener información de la institución para esta circular
$sql_institucion = "SELECT * FROM circular_instituciones WHERE circular_id = $circular_id AND id_cole = $id_cole";
$result_institucion = mysqli_query($mysqli, $sql_institucion);
$institucion_data = mysqli_fetch_assoc($result_institucion);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">
                <i class="fas fa-bell me-2"></i>
                <?php echo htmlspecialchars($circular['titulo']); ?>
            </h4>
            
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-md-8">
                        <strong>Descripción:</strong><br>
                        <?php echo htmlspecialchars($circular['descripcion']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Vigencia:</strong><br>
                        <i class="fas fa-calendar me-1"></i>
                        <?php echo date('d/m/Y', strtotime($circular['fecha_inicio'])); ?> - 
                        <?php echo date('d/m/Y', strtotime($circular['fecha_fin'])); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sección de subida de archivos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-upload me-2"></i>Subir Documento
                    </h5>
                </div>
                <div class="card-body">
                    <form id="formSubirArchivo" enctype="multipart/form-data">
                        <input type="hidden" name="circular_id" value="<?php echo $circular_id; ?>">
                        <input type="hidden" name="accion" value="subir_archivo">
                        
                        <div class="file-upload-area mb-3" onclick="document.getElementById('archivo').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                            <p class="mb-0">Haga clic aquí para seleccionar un archivo</p>
                            <small class="text-muted">Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX (Máx. 10MB)</small>
                        </div>
                        
                        <input type="file" id="archivo" name="archivo" style="display: none;" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                        
                        <div id="archivoSeleccionado" class="alert alert-success" style="display: none;">
                            <i class="fas fa-file me-2"></i>
                            <span id="nombreArchivo"></span>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-modern w-100">
                            <i class="fas fa-upload me-2"></i>Subir Archivo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sección de observaciones -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>Observaciones
                    </h5>
                </div>
                <div class="card-body">
                    <form id="formObservaciones">
                        <input type="hidden" name="circular_id" value="<?php echo $circular_id; ?>">
                        <input type="hidden" name="accion" value="guardar_observaciones">
                        
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones de la Institución</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="4" 
                                      placeholder="Escriba aquí sus observaciones sobre esta circular..."><?php echo $institucion_data ? htmlspecialchars($institucion_data['observaciones']) : ''; ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-modern w-100">
                            <i class="fas fa-save me-2"></i>Guardar Observaciones
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de archivos subidos y retroalimentación -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-folder-open me-2"></i>Estado Actual
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($institucion_data): ?>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Estado:</strong><br>
                                <span class="status-badge status-<?php echo $institucion_data['estado_institucion']; ?>">
                                    <?php echo strtoupper($institucion_data['estado_institucion']); ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($institucion_data['nombre_archivo'])): ?>
                            <div class="col-md-4">
                                <strong>Archivo Subido:</strong><br>
                                <a href="<?php echo $institucion_data['ruta_archivo']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>
                                    <?php echo htmlspecialchars($institucion_data['nombre_archivo']); ?>
                                </a>
                                <br><small class="text-muted">
                                    Subido el <?php echo date('d/m/Y H:i', strtotime($institucion_data['fecha_subida'])); ?>
                                </small>
                            </div>
                            <?php else: ?>
                            <div class="col-md-4">
                                <strong>Archivo Subido:</strong><br>
                                <span class="missing-file-badge">FALTA ARCHIVO</span>
                                <br><small class="text-muted">Aún no ha subido un documento para esta circular.</small>
                            </div>
                            <?php endif; ?>
                            
                            <div class="col-md-4">
                                <strong>Última Actualización:</strong><br>
                                <?php echo date('d/m/Y H:i', strtotime($institucion_data['fecha_actualizacion'])); ?>
                            </div>
                        </div>
                        
                        <?php if ($institucion_data['retroalimentacion']): ?>
                        <hr>
                        <div class="alert alert-warning">
                            <strong><i class="fas fa-comment-dots me-2"></i>Retroalimentación:</strong><br>
                            <?php echo nl2br(htmlspecialchars($institucion_data['retroalimentacion'])); ?>
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <h6>No hay información registrada</h6>
                            <p>Aún no ha subido archivos ni agregado observaciones para esta circular.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Manejar selección de archivo
    document.getElementById('archivo').addEventListener('change', function(e) {
        const archivo = e.target.files[0];
        if (archivo) {
            // Validar tamaño (10MB = 10 * 1024 * 1024 bytes)
            if (archivo.size > 10 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Archivo muy grande',
                    text: 'El archivo no puede exceder 10MB'
                });
                e.target.value = '';
                return;
            }
            
            document.getElementById('nombreArchivo').textContent = archivo.name;
            document.getElementById('archivoSeleccionado').style.display = 'block';
        }
    });

    // Envío del formulario de archivo
    $('#formSubirArchivo').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: 'procesar_circular_institucion.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    }).then(() => {
                        // Recargar el contenido del modal
                        gestionarCircular(<?php echo $circular_id; ?>);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al subir el archivo'
                });
            }
        });
    });

    // Envío del formulario de observaciones
    $('#formObservaciones').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'procesar_circular_institucion.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar las observaciones'
                });
            }
        });
    });
</script>