<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
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
        <script src="js/64d58efce2.js" ></script>
		<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../../../css/estilos.css">
		<link href="../../../fontawesome/css/all.css" rel="stylesheet">
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
		<BR/>

		<section class="principal">

			<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

				<div align="center">
					<h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-baby"></i> PLAN DE AULA REGISTRADO</b></h1>
				</div>
	    		<br />

<?php

	date_default_timezone_set("America/Bogota");
	include("../../../conexion.php");
	
	$query = "SELECT * FROM plan_aula INNER JOIN colegios ON plan_aula.id_cole=colegios.id_cole WHERE plan_aula.id_cole=$id_cole";
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

	$consulta = "SELECT * FROM plan_aula INNER JOIN colegios ON plan_aula.id_cole=colegios.id_cole WHERE plan_aula.id_cole=$id_cole";
	$result = $mysqli->query($consulta);

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{

		echo '
				<tr>
					<td data-label="No.">'.$i++.'</td>
					<td data-label="I.E.">'.$row['nombre_cole'].'</td>
					<td data-label="OBSERVACIONES">'.$row['obs_plan_aula'].'</td>
					<td data-label="PDF"><a href="find_doc.php?id_plan_aula='.$row['id_plan_aula'].'"><img src="../../../img/files.png" width=28 heigth=28></td>
					<td data-label="EDIT"><a href="addaulaedit.php?id_plan_aula='.$row['id_plan_aula'].'"><img src="../../../img/editar.png" width=20 heigth=20></td>
				</tr>';
	}
 
	echo '</table>';
?>

		<center>
		<br/><a href="../../../access.php"><img src='../../../img/atras.png' width="72" height="72" title="Regresar" /></a>
		</center>

			</div>

		</section>

	</body>
</html>