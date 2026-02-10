<?php
// Forzar codificacion UTF-8 desde el inicio
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include('layouts/head_admin.php');

// Obtener el id_cole del parámetro GET si está disponible
$id_cole_seleccionado = isset($_GET['id_cole']) ? (int)$_GET['id_cole'] : null;
?>

<?php
// Asegurar conexión y funciones de observación
include('../../conexion.php');
include('../general/observacion.php');
?>

<style>
    /* Variables CSS para colores consistentes */
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

    /* Reset y estilos base */
    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        color: var(--dark-gray);
        line-height: 1.6;
    }

    /* Contenedor principal */
    .container-fluid {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin: 20px auto;
        padding: 30px;
        max-width: 1400px;
    }

    /* Titulos principales */
    h1,
    .main-title {
        font-weight: 700 !important;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 2rem;
        font-size: 2.5rem;
    }

    /* Estilos modernos para tablas */
    .table {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        border: none;
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--white);
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 18px 15px;
        position: relative;
    }

    .table tbody td {
        border: none;
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
        transition: var(--transition);
    }

    .table tbody tr:hover {
        background-color: var(--light-gray);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Botones modernos */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 24px;
        border: none;
        transition: var(--transition);
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-success,
    .btn-add-sede {
        background: linear-gradient(135deg, var(--success-color), #2ecc71);
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        color: var(--white);
    }

    .btn-success:hover,
    .btn-add-sede:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        color: var(--white);
    }

    .btn-primary,
    .btn-primary-modern {
        background: linear-gradient(135deg, var(--accent-color), #5dade2);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        color: var(--white);
    }

    .btn-primary:hover,
    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        color: var(--white);
    }

    .btn-secondary,
    .btn-secondary-modern {
        background: linear-gradient(135deg, var(--medium-gray), #95a5a6);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        color: var(--white);
    }

    .btn-dark {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
    }

    .btn-action {
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.8rem;
        margin: 2px;
        min-width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Estilos para modales */
    .modal-content {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--white);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        border-bottom: none;
        padding: 20px 30px;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.3rem;
    }

    .modal-body {
        padding: 30px;
        background: var(--white);
    }

    /* Selector de institución */
    .institution-selector {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--white);
        padding: 30px;
        border-radius: var(--border-radius);
        margin-bottom: 30px;
        text-align: center;
    }

    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 16px;
        font-size: 1rem;
        transition: var(--transition);
        background-color: var(--white);
    }

    .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        outline: none;
    }

    .content-section {
        display: none;
    }

    .content-section.active {
        display: block;
    }

    /* Estilos específicos para el modal de estrategia */
    .section-card {
        background: var(--light-gray);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid var(--accent-color);
        transition: var(--transition);
    }

    .section-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    /* Grid de grados */
    .grado-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .grado-item {
        background: var(--white);
        padding: 15px;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: var(--transition);
        text-align: center;
    }

    .grado-item:hover {
        border-color: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .grado-label {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cantidad-input {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        text-align: center;
        font-weight: 600;
        font-size: 1.1rem;
        transition: var(--transition);
        background-color: var(--white);
        width: 100%;
    }

    .cantidad-input:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
        transform: translateY(-1px);
    }

    /* Total estudiantes */
    .total-estudiantes {
        background: linear-gradient(135deg, var(--accent-color), #5dade2);
        color: var(--white);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin-top: 20px;
    }

    .total-estudiantes .total-label {
        font-size: 0.9rem;
        margin-bottom: 8px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .total-number {
        font-size: 2.5rem;
        font-weight: 800;
        display: block;
    }
</style>

<!-- Header moderno -->
<div class="container-fluid">
    <div class="header-section text-center mb-4">
        <img src='../../img/logo_educacion_fondo_azul.png' width="400" height="142" class="img-fluid mb-3" style="max-width: 100%; height: auto;">

        <div class="d-flex justify-content-start mb-3">
            <a href="../../access.php" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Regresar</span>
            </a>
        </div>

        <h1 class="main-title mb-4">
            <i class="fas fa-graduation-cap me-3"></i>
            ADMINISTRACIÓN DE INSTITUCIONES EDUCATIVAS
        </h1>

        <!-- Botón para exportar TODAS las estrategias -->
        <div class="text-center mb-4">
            <a href="exportar_todas_estrategias_excel.php"
                class="btn btn-success btn-lg d-flex align-items-center gap-2 justify-content-center"
                style="max-width: 500px; margin: 0 auto;"
                title="Exportar todas las estrategias J.U de todas las instituciones"
                onclick="return exportarTodasEstrategiasExcel(event);">
                <i class="fas fa-file-excel fa-lg"></i>
                <span>EXPORTAR TODAS LAS ESTRATEGIAS J.U</span>
            </a>
            <small class="text-muted d-block mt-2">
                <i class="fas fa-info-circle"></i> Exporta las estrategias de todas las instituciones educativas (incluye sedes sin estrategia)
            </small>
        </div>

        <!-- Selector de Institución -->
        <div class="institution-selector">
            <h3><i class="fas fa-school me-2"></i>Seleccionar Institución Educativa</h3>
            <p class="mb-3">Escoja la institución que desea administrar</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <select class="form-select form-select-lg" id="selectInstitucion" onchange="cargarInstitucion()">
                        <option value="">-- Seleccione una institución --</option>
                        <?php
                        // Conectar a la base de datos para obtener todas las instituciones
                        include("../../conexion.php");
                        mysqli_set_charset($mysqli, 'utf8');
                        
                        $query_instituciones = "SELECT id_cole, nombre_cole, cod_dane_cole FROM colegios ORDER BY nombre_cole ASC";
                        $result_instituciones = $mysqli->query($query_instituciones);
                        
                        while ($inst = mysqli_fetch_array($result_instituciones)) {
                            $selected = ($id_cole_seleccionado == $inst['id_cole']) ? 'selected' : '';
                            echo "<option value='{$inst['id_cole']}' $selected>{$inst['nombre_cole']} - DANE: {$inst['cod_dane_cole']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

                            <!-- Seccion de Observaciones Administracion (solo lectura) -->
                            <div class="mt-5">
                                <h1 class="main-title text-center mb-4">
                                    <i class="fas fa-clipboard-check me-3"></i>
                                    OBSERVACIONES ADMINISTRACION
                                </h1>

                                <div class="section-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php
                                            // Determinar el id_cole a usar (parámetro admin o null)
                                            $id_cole_to_show = $id_cole_seleccionado ?: 0;
                                            $contenido_observacion = MostrarInformacionObservacion($id_cole_to_show, $mysqli);
                                            ?>

                                            <div class="mb-3">
                                                <label for="observacion_admin" class="form-label">
                                                    <i class="fas fa-edit me-2"></i>Observaciones para este Establecimiento Educativo
                                                </label>
                                                <textarea
                                                    id="observacion_admin"
                                                    class="form-control"
                                                    rows="6"
                                                    readonly
                                                    placeholder="Observaciones administrativas (solo lectura)"><?php echo htmlspecialchars($contenido_observacion); ?></textarea>
                                            </div>

                                            <div class="alert alert-info mt-3">
                                                <i class="fas fa-info-circle me-2"></i>Esta sección es de solo lectura. Para editar observaciones contacte al administrador del sistema.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

    <!-- Contenido de la institución seleccionada -->
    <div id="contenidoInstitucion" class="content-section <?php echo $id_cole_seleccionado ? 'active' : ''; ?>">
        <?php if ($id_cole_seleccionado): ?>
        
        <!-- Botones de acciones modernizados -->
        <div class="d-flex justify-content-end mb-4 gap-3">
            <a href="exportar_estrategia_excel.php?id_cole=<?php echo $id_cole_seleccionado; ?>"
                class="btn btn-success btn-lg d-flex align-items-center gap-2"
                title="Exportar Estrategia J.U a Excel"
                onclick="return exportarEstrategiaExcel(event);">
                <i class="fas fa-file-excel"></i>
                <span>Exportar Estrategia J.U</span>
            </a>
            <button type="button" class="btn btn-add-sede btn-lg d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#modalAgregarSede">
                <i class="fas fa-plus-circle"></i>
                <span>Agregar Sede</span>
            </button>
        </div>

        <?php
        date_default_timezone_set("America/Bogota");
        require_once("../../zebra.php");

        // Configurar charset UTF-8 para la conexion
        mysqli_set_charset($mysqli, 'utf8');

        // Inicializa la consulta base
        $query = "SELECT * FROM colegios WHERE id_cole=$id_cole_seleccionado";

        // Ejecuta la consulta
        $res = $mysqli->query($query);
        if (!$res) {
            die("Error en la consulta: " . $mysqli->error);
        }

        $num_registros = mysqli_num_rows($res);
        $resul_x_pagina = 500;
        echo "<section class='content'>
        <div class='table-responsive'>
            <table class='table table-striped table-hover'>
                <thead>
                    <tr>
                        <th><i class='fas fa-hashtag me-2'></i>No.</th>
                        <th><i class='fas fa-id-card me-2'></i>DANE</th>
                        <th><i class='fas fa-building me-2'></i>NIT</th>
                        <th><i class='fas fa-school me-2'></i>ESTABLECIMIENTO</th>
                        <th><i class='fas fa-user-tie me-2'></i>RECTOR</th>
                        <th><i class='fas fa-file-contract me-2'></i>RESOLUCION</th>
                        <th><i class='fas fa-folder me-2'></i>ARCHIVOS</th>
                        <th><i class='fas fa-edit me-2'></i>EDITAR</th>
                        <th><i class='fas fa-bars me-2'></i>MENÚ</th>
                    </tr>
                </thead>
                <tbody>";

        $paginacion = new Zebra_Pagination();
        $paginacion->records($num_registros);
        $paginacion->records_per_page($resul_x_pagina);
        // Agrega el LIMIT con paginacion
        $query .= " LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";
        // Ejecuta la consulta con paginacion
        $result = $mysqli->query($query);
        if (!$result) {
            die("Error en la consulta: " . $mysqli->error);
        }
        $paginacion->render();
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            // Formatear los valores como moneda
            echo '<tr>
        <td data-label="no." class="fw-bold text-primary">' . $row['id_cole'] . '</td>
        <td data-label="DANE" class="fw-semibold">' . $row['cod_dane_cole'] . '</td>
        <td data-label="nit">' . $row['nit_cole'] . '</td>
        <td data-label="establecimiento" class="text-uppercase fw-semibold">' . $row['nombre_cole'] . '</td>
        <td data-label="rector" class="text-uppercase">' . $row['nombre_rector_cole'] . '</td>
        <td data-label="resolucion" class="text-uppercase">' . $row['num_act_adm_cole'] . '</td>
        <td data-label="ARCHIVOS" class="text-center">
            <a href="find_doc.php?nit_cole=' . $row['nit_cole'] . '" class="btn btn-action btn-primary" title="Ver Archivos">
                <i class="fas fa-folder-open"></i>
            </a>
        </td>
        <td data-label="EDIT" class="text-center">
            <a href="addieedit.php?cod_dane_cole=' . $row['cod_dane_cole'] . '" class="btn btn-action btn-warning" title="Editar">
                <i class="fas fa-edit"></i>
            </a>
        </td>
        <td data-label="MENÚ" class="text-center">
            <button type="button" class="btn btn-action btn-info" data-bs-toggle="modal" data-bs-target="#modalMenusAdmin" data-id-cole="' . $row['id_cole'] . '" title="Ver Menús del Establecimiento">
                <i class="fas fa-bars"></i>
            </button>
        </td>
        </tr>';
            $i++;
        }
        echo '</tbody></table>
        </div>
    </section>';
        ?>

        <!-- Seccion de Sedes -->
        <div class="mt-5">
            <h1 class="main-title text-center mb-4">
                <i class="fas fa-map-marker-alt me-3"></i>
                SEDES EDUCATIVAS
            </h1>
            <?php
            // Inicializa consulta SEDES
            $query = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole_seleccionado ORDER BY sedes.nombre_sede ASC";
            $res = $mysqli->query($query);

            echo "<div class='table-responsive'>
        <table class='table table-striped table-hover'>
            <thead>
                <tr>
                    <th><i class='fas fa-hashtag me-2'></i>No.</th>
                    <th><i class='fas fa-id-card me-2'></i>DANE</th>
                    <th><i class='fas fa-building me-2'></i>SEDE</th>
                    <th><i class='fas fa-map-pin me-2'></i>ZONA</th>
                    <th><i class='fas fa-info-circle me-2'></i>ESTADO</th>
                    <th><i class='fas fa-chess-board me-2'></i>ESTRATEGIA J.U</th>
                    <th><i class='fas fa-cogs me-2'></i>OPCIONES</th>
                </tr>
            </thead>
            <tbody>";

            $consulta = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole_seleccionado ORDER BY sedes.nombre_sede ASC";
            $result = $mysqli->query($consulta);

            $i = 1;
            while ($row = mysqli_fetch_array($result)) {
                // Determinar estado y clase CSS
                $estado = isset($row['estado']) ? $row['estado'] : 'activo';
                $estadoClass = $estado === 'suspendido' ? 'table-danger' : '';
                $estadoBadge = $estado === 'suspendido' ?
                    '<span class="badge bg-danger"><i class="fas fa-pause me-1"></i>Suspendido</span>' :
                    '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Activo</span>';

                echo '
            <tr class="' . $estadoClass . '">
                <td data-label="No." class="fw-bold text-primary">' . $i++ . '</td>
                <td data-label="DANE" class="fw-semibold">' . $row['cod_dane_sede'] . '</td>
                <td data-label="SEDE" class="text-uppercase fw-semibold">' . $row['nombre_sede'] . '</td>
                <td data-label="ZONA">' . $row['zona_sede'] . '</td>
                <td data-label="ESTADO" class="text-center">' . $estadoBadge . '</td>
                <td data-label="ESTRATEGIA J.U" class="text-center">
                    <button class="btn btn-success btn-sm rounded-pill d-flex align-items-center gap-2" onclick="abrirModalEstrategia(\'' . $row['cod_dane_sede'] . '\')" ' . ($estado === 'suspendido' ? 'disabled title="Sede suspendida"' : '') . '>
                        <i class="fas fa-chart-line"></i>
                        <span>Estrategia J.U</span>
                    </button>
                </td>
                <td data-label="OPCIONES" class="text-center">
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-action btn-warning btn-editar-sede" 
                            data-cod="' . $row['cod_dane_sede'] . '" 
                            data-nombre="' . $row['nombre_sede'] . '" 
                            data-zona="' . htmlspecialchars($row['zona_sede']) . '"
                            data-estado="' . $estado . '"
                            title="Editar Sede">
                            <i class="fas fa-edit"></i>
                        </button>';

                // Boton de suspender/activar
                if ($estado === 'activo') {
                    echo '<button class="btn btn-action btn-warning btn-suspender-sede" 
                    data-cod="' . $row['cod_dane_sede'] . '" 
                    title="Suspender Sede">
                    <i class="fas fa-pause"></i>
                </button>';
                } else {
                    echo '<button class="btn btn-action btn-success btn-activar-sede" 
                    data-cod="' . $row['cod_dane_sede'] . '" 
                    title="Activar Sede">
                    <i class="fas fa-play"></i>
                </button>';
                }

                echo '  <a href="eliminar_sede.php?cod_dane_sede=' . $row['cod_dane_sede'] . '" 
                           class="btn btn-action btn-danger" 
                           onclick="return confirm(\'¿Estas seguro de eliminar esta sede?\')"
                           title="Eliminar Sede">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>';
            }

            echo '</tbody>
        </table>
    </div>
    </div>';
            ?>

        <?php endif; ?>
    </div>
</div>

<!-- Modal Editar Sede -->
<div class="modal fade" id="modalEditarSede" tabindex="-1" aria-labelledby="modalEditarSedeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarSede">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarSedeLabel">Editar Sede</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label for="nombre_sede" class="form-label">Codigo Dane</label>
                    <input type="number" class="form-control" name="cod_dane_sede" id="cod_dane_sede" min="0">
                    <input type="hidden" class="form-control" name="cod_dane_sede_old" id="cod_dane_sede1">

                    <div class="mb-3 mt-3">
                        <label for="nombre_sede" class="form-label">Nombre de la Sede</label>
                        <input type="text" class="form-control" name="nombre_sede" id="nombre_sede1">
                    </div>

                    <div class="mb-3">
                        <label for="zona_sede" class="form-label">Zona</label>
                        <select class="form-control" name="zona_sede" id="zona_sede">
                            <option value="">Seleccione...</option>
                            <option value="URBANO">URBANO</option>
                            <option value="RURAL">RURAL</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estado_sede" class="form-label">Estado</label>
                        <select class="form-control" name="estado_sede" id="estado_sede">
                            <option value="activo">Activo</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Agregar Sede -->
<div class="modal fade" id="modalAgregarSede" tabindex="-1" aria-labelledby="modalAgregarSedeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="procesar_sede.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarSedeLabel">Agregar Sede</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_cole" value="<?= $id_cole_seleccionado ?>">

                <div class="mb-3">
                    <label for="codigo_dane" class="form-label">Codigo DANE Sede</label>
                    <input type="text" class="form-control" id="codigo_dane" name="codigo_dane" required>
                </div>

                <div class="mb-3">
                    <label for="nombre_sede" class="form-label">Nombre de la Sede</label>
                    <input type="text" class="form-control" id="nombre_sede" name="nombre_sede" required>
                </div>

                <div class="mb-3">
                    <label for="zona" class="form-label">Zona</label>
                    <select class="form-select" id="zona" name="zona" required>
                        <option value="">Seleccione...</option>
                        <option value="RURAL">Rural</option>
                        <option value="URBANO">Urbano</option>
                        <option value="N/A">N/A</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-dark">Guardar Sede</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Estrategia JU - Diseño Moderno -->
<div class="modal fade" id="estrategiaModal" tabindex="-1" aria-labelledby="estrategiaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="guardar_estrategia.php" id="formEstrategia" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="estrategiaModalLabel">
                        <i class="fas fa-chess-board me-2"></i>Configurar Estrategia Jornada Unica
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="cod_dane_sede" id="cod_dane_sede_estrategia">

                    <!-- Seccion: Informacion Principal -->
                    <div class="section-card">
                        <h6 class="section-title">
                            <i class="fas fa-handshake me-2 text-primary"></i>Alianzas y Responsabilidades
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="aliado" class="form-label">
                                    <i class="fas fa-users me-1"></i>Aliado Responsable
                                </label>
                                <select name="aliado" class="form-select" required>
                                    <option value="">── Seleccione un aliado ──</option>
                                    <option value="COMFAMILIAR">🏢 COMFAMILIAR</option>
                                    <option value="CRESE">🎓 CRESE</option>
                                    <option value="ONDAS">🌊 ONDAS</option>
                                    <option value="ICBF">👨‍👩‍👧‍👦 ICBF</option>
                                    <option value="SENA">🏢 SENA</option>
                                    <option value="Ministerios">🏛️ Ministerios</option>
                                    <option value="Alcaldias">🏛️ Alcaldias</option>
                                    <option value="Chef_Fundeca">👨‍🍳 Chef Fundeca</option>
                                    <option value="Entre Otros">📋 Entre Otros</option>
                                </select>

                                <!-- Campo para especificar "Entre Otros" -->
                                <div id="especificarAliadoContainer" class="mt-3" style="display: none;">
                                    <label for="especificar_aliado" class="form-label">
                                        <i class="fas fa-edit me-1"></i>Especifique el aliado
                                    </label>
                                    <input type="text" class="form-control" name="especificar_aliado" id="especificar_aliado"
                                        placeholder="Ingrese el nombre del aliado especifico">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="eje" class="form-label">
                                    <i class="fas fa-compass me-1"></i>Eje Movilizador
                                </label>
                                <select name="eje" class="form-select" required>
                                    <option value="">── Seleccione un eje ──</option>
                                    <option value="Recreacion y deporte">⚽ Recreacion y Deporte</option>
                                    <option value="Educacion artistica y cultural">🎨 Educacion Artistica y Cultural</option>
                                    <option value="Ciencia y tecnologia">🔬 Ciencia y Tecnologia</option>
                                    <option value="Articulacion de la media">🎓 Articulacion de la Media</option>
                                    <option value="Centro de interes">💡 Centro de Interes</option>
                                    <option value="Otros">📚 Otros</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Seccion: Configuracion Horaria -->
                    <div class="section-card">
                        <h6 class="section-title">
                            <i class="fas fa-calendar-alt me-2 text-warning"></i>Planificacion Horaria
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="dias" class="form-label">
                                    <i class="fas fa-calendar-day me-1"></i>Dias por Semana
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="dias" min="0" max="7" placeholder="Ej: 5">
                                    <span class="input-group-text">dias</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="horas" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Horas por Semana
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="horas" min="0" max="40" placeholder="Ej: 10">
                                    <span class="input-group-text">hrs</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="jornada" class="form-label">
                                    <i class="fas fa-user-clock me-1"></i>Tipo de Jornada
                                </label>
                                <select name="jornada" class="form-select">
                                    <option value="">── Seleccione tipo ──</option>
                                    <option value="Regular">🕐 Regular</option>
                                    <option value="Extra Curricular">🕕 Extra Curricular</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Seccion: Estudiantes por Grado -->
                    <div class="section-card">
                        <h6 class="section-title">
                            <i class="fas fa-user-graduate me-2 text-success"></i>Distribucion de Estudiantes por Grado
                        </h6>
                        <p class="text-muted mb-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Indique la cantidad de estudiantes por grado que participarán en esta estrategia.
                        </p>
                        <div class="grado-container">
                            <?php
                            $grados = ['Prejardin', 'Jardin', 'Transicion'];
                            for ($i = 1; $i <= 11; $i++) {
                                $grados[] = $i;
                            }
                            foreach ($grados as $grado) {
                                $icono = is_numeric($grado) ? '📚' : '🎈';
                                echo '
                        <div class="grado-item">
                            <label class="grado-label">' . $icono . ' ' . $grado . '</label>
                            <input type="number" class="form-control cantidad-input cantidad" 
                                name="cantidad[' . strtolower($grado) . ']" value="0" min="0" max="999"
                                placeholder="0">
                        </div>';
                            }
                            ?>
                        </div>

                        <!-- Total de Estudiantes -->
                        <div class="total-estudiantes">
                            <div class="total-label">
                                <i class="fas fa-calculator me-2"></i>Total de Estudiantes
                            </div>
                            <div class="total-number" id="totalEstudiantes">0</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Estrategia
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function cargarInstitucion() {
        const select = document.getElementById('selectInstitucion');
        const idCole = select.value;
        
        if (idCole) {
            // Redirigir con el parámetro de la institución seleccionada
            window.location.href = `showIeAdmin.php?id_cole=${idCole}`;
        } else {
            // Ocultar el contenido si no hay selección
            document.getElementById('contenidoInstitucion').classList.remove('active');
        }
    }

    function abrirModalEstrategia(codDane) {
        console.log('Abriendo modal para sede:', codDane);

        const form = document.getElementById('formEstrategia');
        form.reset();
        document.getElementById('cod_dane_sede_estrategia').value = codDane;

        // Abrir el modal con animacion suave
        const modal = new bootstrap.Modal(document.getElementById('estrategiaModal'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();

        // Enfocar el primer select después de que se abra el modal
        setTimeout(() => {
            form.querySelector('[name="aliado"]').focus();
        }, 500);
    }

    // Funcion para cargar datos según aliado y eje seleccionados
    function cargarDatosPorAliadoYEje() {
        const codDane = document.getElementById('cod_dane_sede_estrategia').value;
        const aliado = document.querySelector('[name="aliado"]').value;
        const eje = document.querySelector('[name="eje"]').value;
        const especificarAliado = document.getElementById('especificar_aliado').value;

        if (!codDane || !aliado || !eje) {
            // Si no están todos los campos, limpiar los campos dependientes
            if (codDane && aliado && !eje) {
                // Solo limpiar campos que dependen del eje
                limpiarCamposDependientesDelEje();
            }
            return;
        }

        // Construir la URL con los parámetros
        let url = `obtener_estrategia.php?cod_dane_sede=${codDane}&aliado=${encodeURIComponent(aliado)}&eje=${encodeURIComponent(eje)}`;

        // Si el aliado es "Entre Otros" y hay especificación, agregarla a la URL
        if (aliado === 'Entre Otros' && especificarAliado) {
            url += `&especificar_aliado=${encodeURIComponent(especificarAliado)}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Datos encontrados:', data);
                const form = document.getElementById('formEstrategia');

                if (data && Object.keys(data).length > 0) {
                    // Rellenar campos (excepto aliado y eje que ya están seleccionados)
                    form.querySelector('[name="dias"]').value = data.dias || '';
                    form.querySelector('[name="horas"]').value = data.horas || '';
                    form.querySelector('[name="jornada"]').value = data.jornada || '';

                    // Mostrar el campo de especificación si el aliado es "Entre Otros"
                    if (aliado === 'Entre Otros') {
                        mostrarCampoEspecificacion(aliado, data.especificar_aliado || '');
                    }

                    // Rellenar cantidades por grado
                    const grados = ['prejardin', 'jardin', 'transicion', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
                    grados.forEach(grado => {
                        const nombreCampo = `cantidad[${grado}]`;
                        const input = form.querySelector(`input[name="${nombreCampo}"]`);
                        const clave = 'cantidad_' + grado.toString().toLowerCase();
                        if (input && data.hasOwnProperty(clave)) {
                            input.value = data[clave];
                        }
                    });

                    // Actualizar total estudiantes
                    calcularTotal();
                } else {
                    // No hay datos, limpiar campos dependientes del eje
                    limpiarCamposDependientesDelEje();
                }
            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
            });
    }

    // Funcion para limpiar solo los campos que dependen del eje
    function limpiarCamposDependientesDelEje() {
        const form = document.getElementById('formEstrategia');

        form.querySelector('[name="dias"]').value = '';
        form.querySelector('[name="horas"]').value = '';
        form.querySelector('[name="jornada"]').value = '';

        // Limpiar cantidades
        const grados = ['prejardin', 'jardin', 'transicion', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        grados.forEach(grado => {
            const nombreCampo = `cantidad[${grado}]`;
            const input = form.querySelector(`input[name="${nombreCampo}"]`);
            if (input) {
                input.value = 0;
            }
        });

        calcularTotal();
    }

    // Función para mostrar el campo de especificación cuando se carga data existente
    function mostrarCampoEspecificacion(aliado, especificarAliado) {
        const especificarContainer = document.getElementById('especificarAliadoContainer');
        const especificarInput = document.getElementById('especificar_aliado');

        if (aliado === 'Entre Otros') {
            especificarContainer.style.display = 'block';
            especificarInput.required = true;
            if (especificarAliado) {
                especificarInput.value = especificarAliado;
            }
        } else {
            especificarContainer.style.display = 'none';
            especificarInput.required = false;
            especificarInput.value = '';
        }
    }

    function calcularTotal() {
        let total = 0;
        document.querySelectorAll('.cantidad').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        document.getElementById('totalEstudiantes').textContent = total;
    }

    // Función para cambiar estado de sede
    function cambiarEstadoSede(codDane, nuevoEstado) {
        const formData = new FormData();
        formData.append('cod_dane_sede', codDane);
        formData.append('estado', nuevoEstado);

        fetch('cambiar_estado_sede.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cambiar el estado de la sede');
            });
    }

    // Event listeners para el modal de estrategia
    document.addEventListener('DOMContentLoaded', function() {
        // Event listeners para los botones de edición y estado de sedes
        
        // Modal para editar sede
        document.querySelectorAll('.btn-editar-sede').forEach(btn => {
            btn.addEventListener('click', function() {
                const cod = this.dataset.cod;
                const nombre = this.dataset.nombre;
                const zona = this.dataset.zona;
                const estado = this.dataset.estado || 'activo';
                console.log(nombre);

                document.getElementById('cod_dane_sede').value = cod;
                document.getElementById('cod_dane_sede1').value = cod;
                document.getElementById('nombre_sede1').value = nombre;
                document.getElementById('zona_sede').value = zona;
                document.getElementById('estado_sede').value = estado;

                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('modalEditarSede'));
                modal.show();
            });
        });

        // Edicion sede
        document.getElementById('formEditarSede').addEventListener('submit', function(e) {
            e.preventDefault();

            const datos = new FormData(this);

            fetch('editarSede.php', {
                    method: 'POST',
                    body: datos
                })
                .then(res => res.text())
                .then(respuesta => {
                    alert('Cambios guardados correctamente');
                    location.reload(); // Recarga la página para ver los cambios
                })
                .catch(err => {
                    console.error(err);
                    alert('Error al guardar los cambios');
                });
        });

        // Manejar suspensión y activación de sede
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-suspender-sede')) {
                const btn = e.target.closest('.btn-suspender-sede');
                const codDane = btn.dataset.cod;

                if (confirm('Esta seguro de suspender esta sede? No podra gestionar estrategias mientras este suspendida.')) {
                    cambiarEstadoSede(codDane, 'suspendido');
                }
            }

            if (e.target.closest('.btn-activar-sede')) {
                const btn = e.target.closest('.btn-activar-sede');
                const codDane = btn.dataset.cod;

                if (confirm('¿Está seguro de activar esta sede?')) {
                    cambiarEstadoSede(codDane, 'activo');
                }
            }
        });

        // Event listener para cuando cambie el aliado o el eje
        document.addEventListener('change', function(event) {
            if (event.target && event.target.name === 'aliado') {
                // Mostrar/ocultar campo de especificación para "Entre Otros"
                const especificarContainer = document.getElementById('especificarAliadoContainer');
                const especificarInput = document.getElementById('especificar_aliado');

                if (event.target.value === 'Entre Otros') {
                    especificarContainer.style.display = 'block';
                    especificarInput.required = true;
                } else {
                    especificarContainer.style.display = 'none';
                    especificarInput.required = false;
                    especificarInput.value = '';
                }

                cargarDatosPorAliadoYEje();
            } else if (event.target && event.target.name === 'eje') {
                cargarDatosPorAliadoYEje();
            }
        });

        // Event listener específico para el campo de especificación de aliado
        document.addEventListener('input', function(event) {
            if (event.target && event.target.id === 'especificar_aliado') {
                // Usar debounce para evitar muchas llamadas mientras el usuario escribe
                clearTimeout(window.especificarAliadoTimeout);
                window.especificarAliadoTimeout = setTimeout(() => {
                    const aliado = document.querySelector('[name="aliado"]').value;
                    if (aliado === 'Entre Otros' && event.target.value.length >= 3) {
                        cargarDatosPorAliadoYEje();
                    }
                }, 500);
            }
        });

        // Sumar totales en tiempo real
        document.querySelectorAll('.cantidad').forEach(input => {
            input.addEventListener('input', calcularTotal);
        });

        // Calcular total inicial
        calcularTotal();

        // Manejar el envio del formulario de estrategia
        document.getElementById('formEstrategia').addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Formulario enviado');
            
            // Validar que cod_dane_sede esté presente
            const codDaneSede = document.getElementById('cod_dane_sede_estrategia').value;
            console.log('Codigo DANE sede:', codDaneSede);

            if (!codDaneSede) {
                alert('Error: No se pudo identificar la sede. Por favor, cierre el modal e intente nuevamente.');
                return;
            }

            // Validar que aliado esté seleccionado
            const aliado = document.querySelector('[name="aliado"]').value;
            if (!aliado) {
                alert('Por favor, seleccione un aliado responsable.');
                return;
            }

            // Validar campo de especificación si es "Entre Otros"
            const especificarAliado = document.getElementById('especificar_aliado').value;
            if (aliado === 'Entre Otros' && !especificarAliado.trim()) {
                alert('Por favor, especifique el nombre del aliado.');
                document.getElementById('especificar_aliado').focus();
                return;
            }

            // Validar que eje esté seleccionado
            const eje = document.querySelector('[name="eje"]').value;
            if (!eje) {
                alert('Por favor, seleccione un eje movilizador.');
                return;
            }

            const formData = new FormData(this);

            // Debug: mostrar datos del formulario
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            // Mostrar loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Guardando...';
            submitBtn.disabled = true;

            fetch('guardar_estrategia.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Respuesta recibida:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Datos de respuesta:', data);
                    if (data.success) {
                        alert(data.message);

                        // Cerrar el modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('estrategiaModal'));
                        modal.hide();

                        // Recargar la página para ver los cambios
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al guardar la estrategia');
                })
                .finally(() => {
                    // Restaurar boton
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Validación para prevenir valores negativos en inputs numéricos
        const numberInputs = document.querySelectorAll('input[type="number"]');

        numberInputs.forEach(input => {
            // Prevenir la entrada de valores negativos mediante teclado
            input.addEventListener('keydown', function(e) {
                // Permitir teclas de navegación y control
                const allowedKeys = [
                    'Backspace', 'Delete', 'Tab', 'Escape', 'Enter',
                    'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown',
                    'Home', 'End'
                ];

                // Permitir Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X, Ctrl+Z
                if (e.ctrlKey || e.metaKey) {
                    return;
                }

                // Si es una tecla permitida, continuar
                if (allowedKeys.includes(e.key)) {
                    return;
                }

                // Prevenir el signo menos (-) y el signo más (+)
                if (e.key === '-' || e.key === '+') {
                    e.preventDefault();
                    return;
                }

                // Permitir solo números
                if (!/^[0-9]$/.test(e.key)) {
                    e.preventDefault();
                    return;
                }
            });

            // Validar al cambiar el valor (paste, drag, etc.)
            input.addEventListener('input', function(e) {
                let value = parseFloat(this.value);

                // Si el valor es negativo, establecerlo a 0
                if (value < 0 || isNaN(value)) {
                    this.value = 0;

                    // Si es un input de cantidad, recalcular total
                    if (this.classList.contains('cantidad')) {
                        calcularTotal();
                    }
                }

                // Validar máximos específicos
                const max = parseFloat(this.getAttribute('max'));
                if (max && value > max) {
                    this.value = max;

                    // Si es un input de cantidad, recalcular total
                    if (this.classList.contains('cantidad')) {
                        calcularTotal();
                    }
                }
            });

            // Validar al perder el foco
            input.addEventListener('blur', function(e) {
                let value = parseFloat(this.value);

                // Si está vacío o es negativo, establecer el mínimo permitido
                if (isNaN(value) || value < 0) {
                    const min = parseFloat(this.getAttribute('min')) || 0;
                    this.value = min;

                    // Si es un input de cantidad, recalcular total
                    if (this.classList.contains('cantidad')) {
                        calcularTotal();
                    }
                }
            });
        });
    });

    // Función para exportar a Excel con mensaje de carga
    function exportarEstrategiaExcel(event) {
        // Prevenir navegación inmediata
        event.preventDefault();

        const target = event.target.closest('a'); // Obtener el enlace
        const originalText = target.innerHTML;
        const originalHref = target.href;

        // Mostrar mensaje de carga
        target.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generando Excel...';
        target.style.pointerEvents = 'none'; // Deshabilitar clics

        // Simular delay para mostrar el mensaje y luego navegar
        setTimeout(() => {
            window.location.href = originalHref;

            // Restaurar botón después de un momento
            setTimeout(() => {
                target.innerHTML = originalText;
                target.style.pointerEvents = 'auto'; // Habilitar clics nuevamente
            }, 2000);
        }, 500);

        return false;
    }

    // Función para exportar TODAS las estrategias a Excel con mensaje de carga
    function exportarTodasEstrategiasExcel(event) {
        // Prevenir navegación inmediata
        event.preventDefault();

        const target = event.target.closest('a'); // Obtener el enlace
        const originalText = target.innerHTML;
        const originalHref = target.href;

        // Mostrar mensaje de carga
        target.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generando Excel Consolidado...';
        target.style.pointerEvents = 'none'; // Deshabilitar clics

        // Simular delay para mostrar el mensaje y luego navegar
        setTimeout(() => {
            window.location.href = originalHref;

            // Restaurar botón después de un momento
            setTimeout(() => {
                target.innerHTML = originalText;
                target.style.pointerEvents = 'auto'; // Habilitar clics nuevamente
            }, 3000); // Un poco más de tiempo porque son todas las instituciones
        }, 500);

        return false;
    }
</script>

<!-- MODAL MENUS ADMINISTRADOR -->
<div class="modal fade" id="modalMenusAdmin" tabindex="-1" aria-labelledby="modalMenusAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="modalMenusAdminLabel">
                    <i class="fas fa-bars me-2"></i>Menús del Establecimiento Educativo
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Modo Visualización Administrador:</strong> Podrás acceder a todos los módulos del establecimiento educativo seleccionado en modo lectura.
                </div>
                <div class="accordion" id="menuAccordionAdmin">

                    <!-- Teleológico -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#teleologicoAdmin">
                                <i class="fas fa-bullseye me-2"></i>Teleológico
                            </button>
                        </h2>
                        <div id="teleologicoAdmin" class="accordion-collapse collapse" data-bs-parent="#menuAccordionAdmin">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="#" class="menu-link-admin" data-url="../teleologico/addteleologico.php">
                                            <i class="fas fa-arrow-right me-2"></i>Ingresar a menú Teleológico
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Pedagógico -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pedagogicoAdmin">
                                <i class="fas fa-graduation-cap me-2"></i>Pedagógico
                            </button>
                        </h2>
                        <div id="pedagogicoAdmin" class="accordion-collapse collapse" data-bs-parent="#menuAccordionAdmin">
                            <div class="accordion-body">
                                <!-- Submenú Mallas -->
                                <div class="accordion" id="subMenuPedagogicoAdmin">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mallasAdmin">
                                                <i class="fas fa-th-large me-2"></i>Mallas
                                            </button>
                                        </h2>
                                        <div id="mallasAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogicoAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../mallas/addmallas.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar a Mallas
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenú Intensidad Horaria -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#intensidadHorariaAdmin">
                                                <i class="fas fa-clock me-2"></i>Intensidad Horaria
                                            </button>
                                        </h2>
                                        <div id="intensidadHorariaAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogicoAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../hours/intensidad_horaria.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Configurar Intensidad Horaria
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenú SIEE -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sieeAdmin">
                                                <i class="fas fa-chart-bar me-2"></i>SIEE
                                            </button>
                                        </h2>
                                        <div id="sieeAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogicoAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../siee/siee.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar a SIEE
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PLANES PROYECTOS -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#planesproyectosAdmin">
                                <i class="fas fa-project-diagram me-2"></i>Planes - Programas - Proyectos
                            </button>
                        </h2>
                        <div id="planesproyectosAdmin" class="accordion-collapse collapse" data-bs-parent="#menuAccordionAdmin">
                            <div class="accordion-body">
                                <div class="accordion" id="subMenuplanesproyectosAdmin">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#transversalesAdmin">
                                                <i class="fas fa-arrows-alt me-2"></i>Transversales Obligatorios
                                            </button>
                                        </h2>
                                        <div id="transversalesAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenuplanesproyectosAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../project/addproject.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar Transversales
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenú Proyectos pedagógicos -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proPedagogicosAdmin">
                                                <i class="fas fa-clipboard me-2"></i>Planes - Programas y Proyectos
                                            </button>
                                        </h2>
                                        <div id="proPedagogicosAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenuplanesproyectosAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../proyect_transv/management/userViewProject.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar a proyectos
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenú Proyectos y/o Planes -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proyectosplanesAdmin">
                                                <i class="fas fa-tasks me-2"></i>Proyectos y/o Planes
                                            </button>
                                        </h2>
                                        <div id="proyectosplanesAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenuplanesproyectosAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../plans/addplans.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar proyectos planes
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preescolar -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#transicionAdmin">
                                <i class="fas fa-child me-2"></i>Preescolar
                            </button>
                        </h2>
                        <div id="transicionAdmin" class="accordion-collapse collapse" data-bs-parent="#menuAccordionAdmin">
                            <div class="accordion-body">
                                <div class="accordion" id="subMenutransicionAdmin">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#CapituloEducacionInicialAdmin">
                                                <i class="fas fa-baby me-2"></i>Capítulo Educación Inicial
                                            </button>
                                        </h2>
                                        <div id="CapituloEducacionInicialAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenutransicionAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../initial/educa/addeduca.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar a educación inicial
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenú Plan de Estudios -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#planaulaAdmin">
                                                <i class="fas fa-book me-2"></i>Plan de Estudios
                                            </button>
                                        </h2>
                                        <div id="planaulaAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenutransicionAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../initial/aula/addaula.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar Plan de Estudios
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submenú Desarrollo Integral -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#desarrolloIntegralAdmin">
                                                <i class="fas fa-chart-line me-2"></i>Seguimiento al Desarrollo Integral
                                            </button>
                                        </h2>
                                        <div id="desarrolloIntegralAdmin" class="accordion-collapse collapse" data-bs-parent="#subMenutransicionAdmin">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <a href="#" class="menu-link-admin" data-url="../initial/integral/addintegral.php">
                                                            <i class="fas fa-arrow-right me-2"></i>Ingresar desarrollo integral
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONVIVENCIA -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#convivenciaAdmin">
                                <i class="fas fa-handshake me-2"></i>Convivencia
                            </button>
                        </h2>
                        <div id="convivenciaAdmin" class="accordion-collapse collapse" data-bs-parent="#menuAccordionAdmin">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="#" class="menu-link-admin" data-url="../convivencia/manualConvivencia.php">
                                            <i class="fas fa-arrow-right me-2"></i>Manual Convivencia
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" class="menu-link-admin" data-url="../convivencia/convivenciaEscolar.php">
                                            <i class="fas fa-arrow-right me-2"></i>Convivencia Escolar
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" class="menu-link-admin" data-url="../convivencia/circular.php">
                                            <i class="fas fa-arrow-right me-2"></i>Circular
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="https://www.mineducacion.gov.co/portal/men/Publicaciones/Guias/339480:Guia-No-49-Guias-pedagogicas-para-la-convivencia-escolar" target="_blank" rel="noopener">
                                            <i class="fas fa-external-link-alt me-2"></i>Guía 49 Ministerio de Educación
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para manejar el modal de menús del administrador
    document.addEventListener('DOMContentLoaded', function() {
        const modalMenusAdmin = document.getElementById('modalMenusAdmin');
        let selectedIdCole = null;

        // Cuando se abre el modal, capturar el id_cole
        modalMenusAdmin.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Botón que activó el modal
            selectedIdCole = button.getAttribute('data-id-cole');
            console.log('ID Cole seleccionado:', selectedIdCole);
        });

        // Manejar clicks en los enlaces del menú
        const menuLinksAdmin = document.querySelectorAll('.menu-link-admin');
        menuLinksAdmin.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-url');
                
                if (selectedIdCole) {
                    // Crear un formulario temporal para enviar el id_cole via POST
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.target = '_blank'; // Abrir en nueva pestaña
                    
                    const inputIdCole = document.createElement('input');
                    inputIdCole.type = 'hidden';
                    inputIdCole.name = 'admin_id_cole';
                    inputIdCole.value = selectedIdCole;
                    
                    const inputViewMode = document.createElement('input');
                    inputViewMode.type = 'hidden';
                    inputViewMode.name = 'admin_view_mode';
                    inputViewMode.value = '1';
                    
                    form.appendChild(inputIdCole);
                    form.appendChild(inputViewMode);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                } else {
                    alert('No se ha seleccionado un establecimiento educativo');
                }
            });
        });
    });
</script>

</body>
</html>