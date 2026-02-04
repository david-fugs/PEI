<?php

    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>RISPRO | SOFT</title>
        <script src="js/64d58efce2.js" ></script>
		<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
		<link href="../../fontawesome/css/all.css" rel="stylesheet">
		<style>
        	.responsive {
           		max-width: 100%;
            	height: auto;
        	}
    	</style>
    <head>
    <body>

		<center>
	    	<img src='../../img/logo_educacion.png' width="600" height="111" class="responsive">
		</center>
		<BR/>

		<section class="principal">

			<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

				<div align="center">
					<h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em">*** <i class="fas fa-user-cog"></i> USUARIOS REGISTRADOS <i class="fas fa-user-cog"></i> ***</h1>
					
					<h2 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em">
						<a href="./../../access.php" class="btn solid">Atrás</a>
	                    <a href="../../logout.php" class="btn solid">Salir</a>
	                    <a href="../../reset-password.php" class="btn solid">Cambiar Contraseña</a>
	               </h1>
                </div>

				<div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 1px solid #efd47d; width: 500px; height: 30px; background:#FAFAFA; display:table-cell; vertical-align:middle;">

					<label for="buscar">Datos de búsqueda</label>

	    			<form action="adduser.php" method="get">
	    				<input name="usuario" type="text"  placeholder="Escriba el usuario" size=15>
						<input name="nombre" type="text"  placeholder="Escriba el nombre de usuario" size=40>
						<input value="Realizar Busqueda" type="submit">

					</form>
					
	    		</div>

	    		<h4 style="color: #1a6294; size: 13px;"><B>TIPOS DE USUARIOS: </B>1: Administrador | 2: I.E. | 3: No validado</h4>

<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

	@$usuario = ($_GET['usuario']);
	@$nombre = ($_GET['nombre']);

	$query = "SELECT * FROM usuarios WHERE (usuario LIKE '%".$usuario."%') AND (nombre LIKE '%".$nombre."%') ORDER BY id ASC";
	$res = $mysqli->query($query);
	$num_registros = mysqli_num_rows($res);
	$resul_x_pagina = 100;

	echo "<div class='container'>
        	<table class='table'>
            	<thead>
					<tr>
						<th>No.</th>
						<th>USUARIO</th>
		        		<th>NOMBRE</th>
		        		<th>TIPO USUARIO</th>
		        		<th>EDIT</th>
		    		</tr>
		  		</thead>
            <tbody>";

	$paginacion = new Zebra_Pagination();
	$paginacion->records($num_registros);
	$paginacion->records_per_page($resul_x_pagina);

	$consulta = "SELECT * FROM  usuarios WHERE (usuario LIKE '%".$usuario."%') AND (nombre LIKE '%".$nombre."%') ORDER BY id ASC LIMIT " .(($paginacion->get_page() - 1) * $resul_x_pagina). "," .$resul_x_pagina;
	$result = $mysqli->query($consulta);

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{

		echo '
				<tr>
					<td data-label="No.">'.$i++.'</td>
					<td data-label="USUARIO.">'.$row['usuario'].'</td>
					<td data-label="USUARIO.">'.$row['nombre'].'</td>
					<td data-label="USUARIO.">'.$row['tipo_usuario'].'</td>
					<td data-label="EDIT"><a href="adduser1.php?id='.$row['id'].'"><img src="../../img/editar.png" width=20 heigth=20></td>
				</tr>';
	}
 
	echo '</table>';

	$paginacion->render();

?>

		<center>
		<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
		</center>

			</div>

		</section>

	</body>
</html>