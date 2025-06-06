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
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PEI | SOFT</title>
	<script src="js/64d58efce2.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
	<!--<link rel="stylesheet" type="text/css" href="../../css/estilos.css">-->
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<link href="../../fontawesome/css/all.css" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

	<style>
		.responsive {
			max-width: 100%;
			height: auto;
		}
	</style>
</head>

<body>

	<center>
		<img src="../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
	</center>
	<BR />

	<section class="principal">

		<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

			<div align="center">
				<h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-user-headset"></i> SOLICITUDES GENERADAS A LA SED </b></h1>
			</div>
			<div class="d-flex justify-content-end p-3 mr-1" style="margin-right: 45px;">
				<a href="addsolicitudes1.php" class="btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow  pl-3 mr-4">
					<i class="fas fa-plus"></i>
					<span>Agregar Solicitudes por SED</span>
				</a>
			</div>

			<br />

			<?php

			date_default_timezone_set("America/Bogota");
			include("../../conexion.php");

			$query = "SELECT * FROM solicitudes INNER JOIN colegios ON solicitudes.id_cole=colegios.id_cole WHERE colegios.id_cole=$id_cole";
			$res = $mysqli->query($query);

			echo "<div class='table-responsive-xl container-xl'>
          <table class='table table-hover'>
            <thead>
              <tr>
                <th ><center>#</center></th>
                <th ><center>FECHA</center></th>
                <th ><center>TIPO</center></th>
                <th ><center>OBSERVACIONES</center></th>
              </tr>
            </thead>
        	<tbody>";

			$consulta = "SELECT * FROM solicitudes INNER JOIN colegios ON solicitudes.id_cole=colegios.id_cole WHERE colegios.id_cole=$id_cole";
			$result = $mysqli->query($consulta);

			$i = 1;
			while ($row = mysqli_fetch_array($result)) {

				echo '
				<tr>
					<th scope="row"><center>' . $i++ . ' </center></th>
					<th><center>' . $row['fecha_sol'] . '</center></th>
					<th><center>' . $row['tipo_sol'] . '</center></th>
					<td><center> <p>' . $row['obs_sol'] . '</p> </center></td>
				</tr>';
			}

			echo '</tbody>
          </table>
        </div>';

			?>

			<center>
				<br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
			</center>

		</div>

	</section>

</body>

</html>