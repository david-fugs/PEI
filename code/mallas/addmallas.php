<?php

session_start();

if (!isset($_SESSION['id'])) {
	header("Location: index.php");
}

header("Content-Type: text/html;charset=utf-8");
$nombre 		= $_SESSION['nombre'];
$tipo_usuario 	= $_SESSION['tipo_usuario'];
$id_cole        = $_SESSION['id_cole'];

// Incluir helper de administrador
include_once(__DIR__ . '/../../adminViewHelper.php');
// Si está en modo administrador, usar el id_cole efectivo
if (isAdminViewMode() && $tipo_usuario == "1") {
    $id_cole = getEfectivoIdCole();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PEI | SOFT</title>
	<script src="js/64d58efce2.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	<style>
		.responsive { max-width: 100%; height: auto; }

		body {
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
			min-height: 100vh;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}

		.page-wrapper {
			max-width: 1400px;
			margin: 20px auto;
			background: #fff;
			border-radius: 14px;
			box-shadow: 0 4px 24px rgba(0,0,0,0.08);
			padding: 30px;
		}

		.page-title {
			color: #412fd1;
			font-size: 1.7rem;
			font-weight: 700;
			margin-bottom: 1.5rem;
		}

		/* Tabla moderna */
		.mallas-table { width: 100%; border-collapse: separate; border-spacing: 0; }
		.mallas-table thead th {
			background: linear-gradient(135deg, #1a2332, #2c3e50);
			color: #fff;
			font-size: 0.8rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			padding: 14px 12px;
			border: none;
			white-space: nowrap;
		}
		.mallas-table thead th:first-child { border-radius: 10px 0 0 0; }
		.mallas-table thead th:last-child  { border-radius: 0 10px 0 0; }

		.mallas-table tbody tr {
			transition: background 0.2s;
		}
		.mallas-table tbody tr:nth-child(even) { background: #f8f9fa; }
		.mallas-table tbody tr:hover { background: #eef2ff; }
		.mallas-table tbody td {
			padding: 12px;
			vertical-align: middle;
			border-bottom: 1px solid #e9ecef;
			font-size: 0.9rem;
		}

		/* Celdas de texto largo con truncado */
		.cell-truncate {
			max-width: 220px;
		}
		.cell-text {
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
			transition: all 0.3s ease;
		}
		.cell-text.expanded {
			display: block;
			-webkit-line-clamp: unset;
		}
		.btn-ver-mas {
			background: none;
			border: none;
			color: #412fd1;
			font-size: 0.75rem;
			padding: 2px 0;
			cursor: pointer;
			font-weight: 600;
			display: none;
		}
		.cell-truncate.needs-clamp .btn-ver-mas { display: inline-block; }

		/* Botones de acción */
		.btn-action-icon {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			width: 34px;
			height: 34px;
			border-radius: 8px;
			border: none;
			transition: all 0.2s;
			font-size: 0.9rem;
			text-decoration: none;
		}
		.btn-action-icon:hover { transform: translateY(-2px); }
		.btn-files  { background: #e3f0ff; color: #3498db; }
		.btn-edit   { background: #fff8e1; color: #f39c12; }
		.btn-delete { background: #fdecea; color: #e74c3c; }
		.btn-files:hover  { background: #3498db; color: #fff; }
		.btn-edit:hover   { background: #f39c12; color: #fff; }
		.btn-delete:hover { background: #e74c3c; color: #fff; }
	</style>
</head>

<body>

<div class="page-wrapper">

	<div class="text-center mb-4">
		<img src="../../img/logo_educacion_fondo_azul.png" width="400" height="142" class="responsive mb-3">
	</div>

	<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
		<h1 class="page-title mb-0">
			<i class="fas fa-chalkboard-teacher me-2"></i>Mallas Curriculares — Planes de Asignatura
		</h1>
		<a href="addmallas1.php" class="btn btn-success d-flex align-items-center gap-2 rounded-pill shadow-sm px-4">
			<i class="fas fa-plus"></i>
			<span>Agregar Nueva Malla</span>
		</a>
	</div>

	<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

	$query = "SELECT * FROM mallas_curriculares INNER JOIN colegios ON mallas_curriculares.id_cole=colegios.id_cole WHERE colegios.id_cole=$id_cole";
	$res = $mysqli->query($query);
	$num_registros = mysqli_num_rows($res);

	echo "<div class='table-responsive'>
	<table class='mallas-table'>
		<thead>
			<tr>
				<th style='width:50px'>No.</th>
				<th style='width:180px'>Institución</th>
				<th>Mallas Curriculares</th>
				<th>Planes de Asignatura</th>
				<th>Objetivos Generales</th>
				<th style='width:50px' class='text-center'>Arch.</th>
				<th style='width:50px' class='text-center'>Edit</th>
				<th style='width:50px' class='text-center'>Elim.</th>
			</tr>
		</thead>
		<tbody>";

	$consulta = "SELECT * FROM mallas_curriculares INNER JOIN colegios ON mallas_curriculares.id_cole=colegios.id_cole WHERE colegios.id_cole=$id_cole";
	$result = $mysqli->query($consulta);

	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
		$id_mc = (int)$row['id_mc'];
		echo '
		<tr>
			<td class="fw-bold text-primary">' . $i++ . '</td>
			<td class="fw-semibold text-uppercase" style="font-size:0.82rem">' . htmlspecialchars($row['nombre_cole']) . '</td>
			<td class="cell-truncate">
				<div class="cell-text">' . htmlspecialchars($row['obs_malla_mc']) . '</div>
				<button class="btn-ver-mas" onclick="toggleVerMas(this)">Ver más ▾</button>
			</td>
			<td class="cell-truncate">
				<div class="cell-text">' . htmlspecialchars($row['obs_plan_mc']) . '</div>
				<button class="btn-ver-mas" onclick="toggleVerMas(this)">Ver más ▾</button>
			</td>
			<td class="cell-truncate">
				<div class="cell-text">' . htmlspecialchars($row['obs_gen_mc']) . '</div>
				<button class="btn-ver-mas" onclick="toggleVerMas(this)">Ver más ▾</button>
			</td>
			<td class="text-center">
				<a href="find_doc.php?id_mc=' . $id_mc . '" class="btn-action-icon btn-files" title="Ver Archivos">
					<i class="fas fa-folder-open"></i>
				</a>
			</td>
			<td class="text-center">
				<a href="addmallasedit.php?id_mc=' . $id_mc . '" class="btn-action-icon btn-edit" title="Editar">
					<i class="fas fa-edit"></i>
				</a>
			</td>
			<td class="text-center">
				<button onclick="eliminarMalla(' . $id_mc . ')" class="btn-action-icon btn-delete" title="Eliminar">
					<i class="fas fa-trash"></i>
				</button>
			</td>
		</tr>';
	}

	echo '</tbody></table></div>';

	?>

	<div class="text-center mt-4">
		<a href="../../access.php" class="btn btn-secondary d-inline-flex align-items-center gap-2">
			<i class="fas fa-arrow-left"></i> Regresar
		</a>
	</div>

</div>

<script>
function toggleVerMas(btn) {
	const cell = btn.closest('.cell-truncate');
	const text = cell.querySelector('.cell-text');
	const expanded = text.classList.toggle('expanded');
	btn.textContent = expanded ? 'Ver menos ▴' : 'Ver más ▾';
}

// Detectar si el texto fue truncado y mostrar el botón "Ver más"
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.cell-truncate').forEach(function (cell) {
		const text = cell.querySelector('.cell-text');
		if (text.scrollHeight > text.clientHeight + 2) {
			cell.classList.add('needs-clamp');
		}
	});
});

function eliminarMalla(id_mc) {
	if (confirm('¿Está seguro de eliminar este registro? Esta acción no se puede deshacer.')) {
		fetch('eliminar_malla_ajax.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'id_mc=' + encodeURIComponent(id_mc)
		})
		.then(response => response.json())
		.then(data => {
			alert(data.message);
			if (data.success) { location.reload(); }
		})
		.catch(() => { alert('Error de conexión.'); });
	}
}
</script>
</body>

</html>