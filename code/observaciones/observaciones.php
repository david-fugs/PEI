<?php
// Forzar codificación UTF-8
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');

include('../../conexion.php');
include('../../sessionCheck.php');

// Determinar el id_cole según el tipo de usuario
if ($tipo_usuario == "2") {
    // Usuario tipo 2: solo puede ver observaciones de su institución
    $id_cole_seleccionado = $id_cole;
    $es_admin = false;
} else {
    // Administrador: puede seleccionar cualquier institución
    $id_cole_seleccionado = isset($_GET['id_cole']) ? (int)$_GET['id_cole'] : null;
    $es_admin = true;
}

// Procesar el envío de una nueva observación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guardar_observacion']) && $es_admin) {
    $id_cole_obs = (int)$_POST['id_cole'];
    $observacion = mysqli_real_escape_string($mysqli, trim($_POST['observacion']));
    
    if (!empty($observacion) && $id_cole_obs > 0) {
        $query_insert = "INSERT INTO observaciones_instituciones 
                        (id_cole, id_usuario, nombre_usuario, observacion) 
                        VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($mysqli, $query_insert);
        mysqli_stmt_bind_param($stmt, 'iiss', $id_cole_obs, $id, $nombre, $observacion);
        
        if (mysqli_stmt_execute($stmt)) {
            $mensaje_exito = "Observación guardada correctamente.";
            $id_cole_seleccionado = $id_cole_obs; // Mantener la institución seleccionada
        } else {
            $mensaje_error = "Error al guardar la observación: " . mysqli_error($mysqli);
        }
        mysqli_stmt_close($stmt);
    }
}

