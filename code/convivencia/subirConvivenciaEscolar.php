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

// Obtener el tipo de documento a subir desde la URL
$tipo_documento = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$tipos_validos = ['conformacion', 'reglamento', 'actas'];

if (!in_array($tipo_documento, $tipos_validos)) {
    header("Location: convivenciaEscolar.php?error=tipo_invalido");
    exit;
}

// Configurar títulos e iconos según el tipo
$configuracion = [
    'conformacion' => [
        'titulo' => 'CONFORMACION',
        'icono' => 'fas fa-users',
        'descripcion' => 'Documento de conformacion del Comite de Convivencia Escolar'
    ],
    'reglamento' => [
        'titulo' => 'REGLAMENTO',
        'icono' => 'fas fa-gavel',
        'descripcion' => 'Reglamento del Comite de Convivencia Escolar'
    ],
    'actas' => [
        'titulo' => 'ACTAS',
        'icono' => 'fas fa-file-signature',
        'descripcion' => 'Actas de reuniones del Comite de Convivencia Escolar'
    ]
];

$config = $configuracion[$tipo_documento];
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            background-color: #e9ecef;
            border-color: #0056b3;
        }

        .file-info {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
        }

        .type-header {
            text-align: center;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .character-count {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
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
                <div class="type-header">
                    <h1><i class="<?php echo $config['icono']; ?>"></i> SUBIR <?php echo $config['titulo']; ?></h1>
                    <p class="mb-0"><?php echo $config['descripcion']; ?></p>
                </div>

                <form action="procesarConvivenciaEscolar.php" method="POST" enctype="multipart/form-data" id="formConvivencia">
                    <input type="hidden" name="id_cole" value="<?php echo $id_cole; ?>">
                    <input type="hidden" name="tipo_documento" value="<?php echo $tipo_documento; ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="anio_documento" class="form-label">
                                <i class="fas fa-calendar"></i> Año del Documento <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="anio_documento" id="anio_documento" required>
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
                                   placeholder="Ej: 1.0, 2.1, etc." maxlength="10" value="1.0">
                        </div>
                    </div>

                    <?php if ($tipo_documento === 'actas'): ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="numero_acta" class="form-label">
                                <i class="fas fa-hashtag"></i> Número de Acta
                            </label>
                            <input type="text" class="form-control" name="numero_acta" id="numero_acta" 
                                   placeholder="Ej: 001, 002, etc." maxlength="20">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_reunion" class="form-label">
                                <i class="fas fa-calendar-alt"></i> Fecha de Reunion
                            </label>
                            <input type="date" class="form-control" name="fecha_reunion" id="fecha_reunion">
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">
                            <i class="fas fa-comment"></i> Descripcion del Documento
                        </label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" 
                                  placeholder="Describa brevemente este documento..." maxlength="500" oninput="updateCharCount()"></textarea>
                        <div class="character-count" id="charCount">0/500 caracteres</div>
                    </div>

                    <div class="file-upload-area">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <h4>Seleccione el archivo de <?php echo $config['titulo']; ?></h4>
                        <input type="file" id="archivo" name="archivo" class="form-control mt-3" 
                               accept=".pdf,.doc,.docx" required>
                        
                        <div class="file-info mt-3">
                            <strong><i class="fas fa-info-circle"></i> Informacion importante:</strong>
                            <ul class="list-unstyled mt-2 mb-0">
                                <li><i class="fas fa-check text-success"></i> Formatos permitidos: PDF, DOC, DOCX</li>
                                <li><i class="fas fa-check text-success"></i> Tamaño maximo: 50 MB</li>
                                <li><i class="fas fa-check text-success"></i> Nombre recomendado: "<?php echo ucfirst($tipo_documento); ?>_2024.pdf"</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmar" required>
                            <label class="form-check-label" for="confirmar">
                                <strong>Confirmo que este archivo corresponde al documento oficial de <?php echo strtolower($config['titulo']); ?> de la institucion educativa</strong>
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-center">
                        <a href="convivenciaEscolar.php" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Documento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        function updateCharCount() {
            const textarea = document.getElementById('descripcion');
            const charCount = document.getElementById('charCount');
            const currentLength = textarea.value.length;
            charCount.textContent = currentLength + '/500 caracteres';
            
            if (currentLength > 450) {
                charCount.style.color = '#dc3545';
            } else if (currentLength > 350) {
                charCount.style.color = '#ffc107';
            } else {
                charCount.style.color = '#6c757d';
            }
        }

        document.getElementById('formConvivencia').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Esta seguro?',
                text: 'Se subira el documento al sistema',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, subir archivo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Subiendo archivo...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar formulario
                    this.submit();
                }
            });
        });

        // Validacion de archivo
        document.getElementById('archivo').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const maxSize = 50 * 1024 * 1024; // 50MB
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                
                if (file.size > maxSize) {
                    Swal.fire({
                        title: 'Archivo muy grande',
                        text: 'El archivo no puede ser mayor a 50MB',
                        icon: 'error'
                    });
                    this.value = '';
                    return;
                }
                
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        title: 'Tipo de archivo no valido',
                        text: 'Solo se permiten archivos PDF, DOC y DOCX',
                        icon: 'error'
                    });
                    this.value = '';
                    return;
                }
            }
        });

        // Inicializar contador de caracteres
        updateCharCount();
    </script>
</body>
</html>
