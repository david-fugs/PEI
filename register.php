<?php
date_default_timezone_set("America/Bogota");
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PEI | SOFT</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/popper.min.j"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link href="fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
	<style>
		.responsive {
			max-width: 100%;
			height: auto;
		}
	</style>
	<script>
		function ordenarSelect(id_componente) {
			var selectToSort = jQuery('#' + id_componente);
			var optionActual = selectToSort.val();
			selectToSort.html(selectToSort.children('option').sort(function(a, b) {
				return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
			})).val(optionActual);
		}
		$(document).ready(function() {
			ordenarSelect('selectIE');
		});
	</script>
</head>

<body>

	<center>
		<img src="img/gobersecre.png" class="responsive">
	</center>
	<br />


	<?php
	require('conexion.php');
	// If form submitted, insert values into the database.
	if (isset($_REQUEST['usuario'])) {
		$usuario = stripslashes($_REQUEST['usuario']);
		$usuario = mysqli_real_escape_string($mysqli, $usuario);
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($mysqli, $password);
		$password = sha1($password);
		$nombre = stripslashes($_REQUEST['nombre']);
		$tipo_usuario = 2;
		$id_cole = stripslashes($_REQUEST['id_cole']);

		// Verificar si el usuario ya existe
		$checkQuery = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";
		$checkResult = mysqli_query($mysqli, $checkQuery);

		if (mysqli_num_rows($checkResult) > 0) {
			// Si el usuario ya existe, mostrar alerta y recargar la página
			echo "<script>alert('El usuario ya existe. Intente con otro nombre de usuario.'); window.location.href='register.php';</script>";
			exit(); // Detener la ejecución del script
		}

		// Si no existe, insertar el nuevo usuario
		$query = "INSERT INTO `usuarios` (usuario, password, tipo_usuario, nombre, id_cole) 
				  VALUES ('$usuario', '$password', '$tipo_usuario', '$nombre', '$id_cole')";

		$result = mysqli_query($mysqli, $query);

		if ($result) {
			echo "<center><p style='border-radius: 20px;box-shadow: 10px 10px 5px #c68615; font-size: 23px; font-weight: bold;'>REGISTRO CREADO SATISFACTORIAMENTE<br><br></p></center>
				  <div class='form' align='center'><h3>Regresar para iniciar la sesión... <br/><br/><center><a href='index.php'>Regresar</a></center></h3></div>";
		}
	} else {
	?>

		<div class="container">
			<h1><b><i class="fas fa-users"></i> REGISTRO DE UN NUEVO USUARIO</b></h1>
			<p><i><b>
						<font size=3 color=#c68615>*Datos obligatorios</i></b></font>
			</p>
			<form action='' method="POST">

				<div class="form-group">
					<div class="row">
						<div class="col-12 col-sm-6">
							<label for="nombre">* NOMBRES COMPLETOS (persona que se registra):</label>
							<input type='text' name='nombre' class='form-control' id="nombre" required autofocus style="text-transform:uppercase;" />
						</div>
						<div class="col-12 col-sm-6">
							<label for="id_cole">* ESTABLECIMIENTO EDUCATIVO:</label>
							<select name='id_cole' class='form-control' required id='selectIE' />
							<option value=''></option>
							<?php
							header('Content-Type: text/html;charset=utf-8');
							$consulta = 'SELECT * FROM colegios';
							$res = mysqli_query($mysqli, $consulta);
							$num_reg = mysqli_num_rows($res);
							while ($row = $res->fetch_array()) {
							?>
								<option value='<?php echo $row['id_cole']; ?>'>
									<?php echo utf8_encode($row['nombre_cole']); ?>
								</option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-12 col-sm-6">
							<label for="usuario">* USUARIO (minúsculas, sin espacios, ni caracteres especiales):</label>
							<input type='text' name='usuario' id="usuario" class='form-control' required />
						</div>
						<div class="col-12 col-sm-6">
							<label for="password">* PASSWORD (no tiene restricción):</label>
							<input type='password' name='password' id="password" class='form-control' required style="text-transform:uppercase;" />
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-outline-warning">
					<span class="spinner-border spinner-border-sm"></span>
					REGISTRAR USUARIO
				</button>
				<button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='img/atras.png' width=27 height=27> REGRESAR
				</button>
			</form>
		</div>

</body>

</html>


<?php } ?>