// Obtener información del colegio seleccionado
$info_colegio = null;
if ($id_cole_seleccionado) {
    $query_colegio = "SELECT id_cole, nombre_cole, cod_dane_cole FROM colegios WHERE id_cole = ?";
    $stmt = mysqli_prepare($mysqli, $query_colegio);
    mysqli_stmt_bind_param($stmt, 'i', $id_cole_seleccionado);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $info_colegio = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Observaciones - PEI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a2332;
            --secondary-color: #2c3e50;
            --accent-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-gray: #f8f9fa;
            --medium-gray: #6c757d;
            --dark-gray: #495057;
            --white: #ffffff;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark-gray);
            padding: 20px;
        }

        .main-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin: 20px auto;
            padding: 30px;
            max-width: 1400px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .page-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .institution-selector {
            background: var(--light-gray);
            padding: 25px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
        }

        .institution-selector h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .form-select-lg {
            border-radius: 10px;
            border: 2px solid #dee2e6;
            transition: var(--transition);
        }

        .form-select-lg:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .section-card {
            background: var(--white);
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .section-card h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 12px 24px;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), #5dade2);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #2ecc71);
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }

        .observacion-item {
            background: var(--light-gray);
            border-left: 4px solid var(--accent-color);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .observacion-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .observacion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .observacion-usuario {
            font-weight: 600;
            color: var(--primary-color);
        }

        .observacion-fecha {
            color: var(--medium-gray);
            font-size: 0.9rem;
        }

        .observacion-contenido {
            color: var(--dark-gray);
            line-height: 1.6;
            white-space: pre-wrap;
        }

        .info-colegio {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            border-left: 4px solid var(--success-color);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .info-colegio h5 {
            color: var(--success-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--medium-gray);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .back-button .btn {
            background: var(--medium-gray);
            color: var(--white);
        }

        .back-button .btn:hover {
            background: var(--dark-gray);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .form-control, .form-select {
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- Botón de regreso -->
    <div class="back-button">
        <button type="button" class="btn" onclick="window.location.href='../../access.php';">
            <i class="fas fa-arrow-left"></i> Regresar al Menú
        </button>
    </div>

    <!-- Encabezado -->
    <div class="page-header">
        <h1><i class="fas fa-clipboard-list"></i> Gestión de Observaciones</h1>
        <p>Sistema de seguimiento y observaciones a instituciones educativas</p>
    </div>

    <?php if (isset($mensaje_exito)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo $mensaje_exito; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($mensaje_error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo $mensaje_error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($es_admin): ?>
        <!-- Selector de Institución (solo para administradores) -->
        <div class="institution-selector">
            <h3><i class="fas fa-school me-2"></i>Seleccionar Institución Educativa</h3>
            <p class="mb-3">Escoja la institución para ver u agregar observaciones</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <select class="form-select form-select-lg" id="selectInstitucion" onchange="cargarInstitucion()">
                        <option value="">-- Seleccione una institución --</option>
                        <?php
                        $query_instituciones = "SELECT id_cole, nombre_cole, cod_dane_cole FROM colegios ORDER BY nombre_cole ASC";
                        $result_instituciones = mysqli_query($mysqli, $query_instituciones);
                        
                        while ($inst = mysqli_fetch_assoc($result_instituciones)) {
                            $selected = ($id_cole_seleccionado == $inst['id_cole']) ? 'selected' : '';
                            echo "<option value='{$inst['id_cole']}' $selected>{$inst['nombre_cole']} - DANE: {$inst['cod_dane_cole']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($info_colegio): ?>
        <!-- Información del colegio seleccionado -->
        <div class="info-colegio">
            <h5><i class="fas fa-building"></i> Institución Educativa</h5>
            <strong><?php echo htmlspecialchars($info_colegio['nombre_cole']); ?></strong><br>
            <small>Código DANE: <?php echo htmlspecialchars($info_colegio['cod_dane_cole']); ?></small>
        </div>

        <?php if ($es_admin): ?>
            <!-- Formulario para agregar observaciones (solo para administradores) -->
            <div class="section-card">
                <h4><i class="fas fa-pen"></i> Agregar Nueva Observación</h4>
                <form method="POST" action="">
                    <input type="hidden" name="id_cole" value="<?php echo $id_cole_seleccionado; ?>">
                    <div class="mb-3">
                        <label for="observacion" class="form-label">
                            <i class="fas fa-comment-dots"></i> Observación
                        </label>
                        <textarea 
                            class="form-control" 
                            id="observacion" 
                            name="observacion" 
                            rows="5" 
                            required
                            placeholder="Escriba aquí su observación para esta institución educativa..."></textarea>
                    </div>
                    <button type="submit" name="guardar_observacion" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Observación
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Historial de observaciones -->
        <div class="section-card">
            <h4><i class="fas fa-history"></i> Historial de Observaciones</h4>
            
            <?php
            // Consultar observaciones de la institución
            $query_obs = "SELECT o.*, u.nombre as nombre_usuario_real 
                         FROM observaciones_instituciones o
                         LEFT JOIN usuarios u ON o.id_usuario = u.id
                         WHERE o.id_cole = ?
                         ORDER BY o.fecha_creacion DESC";
            
            $stmt = mysqli_prepare($mysqli, $query_obs);
            mysqli_stmt_bind_param($stmt, 'i', $id_cole_seleccionado);
            mysqli_stmt_execute($stmt);
            $result_obs = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result_obs) > 0):
                while ($obs = mysqli_fetch_assoc($result_obs)):
                    $fecha_formateada = date('d/m/Y H:i', strtotime($obs['fecha_creacion']));
                    $nombre_mostrar = !empty($obs['nombre_usuario_real']) ? $obs['nombre_usuario_real'] : $obs['nombre_usuario'];
            ?>
                    <div class="observacion-item">
                        <div class="observacion-header">
                            <span class="observacion-usuario">
                                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($nombre_mostrar); ?>
                            </span>
                            <span class="observacion-fecha">
                                <i class="fas fa-clock"></i> <?php echo $fecha_formateada; ?>
                            </span>
                        </div>
                        <div class="observacion-contenido">
                            <?php echo nl2br(htmlspecialchars($obs['observacion'])); ?>
                        </div>
                    </div>
            <?php 
                endwhile;
            else:
            ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h5>No hay observaciones registradas</h5>
                    <p>Aún no se han registrado observaciones para esta institución.</p>
                </div>
            <?php 
            endif;
            mysqli_stmt_close($stmt);
            ?>
        </div>

    <?php else: ?>
        <!-- Mensaje cuando no hay institución seleccionada -->
        <div class="empty-state">
            <i class="fas fa-school"></i>
            <h5>Seleccione una Institución</h5>
            <p>Por favor, seleccione una institución educativa para ver u agregar observaciones.</p>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function cargarInstitucion() {
        var select = document.getElementById('selectInstitucion');
        var id_cole = select.value;
        
        if (id_cole) {
            window.location.href = 'observaciones.php?id_cole=' + id_cole;
        } else {
            window.location.href = 'observaciones.php';
        }
    }
</script>

</body>
</html>
