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

$nombre        = $_SESSION['nombre'];
$tipo_usuario  = $_SESSION['tipo_usuario'];
$id_cole       = $_SESSION['id_cole'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | SOFT</title>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GGkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        .container {
            width: 100%;
            overflow-x: auto;
        }

        .year-filter {
            margin-bottom: 20px;
        }

        .document-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .document-item:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .year-badge {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-left: 10px;
        }

        .type-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 10px;
        }

        .type-conformacion {
            background-color: #28a745;
            color: white;
        }

        .type-reglamento {
            background-color: #17a2b8;
            color: white;
        }

        .type-actas {
            background-color: #ffc107;
            color: #212529;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 2px solid transparent;
            min-width: 120px;
            justify-content: center;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            text-decoration: none;
        }

        .btn-view {
            background-color: #17a2b8;
            color: white;
            border-color: #17a2b8;
        }

        .btn-view:hover {
            background-color: #138496;
            color: white;
            border-color: #117a8b;
        }

        .btn-download {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }

        .btn-download:hover {
            background-color: #218838;
            color: white;
            border-color: #1e7e34;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
            color: white;
            border-color: #bd2130;
        }

        .btn-disabled {
            background-color: #6c757d;
            color: white;
            border-color: #6c757d;
            cursor: not-allowed;
            opacity: 0.65;
        }

        .btn-disabled:hover {
            transform: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .document-info-section {
            flex-grow: 1;
            min-width: 0;
        }

        .document-actions-section {
            flex-shrink: 0;
            margin-left: 15px;
        }

        .type-section {
            margin-bottom: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .type-header {
            padding: 15px 20px;
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .type-header.conformacion {
            background-color: #28a745;
        }

        .type-header.reglamento {
            background-color: #17a2b8;
        }

        .type-header.actas {
            background-color: #ffc107;
            color: #212529;
        }
        .type-header.planes {
            background: linear-gradient(45deg, #6f42c1, #9b59b6);
            color: #fff;
        }
        .count-badge {
            background: rgba(255,255,255,0.15);
            color: #fff;
            padding: 6px 10px;
            border-radius: 15px;
            margin-left: 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .documents-content {
            padding: 20px;
        }

        .upload-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .btn-upload {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            border: none;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            text-decoration: none;
        }

        .btn-upload.conformacion {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }

        .btn-upload.reglamento {
            background: linear-gradient(45deg, #17a2b8, #20c997);
            color: white;
        }

        .btn-upload.actas {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: #212529;
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .btn-action {
                width: 100%;
                min-width: auto;
            }
            
            .document-actions-section {
                margin-left: 0;
                margin-top: 15px;
            }

            .upload-buttons {
                flex-direction: column;
            }

            .btn-upload {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <center>
        <img src="../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
    </center>
    <br />
    <section class="principal">
        <div style="border-radius: 9px; border: 4px solid #FFFFFF; width: 100%;" align="center">
            <div align="center">
                <div style="margin-bottom:12px;">
                    <a href="manualConvivencia.php" class="btn btn-secondary" style="padding:10px 18px; font-weight:600; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fas fa-book"></i>
                        <span>Manual de Convivencia</span>
                    </a>
                </div>
                <div>
                    <h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em">
                        <b><i class="fas fa-users"></i> CONVIVENCIA ESCOLAR </b>
                    </h1>
                </div>
            </div>

            <!-- Botones para subir documentos -->
            <div class="upload-buttons">
                <a href="subirConvivenciaEscolar.php?tipo=conformacion" class="btn-upload conformacion">
                    <i class="fas fa-users"></i>
                    <span>Subir Conformacion</span>
                </a>
                <a href="subirConvivenciaEscolar.php?tipo=reglamento" class="btn-upload reglamento">
                    <i class="fas fa-gavel"></i>
                    <span>Subir Reglamento</span>
                </a>
                <a href="subirConvivenciaEscolar.php?tipo=actas" class="btn-upload actas">
                    <i class="fas fa-file-signature"></i>
                    <span>Subir Actas comite</span>
                </a>
                <a href="subirConvivenciaEscolar.php?tipo=planes_accion" class="btn-upload actas">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Planes de Acción</span>
                </a>
            </div>

            <!-- Filtro por año -->
            <div class="year-filter p-3">
                <form method="GET" class="d-flex justify-content-center align-items-center gap-3">
                    <label for="year_filter" class="form-label mb-0"><strong>Filtrar por año:</strong></label>
                    <select name="year_filter" id="year_filter" class="form-select" style="width: auto;" onchange="this.form.submit()">
                        <option value="">Todos los años</option>
                        <?php
                        // Generar opciones de años desde 2020 hasta el año actual + 2
                        $currentYear = date('Y');
                        $selectedYear = isset($_GET['year_filter']) ? $_GET['year_filter'] : '';
                        
                        for ($year = 2020; $year <= $currentYear + 2; $year++) {
                            $selected = ($selectedYear == $year) ? 'selected' : '';
                            echo "<option value='$year' $selected>$year</option>";
                        }
                        ?>
                    </select>
                    <?php if (!empty($selectedYear)): ?>
                        <a href="?" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times"></i> Limpiar filtro
                        </a>
                    <?php endif; ?>
                </form>
            </div>

        </div> <br />

        <?php
        // Mostrar mensajes de exito o error
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] === 'subido') {
                echo "<div class='container'>
                        <div class='alert alert-success alert-dismissible fade show'>
                            <i class='fas fa-check-circle'></i> 
                            ¡Documento de convivencia escolar subido exitosamente!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                      </div>";
            } elseif ($_GET['mensaje'] === 'eliminado') {
                echo "<div class='container'>
                        <div class='alert alert-success alert-dismissible fade show'>
                            <i class='fas fa-check-circle'></i> 
                            Documento de convivencia escolar eliminado exitosamente.
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                      </div>";
            }
        }
        
        if (isset($_GET['error'])) {
            if ($_GET['error'] === 'eliminar') {
                echo "<div class='container'>
                        <div class='alert alert-danger alert-dismissible fade show'>
                            <i class='fas fa-exclamation-triangle'></i> 
                            Error al eliminar el documento de convivencia escolar.
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                      </div>";
            }
        }
        ?>

        <?php
        date_default_timezone_set("America/Bogota");
        include("../../conexion.php");
        
        // Asegurar que la conexion use UTF-8
        if (isset($mysqli)) {
            $mysqli->set_charset("utf8");
        }

        // Obtener el filtro de año
        $yearFilter = isset($_GET['year_filter']) ? intval($_GET['year_filter']) : '';
        
        // Construir la consulta con filtro de año si existe
        $whereClause = "WHERE ce.id_cole = $id_cole";
        if (!empty($yearFilter)) {
            $whereClause .= " AND ce.anio_documento = $yearFilter";
        }

        // Tipos de documentos
        $tipos = [
            'conformacion' => [
                'nombre' => 'Conformacion del Comite',
                'icono' => 'fas fa-users',
                'clase' => 'conformacion'
            ],
            'reglamento' => [
                'nombre' => 'Reglamento Interno',
                'icono' => 'fas fa-gavel',
                'clase' => 'reglamento'
            ],
            'actas' => [
                'nombre' => 'Comite de convivencia',
                'icono' => 'fas fa-file-signature',
                'clase' => 'actas'
            ]
            ,
            'planes_accion' => [
                'nombre' => 'Planes de Acción',
                'icono' => 'fas fa-clipboard-list',
                'clase' => 'planes'
            ]
        ];

        foreach ($tipos as $tipo => $info) {
            // Preparar consulta y obtener resultados primero para mostrar contador
            $query = "SELECT ce.*, c.nombre_cole 
                      FROM convivencia_escolar ce 
                      INNER JOIN colegios c ON ce.id_cole = c.id_cole 
                      $whereClause AND ce.tipo_documento = '$tipo'
                      ORDER BY ce.anio_documento DESC, ce.fecha_subida DESC";
            $result = $mysqli->query($query);
            $countDocs = ($result && $result->num_rows) ? $result->num_rows : 0;

            echo "<div class='container'>
                    <div class='type-section'>
                        <div class='type-header {$info['clase']}'>
                            <i class='{$info['icono']}'></i>
                            <span>{$info['nombre']}</span>";

            if (!empty($yearFilter)) {
                echo " - Año $yearFilter";
            }

            echo "<span class='count-badge'>{$countDocs} document(s)</span>";

            echo "   </div>
                    <div class='documents-content'>";

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Ruta almacenada en la BD (ej: files/16/2025/convivencia_escolar/archivo.pdf)
                    $storedPath = $row['ruta_archivo'];
                    // Ruta absoluta en el servidor para operaciones de fichero (desde el directorio actual)
                    $serverPath = __DIR__ . '/' . $storedPath;
                    // Ruta web relativa desde este archivo para enlaces (abrir en nueva pestaña)
                    $webPath = $storedPath;

                    $fileExists = file_exists($serverPath);
                    $fileSize = $fileExists ? round(filesize($serverPath) / 1024, 2) : 0;
                    
                    echo "<div class='document-item'>
                            <div class='d-flex justify-content-between align-items-start flex-wrap'>
                                <div class='document-info-section'>
                                    <h5>
                                        <i class='fas fa-file-pdf text-danger'></i> 
                                        " . htmlspecialchars($row['nombre_archivo']) . "
                                        <span class='year-badge'>" . $row['anio_documento'] . "</span>
                                    </h5>
                                    <p class='mb-1'>
                                        <strong>Descripcion:</strong> " . 
                                        (empty($row['descripcion']) ? 'Sin descripcion' : htmlspecialchars($row['descripcion'])) . "
                                    </p>";
                                    
                                    // Mostrar informacion específica para actas
                                    if ($tipo === 'actas') {
                                        if (!empty($row['numero_acta'])) {
                                            echo "<p class='mb-1'>
                                                    <strong>Número de Acta:</strong> " . htmlspecialchars($row['numero_acta']) . "
                                                  </p>";
                                        }
                                        if (!empty($row['fecha_reunion'])) {
                                            echo "<p class='mb-1'>
                                                    <strong>Fecha de Reunion:</strong> " . date('d/m/Y', strtotime($row['fecha_reunion'])) . "
                                                  </p>";
                                        }
                                    }
                                    
                                    echo "<p class='mb-1'>
                                        <small class='text-muted'>
                                            <i class='fas fa-calendar'></i> Subido el: " . date('d/m/Y H:i', strtotime($row['fecha_subida'])) . "
                                            " . ($fileExists ? " | <i class='fas fa-weight'></i> Tamaño: {$fileSize} KB" : "") . "
                                        </small>
                                    </p>
                                </div>
                                <div class='document-actions-section'>
                                    <div class='action-buttons'>";
                    
                                        // Botones de ver y descargar
                                        if ($fileExists) {
                                            echo "<a href='descargar_archivo.php?id=" . $row['id'] . "' class='btn-action btn-download' title='Descargar archivo'>
                                                    <i class='fas fa-download'></i>
                                                    <span>Descargar</span>
                                                </a>";
                                            
                                            echo "<a href='$webPath' target='_blank' class='btn-action btn-view' title='Ver archivo en nueva pestaña'>
                                                    <i class='fas fa-eye'></i>
                                                    <span>Ver</span>
                                                </a>";
                                        } else {
                                            echo "<span class='btn-action btn-disabled' title='Archivo no encontrado'>
                                                    <i class='fas fa-exclamation-triangle'></i>
                                                    <span>No disponible</span>
                                                </span>";
                                        }
                    
                    // Boton de eliminar
                    echo "<a href='eliminarConvivenciaEscolar.php?id=" . $row['id'] . "' 
                           class='btn-action btn-delete' 
                           onclick='return confirm(\"¿Está seguro de que desea eliminar este documento?\\n\\nArchivo: " . htmlspecialchars($row['nombre_archivo']) . "\\nTipo: " . $info['nombre'] . "\\nAño: " . $row['anio_documento'] . "\\n\\nEsta accion no se puede deshacer.\")' 
                           title='Eliminar documento'>
                            <i class='fas fa-trash-alt'></i>
                            <span>Eliminar</span>
                          </a>";
                    
                    echo "      </div>
                                </div>
                            </div>
                        </div>";
                }
            } else {
                echo "<div class='text-center py-4'>
                        <div class='alert alert-info'>
                            <i class='fas fa-info-circle'></i> 
                            No hay documentos de {$info['nombre']} registrados" . 
                            (!empty($yearFilter) ? " para el año $yearFilter" : "") . ".
                            <br><br>
                            <a href='subirConvivenciaEscolar.php?tipo=$tipo' class='btn btn-primary'>
                                <i class='fas fa-upload'></i> Subir primer documento
                            </a>
                        </div>
                      </div>";
            }
            
            echo "  </div>
                  </div>
                </div>";
        }
        ?>
        
        <center>
            <br /><a href="../ie/showIe.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
        </center>
        </div>
    </section>
</body>

</html>
