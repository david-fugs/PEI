<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../access.php");
    exit;
}

// Configurar la codificacion de caracteres
header("Content-Type: text/html; charset=UTF-8");
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

$nombre = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_usuario'];
$id_cole = $_SESSION['id_cole'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | SOFT</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .file-upload-area {
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
            margin: 20px 0;
        }

        .file-upload-area:hover {
            background-color: #e9ecef;
        }

        .file-info {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <center>
        <img src="../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
    </center>
    <br />

    <section class="principal">
        <div class="container">
            <div class="form-container">
                <div class="text-center mb-4">
                    <h1 style="color: #412fd1; font-size: 30px;">
                        <b><i class="fas fa-upload"></i> SUBIR MANUAL DE CONVIVENCIA</b>
                    </h1>
                </div>

                <form action="procesarManual.php" method="POST" enctype="multipart/form-data" id="formManual">
                    <input type="hidden" name="id_cole" value="<?php echo $id_cole; ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="anio_manual" class="form-label">
                                <i class="fas fa-calendar"></i> Año del Manual <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="anio_manual" id="anio_manual" required>
                                <option value="">Seleccione el año</option>
                                <?php
                                $currentYear = date('Y');
                                // Mostrar desde 2020 hasta 2 años en el futuro
                                for ($year = 2020; $year <= $currentYear + 2; $year++) {
                                    $selected = ($year == $currentYear) ? 'selected' : '';
                                    echo "<option value='$year' $selected>$year</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="version" class="form-label">
                                <i class="fas fa-code-branch"></i> Version
                            </label>
                            <input type="text" class="form-control" name="version" id="version" 
                                   placeholder="Ej: 1.0, 2.1, etc." maxlength="10">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">
                            <i class="fas fa-comment"></i> Descripcion del Manual
                        </label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" 
                                  placeholder="Describa brevemente este manual de convivencia..." maxlength="500"></textarea>
                        <div class="form-text">Maximo 500 caracteres</div>
                    </div>

                    <div class="file-upload-area">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <h4>Seleccione el archivo del Manual de Convivencia</h4>
                        <input type="file" id="archivo" name="archivo" class="form-control mt-3" 
                               accept=".pdf,.doc,.docx" required>
                        
                        <div class="file-info mt-3">
                            <strong><i class="fas fa-info-circle"></i> Informacion importante:</strong>
                            <ul class="list-unstyled mt-2 mb-0">
                                <li><i class="fas fa-check text-success"></i> Formatos permitidos: PDF, DOC, DOCX</li>
                                <li><i class="fas fa-check text-success"></i> Tamaño maximo: 50 MB</li>
                                <li><i class="fas fa-check text-success"></i> Nombre recomendado: "Manual_Convivencia_2024.pdf"</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmar" required>
                            <label class="form-check-label" for="confirmar">
                                <strong>Confirmo que este archivo corresponde al Manual de Convivencia oficial de la institucion educativa</strong>
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Manual
                        </button>
                        <a href="manualConvivencia.php" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script>
        // Validacion del archivo
        document.getElementById('archivo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tamaño (50MB = 50 * 1024 * 1024 bytes)
                const maxSize = 50 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('El archivo es demasiado grande. El tamaño máximo permitido es 50 MB.');
                    e.target.value = '';
                    return;
                }

                // Validar tipo de archivo
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipo de archivo no permitido. Solo se permiten archivos PDF, DOC y DOCX.');
                    e.target.value = '';
                    return;
                }

                // Mostrar informacion del archivo
                const fileInfo = `
                    <div class="alert alert-success mt-2">
                        <strong>Archivo seleccionado:</strong><br>
                        <i class="fas fa-file"></i> ${file.name}<br>
                        <i class="fas fa-weight"></i> Tamaño: ${(file.size / 1024 / 1024).toFixed(2)} MB
                    </div>
                `;
                
                // Remover info anterior si existe
                const existingInfo = document.querySelector('.file-selected-info');
                if (existingInfo) {
                    existingInfo.remove();
                }
                
                // Agregar nueva info
                const infoDiv = document.createElement('div');
                infoDiv.className = 'file-selected-info';
                infoDiv.innerHTML = fileInfo;
                e.target.parentNode.appendChild(infoDiv);
            }
        });

        // Validacion del formulario
        document.getElementById('formManual').addEventListener('submit', function(e) {
            const archivo = document.getElementById('archivo').files[0];
            const anio = document.getElementById('anio_manual').value;
            const confirmar = document.getElementById('confirmar').checked;

            if (!archivo) {
                alert('Por favor seleccione un archivo.');
                e.preventDefault();
                return;
            }

            if (!anio) {
                alert('Por favor seleccione el año del manual.');
                e.preventDefault();
                return;
            }

            if (!confirmar) {
                alert('Debe confirmar que el archivo corresponde al Manual de Convivencia oficial.');
                e.preventDefault();
                return;
            }

            // Mostrar mensaje de carga
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subiendo archivo...';
            submitBtn.disabled = true;
        });
    </script>
</body>

</html>
