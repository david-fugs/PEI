<?php

session_start();

if (!isset($_SESSION['id'])) {
	header("Location: index.php");
}

header("Content-Type: text/html;charset=utf-8");
$nombre 		= $_SESSION['nombre'];
$tipo_usuario 	= $_SESSION['tipo_usuario'];
$id_cole        = $_SESSION['id_cole'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PEI | SOFT</title>
	<script src="js/64d58efce2.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../../css/estilos.css">
	<link href="../../../fontawesome/css/all.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


	<style>
		.responsive {
			max-width: 100%;
			height: auto;
		}
	</style>
</head>

<body>

	<center>
		<img src="../../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
	</center>
	<BR />

	<section class="principal">

		<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

			<div align="center">
				<h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-baby"></i> SEGUIMIENTO AL DESARROLLO INTEGRAL</b></h1>
			</div>
			<div class="d-flex justify-content-end p-3 mr-1" style="margin-right: 45px;">
				<a href="addintegral1.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow  pl-3 mr-4">
					<i class="fas fa-plus"></i>
					<span>Agregar Plan de Aula</span>
				</a>
			</div>

			<br />

			<?php

			date_default_timezone_set("America/Bogota");
			include("../../../conexion.php");

			$query = "SELECT * FROM dllo_integ INNER JOIN colegios ON dllo_integ.id_cole=colegios.id_cole WHERE dllo_integ.id_cole=$id_cole";
			$res = $mysqli->query($query);
			$num_registros = mysqli_num_rows($res);

			echo "<div class='container'>
        	<table class='table'>
            	<thead>
					<tr>
						<th>No.</th>
						<th>I.E.</th>
						<th>OBSERVACIONES</th>
		        		<th>PDF</th>
		        		<th>EDIT</th>
		    		</tr>
		  		</thead>
            <tbody>";

			$consulta = "SELECT * FROM dllo_integ INNER JOIN colegios ON dllo_integ.id_cole=colegios.id_cole WHERE dllo_integ.id_cole=$id_cole";
			$result = $mysqli->query($consulta);

			$i = 1;
			while ($row = mysqli_fetch_array($result)) {

				echo '
				<tr>
					<td data-label="No.">' . $i++ . '</td>
					<td data-label="I.E.">' . $row['nombre_cole'] . '</td>
					<td data-label="OBSERVACIONES">' . $row['obs_dllo_integ'] . '</td>
					<td data-label="PDF"><a href="find_doc.php?id_dllo_integ=' . $row['id_dllo_integ'] . '"><img src="../../../img/files.png" width=28 heigth=28></td>
					<td data-label="EDIT"><a href="addintegraledit.php?id_dllo_integ=' . $row['id_dllo_integ'] . '"><img src="../../../img/editar.png" width=20 heigth=20></td>
				</tr>';
			}

			echo '</table>';

			?>

			<center>
				<br /><a href="../../ie/showIe.php"><img src='../../../img/atras.png' width="72" height="72" title="Regresar" /></a>
			</center>

		</div>

	</section>

</body>

</html>