<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

$nombre_sesion = $_SESSION['nombre'];
$tipo_usuario  = $_SESSION['tipo_usuario'];

date_default_timezone_set("America/Bogota");
include("../../conexion.php");
require_once("../../zebra.php");

$usuario_filtro = isset($_GET['usuario']) ? mysqli_real_escape_string($mysqli, $_GET['usuario']) : '';
$nombre_filtro  = isset($_GET['nombre'])  ? mysqli_real_escape_string($mysqli, $_GET['nombre'])  : '';

$query_count = "SELECT COUNT(*) as total FROM usuarios
                WHERE (usuario LIKE '%{$usuario_filtro}%') AND (nombre LIKE '%{$nombre_filtro}%')";
$res_count   = $mysqli->query($query_count);
$row_count   = $res_count->fetch_assoc();
$num_registros = $row_count['total'];

$resul_x_pagina = 100;

$paginacion = new Zebra_Pagination();
$paginacion->records($num_registros);
$paginacion->records_per_page($resul_x_pagina);
$offset = ($paginacion->get_page() - 1) * $resul_x_pagina;

$consulta = "SELECT * FROM usuarios
             WHERE (usuario LIKE '%{$usuario_filtro}%') AND (nombre LIKE '%{$nombre_filtro}%')
             ORDER BY id ASC
             LIMIT {$offset}, {$resul_x_pagina}";
$result = $mysqli->query($consulta);

function badge_tipo($tipo, $subtipo) {
    if (!empty($subtipo)) {
        $color = ($subtipo === 'Funcionario') ? 'primary' : 'info';
        return "<span class='badge badge-{$color}'>{$subtipo}</span>";
    }
    switch ($tipo) {
        case 1:  return "<span class='badge badge-warning text-dark'>Admin</span>";
        case 2:  return "<span class='badge badge-success'>I.E.</span>";
        case 3:  return "<span class='badge badge-secondary'>No validado</span>";
        default: return "<span class='badge badge-light'>{$tipo}</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | SOFT — Usuarios</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <style>
        body { background: #f4f6f9; }
        .responsive { max-width: 100%; height: auto; }
        .page-header {
            background: linear-gradient(135deg, #1a3a6e 0%, #2d6bce 100%);
            color: #fff;
            border-radius: 0 0 18px 18px;
            padding: 22px 30px 18px;
            margin-bottom: 24px;
            box-shadow: 0 4px 18px rgba(30,60,120,.18);
        }
        .page-header h2 { font-size: 1.5rem; font-weight: 700; margin: 0; letter-spacing: .5px; }
        .page-header .nav-btns a {
            margin-right: 6px;
            font-size: .85rem;
        }
        .filter-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
            margin-bottom: 20px;
        }
        .filter-card .card-header {
            background: #2d6bce;
            color: #fff;
            font-weight: 600;
            border-radius: 12px 12px 0 0;
            font-size: .95rem;
        }
        .table-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
            overflow: hidden;
        }
        .table thead th {
            background: #1a3a6e;
            color: #fff;
            font-size: .82rem;
            text-transform: uppercase;
            letter-spacing: .6px;
            border: none;
            vertical-align: middle;
        }
        .table tbody tr:hover { background: #eaf1fb; }
        .table tbody td { vertical-align: middle; font-size: .9rem; }
        .btn-edit {
            border-radius: 6px;
            padding: 4px 10px;
            font-size: .82rem;
        }
        .legend-pill {
            display: inline-block;
            font-size: .78rem;
            padding: 3px 10px;
            border-radius: 20px;
            margin: 2px 3px;
            font-weight: 600;
        }
        .total-badge {
            background: rgba(255,255,255,.2);
            border-radius: 8px;
            padding: 2px 10px;
            font-size: .85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <h2><i class="fas fa-users-cog me-2"></i>&nbsp;Usuarios Registrados
                <span class="total-badge ml-2"><?php echo $num_registros; ?> registros</span>
            </h2>
            <div class="nav-btns mt-2 mt-md-0">
                <a href="./../../access.php" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left"></i> Inicio
                </a>
                <a href="../../logout.php" class="btn btn-sm btn-outline-light">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
                <a href="../../reset-password.php" class="btn btn-sm btn-outline-light">
                    <i class="fas fa-key"></i> Contraseña
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">

    <!-- FILTROS -->
    <div class="card filter-card">
        <div class="card-header">
            <i class="fas fa-search"></i>&nbsp; Filtrar Usuarios
        </div>
        <div class="card-body py-3">
            <form action="adduser.php" method="get" class="form-row align-items-end">
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold mb-1">Usuario</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input name="usuario" type="text" class="form-control"
                               placeholder="Buscar por usuario..."
                               value="<?php echo htmlspecialchars($usuario_filtro, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                </div>
                <div class="col-12 col-md-5 mb-2 mb-md-0">
                    <label class="small font-weight-bold mb-1">Nombre</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input name="nombre" type="text" class="form-control"
                               placeholder="Buscar por nombre..."
                               value="<?php echo htmlspecialchars($nombre_filtro, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                </div>
                <div class="col-12 col-md-3 d-flex">
                    <button type="submit" class="btn btn-primary btn-sm mr-2 flex-fill">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="adduser.php" class="btn btn-outline-secondary btn-sm flex-fill">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- LEYENDA -->
    <div class="mb-3">
        <small class="text-muted font-weight-bold mr-2">Roles:</small>
        <span class="legend-pill" style="background:#fff3cd;color:#856404;">Admin (1)</span>
        <span class="legend-pill" style="background:#d1e7dd;color:#0f5132;">I.E. (2)</span>
        <span class="legend-pill" style="background:#e2e3e5;color:#41464b;">No validado (3)</span>
        <span class="legend-pill" style="background:#cfe2ff;color:#084298;">Funcionario</span>
        <span class="legend-pill" style="background:#cff4fc;color:#055160;">Contratista</span>
    </div>

    <!-- TABLA -->
    <div class="card table-card">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-user-circle mr-1"></i>Usuario</th>
                        <th><i class="fas fa-id-card mr-1"></i>Nombre</th>
                        <th><i class="fas fa-shield-alt mr-1"></i>Tipo / Perfil</th>
                        <th style="width:80px" class="text-center"><i class="fas fa-tools mr-1"></i>Editar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = (($paginacion->get_page() - 1) * $resul_x_pagina) + 1;
                while ($row = mysqli_fetch_array($result)):
                    $subtipo = isset($row['subtipo_usuario']) ? $row['subtipo_usuario'] : '';
                ?>
                    <tr>
                        <td class="text-muted"><?php echo $i++; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['usuario'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo badge_tipo($row['tipo_usuario'], $subtipo); ?></td>
                        <td class="text-center">
                            <a href="adduser1.php?id=<?php echo (int)$row['id']; ?>"
                               class="btn btn-sm btn-outline-primary btn-edit"
                               title="Editar usuario">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINACIÓN -->
    <div class="mt-3 d-flex justify-content-center">
        <?php $paginacion->render(); ?>
    </div>

    <div class="text-center mt-4 mb-4">
        <a href="../../access.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </a>
    </div>

</div><!-- /container -->
</body>
</html>