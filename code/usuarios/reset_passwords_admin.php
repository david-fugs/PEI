<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../../index.php");
    exit;
}

include '../../conexion.php';
mysqli_set_charset($mysqli, 'utf8');

$usuarios = [];
$result = $mysqli->query("SELECT id, nombre, usuario FROM usuarios ORDER BY nombre ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Restaurar Contraseñas | PEI SOFT</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #1a2332, #3498db);
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 1.25rem 1.5rem;
        }
        .table thead th {
            background: #1a2332;
            color: #fff;
        }
        .btn-reset {
            white-space: nowrap;
        }
        #notifMsg {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            display: none;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 15px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container py-5">

        <!-- Notificación -->
        <div id="notifMsg"></div>

        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header-custom d-flex align-items-center gap-3">
                <i class="fas fa-key fa-lg"></i>
                <div>
                    <h4 class="mb-0 fw-bold">Restaurar Contraseñas de Usuarios</h4>
                    <small class="opacity-75">La contraseña se restablecerá a <strong>12345</strong></small>
                </div>
                <a href="../../access.php" class="btn btn-outline-light btn-sm ml-auto">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
            </div>
            <div class="card-body p-0">
                <div class="p-3">
                    <input type="text" id="buscarUsuario" class="form-control" placeholder="Buscar por nombre o usuario...">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tablaUsuarios">
                        <thead>
                            <tr>
                                <th class="ps-4">#</th>
                                <th><i class="fas fa-user me-1"></i>Usuario</th>
                                <th><i class="fas fa-id-badge me-1"></i>Nombre</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($usuarios as $u): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-primary"><?= $i++ ?></td>
                                <td><?= htmlspecialchars($u['usuario']) ?></td>
                                <td><?= htmlspecialchars($u['nombre']) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-reset"
                                        data-id="<?= (int)$u['id'] ?>"
                                        data-nombre="<?= htmlspecialchars($u['nombre'], ENT_QUOTES) ?>">
                                        <i class="fas fa-rotate-left me-1"></i>Restablecer Contraseña
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script>
        // Filtro de búsqueda
        document.getElementById('buscarUsuario').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#tablaUsuarios tbody tr').forEach(tr => {
                tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        });

        // Botón restablecer
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-reset');
            if (!btn) return;

            const id = btn.dataset.id;
            const nombre = btn.dataset.nombre;

            if (!confirm(`La contraseña de "${nombre}" será restablecida a 12345.\n¿Desea continuar?`)) return;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Procesando...';

            const fd = new FormData();
            fd.append('id', id);

            fetch('reset_password_admin_action.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        mostrarToast('success', `Contraseña de "${nombre}" restablecida correctamente.`);
                        btn.innerHTML = '<i class="fas fa-check me-1"></i>Restablecida';
                        btn.classList.replace('btn-warning', 'btn-success');
                    } else {
                        mostrarToast('danger', 'Error: ' + (data.message || 'No se pudo restablecer'));
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-rotate-left me-1"></i>Restablecer Contraseña';
                    }
                })
                .catch(() => {
                    mostrarToast('danger', 'Error de conexión al servidor.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-rotate-left me-1"></i>Restablecer Contraseña';
                });
        });

        function mostrarToast(tipo, mensaje) {
            var el = document.getElementById('notifMsg');
            var bgMap = { success: '#27ae60', danger: '#e74c3c', warning: '#f39c12' };
            el.style.background = bgMap[tipo] || '#333';
            var icon = tipo === 'success' ? 'check-circle' : 'exclamation-circle';
            el.innerHTML = '<i class="fas fa-' + icon + '" style="margin-right:8px"></i>' + mensaje;
            el.style.display = 'block';
            clearTimeout(el._t);
            el._t = setTimeout(function() { el.style.display = 'none'; }, 4000);
        }
    </script>
</body>
</html>
