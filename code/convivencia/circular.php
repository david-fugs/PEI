<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

header("Content-Type: text/html;charset=utf-8");
$nombre = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_usuario'];
$id_cole = $_SESSION['id_cole'];
include("../../conexion.php");

// Helper para determinar si el usuario es administrador
function isAdmin($tipo_usuario) {
    // Acepta tanto 'admin' como id '3' (string o numérico)
    return ($tipo_usuario === 'admin' || $tipo_usuario === '3' || $tipo_usuario === 3 || $tipo_usuario === 'ADMIN');
}

// Obtener información del colegio
$sql_colegio = "SELECT cod_dane_cole, nit_cole, nombre_cole FROM colegios WHERE id_cole = $id_cole";
$result_colegio = mysqli_query($mysqli, $sql_colegio);
$colegio = mysqli_fetch_assoc($result_colegio);

$sql_circulares = "SELECT * FROM circulares WHERE estado = 'activa' ORDER BY fecha_inicio DESC";
$result_circulares = mysqli_query($mysqli, $sql_circulares);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | Circulares</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-principal {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        .header-title {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px 15px 0 0;
            font-weight: 600;
        }

        .btn-modern {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary.btn-modern {
            background: linear-gradient(45deg, #667eea, #764ba2);
        }

        .btn-success.btn-modern {
            background: linear-gradient(45deg, #56ab2f, #a8e6cf);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .circular-card {
            border-left: 5px solid #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pendiente { background: #ffc107; color: #000; }
        .status-enviado { background: #17a2b8; color: #fff; }
        .status-revisado { background: #6f42c1; color: #fff; }
        .status-aprobado { background: #28a745; color: #fff; }

        .file-upload-area {
            border: 2px dashed #667eea;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            background: rgba(102, 126, 234, 0.1);
            border-color: #764ba2;
        }

        .missing-file-badge {
            display: inline-block;
            background: #dc3545;
            color: #fff;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.75rem;
            margin-left: 10px;
        }

        /* Aumentar ancho del modal de gestión */
        #modalGestionarCircular .modal-dialog {
            max-width: 1200px; /* más ancho que modal-xl */
            width: 90%;
        }

        .info-card {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="container-principal">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="header-title">
                        <i class="fas fa-file-circle-check me-3"></i>
                        GESTIÓN DE CIRCULARES
                    </h1>
                </div>
            </div>

            <!-- Información del colegio -->
            <div class="info-card">
                <div class="row">
                    <div class="col-md-4">
                        <strong><i class="fas fa-school me-2"></i>Institución:</strong><br>
                        <?php echo htmlspecialchars($colegio['nombre_cole']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-id-card me-2"></i>DANE:</strong><br>
                        <?php echo htmlspecialchars($colegio['cod_dane_cole']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-certificate me-2"></i>NIT:</strong><br>
                        <?php echo htmlspecialchars($colegio['nit_cole']); ?>
                    </div>
                </div>
            </div>

            <!-- Botones de administración (solo para admin) -->
            <?php if (isAdmin($tipo_usuario)): ?>
            <div class="row mb-4">
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-success btn-modern" data-toggle="modal" data-target="#modalNuevaCircular">
                        <i class="fas fa-plus me-2"></i>Nueva Circular
                    </button>
                </div>
            </div>
            <?php endif; ?>

            <!-- Lista de circulares activas -->
            <div class="row">
                <?php if (mysqli_num_rows($result_circulares) > 0): ?>
                    <?php while ($circular = mysqli_fetch_assoc($result_circulares)): ?>
                        <?php
                        // Obtener el estado de esta institución para esta circular
                        $sql_estado = "SELECT * FROM circular_instituciones WHERE circular_id = {$circular['id']} AND id_cole = $id_cole";
                        $result_estado = mysqli_query($mysqli, $sql_estado);
                        $estado_institucion = mysqli_fetch_assoc($result_estado);
                        ?>
                        <div class="col-12 mb-4">
                            <div class="card circular-card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-bell me-2"></i>
                                        <?php echo htmlspecialchars($circular['titulo']); ?>
                                    </h5>
                                    <?php if ($estado_institucion): ?>
                                        <span class="status-badge status-<?php echo $estado_institucion['estado_institucion']; ?>">
                                            <?php echo strtoupper($estado_institucion['estado_institucion']); ?>
                                        </span>
                                        <?php if (empty($estado_institucion['ruta_archivo'])): ?>
                                            <span class="missing-file-badge">FALTA ARCHIVO</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="status-badge status-pendiente">PENDIENTE</span>
                                        <span class="missing-file-badge">FALTA ARCHIVO</span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="card-text"><?php echo htmlspecialchars($circular['descripcion']); ?></p>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Vigente desde <?php echo date('d/m/Y', strtotime($circular['fecha_inicio'])); ?> 
                                                hasta <?php echo date('d/m/Y', strtotime($circular['fecha_fin'])); ?>
                                            </small>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button type="button" class="btn btn-primary btn-modern btn-sm" 
                                                    onclick="gestionarCircular(<?php echo $circular['id']; ?>)">
                                                <i class="fas fa-folder-open me-1"></i>
                                                Gestionar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay circulares activas</h5>
                                <p class="text-muted">Actualmente no hay circulares disponibles para su gestión.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Botón volver -->
            <div class="text-center mt-4">
                <a href="../ie/showIe.php" class="btn btn-secondary btn-modern">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Menú Principal
                </a>
            </div>
        </div>
    </div>

    <!-- Modal para nueva circular (solo admin) -->
            <?php if (isAdmin($tipo_usuario)): ?>
    <div class="modal fade" id="modalNuevaCircular" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Nueva Circular
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="formNuevaCircular" method="POST" action="procesar_circular.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título de la Circular</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="fas fa-save me-2"></i>Crear Circular
                        </button>
                        <button type="button" class="btn btn-secondary btn-modern" data-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Modal para gestionar circular específica -->
    <div class="modal fade" id="modalGestionarCircular" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloGestionModal">
                        <i class="fas fa-folder-open me-2"></i>Gestionar Circular
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="contenidoGestionModal">
                    <!-- Contenido cargado via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../js/jquery-3.1.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script>
        function gestionarCircular(circularId) {
            // Cargar contenido de gestión via AJAX
            $.ajax({
                url: 'gestionar_circular.php',
                type: 'GET',
                data: { circular_id: circularId },
                success: function(response) {
                    $('#contenidoGestionModal').html(response);
                    $('#modalGestionarCircular').modal('show');
                    // Asegurar que el contenido empieza en la parte superior
                    $('#contenidoGestionModal').scrollTop(0);
                    // Si hay indicadores de falta de archivo, animarlos brevemente
                    if ($('#contenidoGestionModal').find('.missing-file-badge').length > 0) {
                        var $badges = $('#contenidoGestionModal').find('.missing-file-badge');
                        $badges.css('box-shadow', '0 0 0 3px rgba(220,53,69,0.15)');
                        setTimeout(function() {
                            $badges.css('box-shadow', 'none');
                        }, 1800);
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la información de la circular'
                    });
                }
            });
        }

        // Envío del formulario de nueva circular
        <?php if (isAdmin($tipo_usuario)): ?>
        $('#formNuevaCircular').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'procesar_circular.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message
                        }).then(() => {
                            location.reload();
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
                        text: 'Error al procesar la solicitud'
                    });
                }
            });
        });
        <?php endif; ?>
    </script>

</body>
</html>