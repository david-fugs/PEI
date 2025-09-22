<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../access.php");
    exit;
}

// Configurar la codificación de caracteres
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

        .table {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .year-filter {
            margin-bottom: 20px;
        }

        .file-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .year-badge {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-left: 10px;
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

        .file-info-section {
            flex-grow: 1;
            min-width: 0;
        }

        .file-actions-section {
            flex-shrink: 0;
            margin-left: 15px;
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
            
            .file-actions-section {
                margin-left: 0;
                margin-top: 15px;
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
                <h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em">
                    <b><i class="fas fa-balance-scale"></i> MANUAL DE CONVIVENCIA </b>
                </h1>
            </div>

            <!-- Contenedor para alinear los botones -->
            <div class="d-flex justify-content-end p-3 gap-2">
                <a href="subirManual.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow">
                    <i class="fas fa-upload"></i>
                    <span>Subir Manual de Convivencia</span>
                </a>
                <a href="convivenciaEscolar.php" class="btn btn-secondary btn-lg d-flex align-items-center gap-2 rounded-pill shadow">
                    <i class="fas fa-users"></i>
                    <span>Convivencia Escolar</span>
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
        // Mostrar mensajes de éxito o error
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] === 'subido') {
                echo "<div class='container'>
                        <div class='alert alert-success alert-dismissible fade show'>
                            <i class='fas fa-check-circle'></i> 
                            ¡Manual de convivencia subido exitosamente!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                      </div>";
            } elseif ($_GET['mensaje'] === 'eliminado') {
                echo "<div class='container'>
                        <div class='alert alert-success alert-dismissible fade show'>
                            <i class='fas fa-check-circle'></i> 
                            Manual de convivencia eliminado exitosamente.
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
                            Error al eliminar el manual de convivencia.
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                      </div>";
            }
        }
        ?>

        <?php
        date_default_timezone_set("America/Bogota");
        include("../../conexion.php");
        
        // Asegurar que la conexión use UTF-8
        if (isset($mysqli)) {
            $mysqli->set_charset("utf8");
        }

        // Obtener el filtro de año
        $yearFilter = isset($_GET['year_filter']) ? intval($_GET['year_filter']) : '';
        
        // Construir la consulta con filtro de año si existe
        $whereClause = "WHERE mc.id_cole = $id_cole";
        if (!empty($yearFilter)) {
            $whereClause .= " AND mc.anio_manual = $yearFilter";
        }

        $query = "SELECT mc.*, c.nombre_cole 
                  FROM manual_convivencia mc 
                  INNER JOIN colegios c ON mc.id_cole = c.id_cole 
                  $whereClause 
                  ORDER BY mc.anio_manual DESC, mc.fecha_subida DESC";
        
        $result = $mysqli->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<div class='container'>
                    <h3 class='text-center mb-4'>
                        <i class='fas fa-folder-open'></i> 
                        Documentos del Manual de Convivencia" . 
                        (!empty($yearFilter) ? " - Año $yearFilter" : "") . "
                    </h3>";

            while ($row = $result->fetch_assoc()) {
                $filePath = "files/" . $row['id_cole'] . "/" . $row['anio_manual'] . "/" . $row['nombre_archivo'];
                $fileExists = file_exists($filePath);
                $fileSize = $fileExists ? round(filesize($filePath) / 1024, 2) : 0;
                
                echo "<div class='file-item'>
                        <div class='d-flex justify-content-between align-items-start flex-wrap'>
                            <div class='file-info-section'>
                                <h5>
                                    <i class='fas fa-file-pdf text-danger'></i> 
                                    " . htmlspecialchars($row['nombre_archivo']) . "
                                    <span class='year-badge'>" . $row['anio_manual'] . "</span>
                                </h5>
                                <p class='mb-1'>
                                    <strong>Descripcion:</strong> " . 
                                    (empty($row['descripcion']) ? 'Sin descripcion' : htmlspecialchars($row['descripcion'])) . "
                                </p>
                                <p class='mb-1'>
                                    <small class='text-muted'>
                                        <i class='fas fa-calendar'></i> Subido el: " . date('d/m/Y H:i', strtotime($row['fecha_subida'])) . "
                                        " . ($fileExists ? " | <i class='fas fa-weight'></i> Tamaño: {$fileSize} KB" : "") . "
                                    </small>
                                </p>
                            </div>
                            <div class='file-actions-section'>
                                <div class='action-buttons'>";
                
                // Botón de ver/descargar
                if ($fileExists) {
                    echo "<a href='$filePath' target='_blank' class='btn-action btn-view' title='Ver archivo en nueva ventana'>
                            <i class='fas fa-eye'></i>
                            <span>Ver</span>
                          </a>";
                    echo "<a href='$filePath' download class='btn-action btn-download' title='Descargar archivo'>
                            <i class='fas fa-download'></i>
                            <span>Descargar</span>
                          </a>";
                } else {
                    echo "<span class='btn-action btn-disabled' title='Archivo no encontrado'>
                            <i class='fas fa-exclamation-triangle'></i>
                            <span>No disponible</span>
                          </span>";
                }
                
                // Botón de eliminar
                echo "<a href='eliminarManual.php?id=" . $row['id'] . "' 
                       class='btn-action btn-delete' 
                       onclick='return confirm(\"¿Está seguro de que desea eliminar este manual de convivencia?\\n\\nArchivo: " . htmlspecialchars($row['nombre_archivo']) . "\\nAño: " . $row['anio_manual'] . "\\n\\nEsta accion no se puede deshacer.\")' 
                       title='Eliminar manual de convivencia'>
                        <i class='fas fa-trash-alt'></i>
                        <span>Eliminar</span>
                      </a>";
                
                echo "      </div>
                            </div>
                        </div>
                    </div>";
            }
            echo "</div>";
        } else {
            echo "<div class='container text-center'>
                    <div class='alert alert-info'>
                        <i class='fas fa-info-circle'></i> 
                        No hay manuales de convivencia registrados" . 
                        (!empty($yearFilter) ? " para el año $yearFilter" : "") . ".
                        <br><br>
                        <a href='subirManual.php' class='btn btn-primary'>
                            <i class='fas fa-upload'></i> Subir primer manual
                        </a>
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
