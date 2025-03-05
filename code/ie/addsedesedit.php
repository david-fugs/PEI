<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $id             = $_SESSION['id'];
    $usuario        = $_SESSION['usuario'];
    $nombre         = $_SESSION['nombre'];
    $tipo_usuario   = $_SESSION['tipo_usuario'];
    $id_cole        = $_SESSION['id_cole'];

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PEI | SOFT</title>
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <script type="text/javascript" src="../../js/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/popper.min.j"></script>
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
        <link href="../../fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
        <style>
            .responsive {
                max-width: 100%;
                height: auto;
            }
        </style>
    </head>
    <body>

	<?php

		date_default_timezone_set("America/Bogota");
        include("../../conexion.php");
	    $cod_dane_sede  = $_GET['cod_dane_sede'];
	    if(isset($_GET['cod_dane_sede']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM sedes WHERE cod_dane_sede = '$cod_dane_sede'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

	<div class="container">

        <h1><b><i class="fas fa-tasks"></i> VERIFICACIÓN SEDES Y JORNADA ÚNICA</b></h1>
            <hr style="border: 2px dotted #09F287; border-radius: 1px;">
                <p align="justify"><font size=4 color=#000000>Si no presenta inconvenientes con las Sedes listadas, por favor identifique las que cuentan con <i><b>Jornada Única</b></i> e indique si aplica para primaria, secundaria o ambas.</font></p>
            <hr style="border: 2px dotted #09F287; border-radius: 1px;">
    
        <form method="POST" action="addsedesedit1.php" enctype="multipart/form-data" method="POST">
            
	        <div class="form-group">
	            <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="cod_dane_sede">* CÓDIGO DANE SEDE:</label>
                        <input type='number' name='cod_dane_sede' class='form-control' readonly value='<?php echo $row['cod_dane_sede']; ?>' />
                    </div>
	            	<div class="col-12 col-sm-8">
                        <!--<label for="colegio_dll_sede">ESTABLECIMIENTO EDUCATIVO:</label>-->
                        <select name='colegio_dll_sede' class='form-control' readonly />
                            <option value=''></option>
                                <?php
                                    header('Content-Type: text/html;charset=utf-8');
                                    $consulta="SELECT DISTINCT colegios.nombre_cole FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE cod_dane_sede='$cod_dane_sede'";
                                    $res = mysqli_query($mysqli,$consulta);
                                    $num_reg = mysqli_num_rows($res);
                                    while($row1 = $res->fetch_array())
                                    {
                                    ?>
                            <option selected="true" value='<?php echo $row1['nombre_cole']; ?> '>
                                    <?php echo $row1['nombre_cole']; ?>
                            </option>
                                    <?php
                                    }
                                    ?>    
                        </select>
                    </div>
	            </div>
	        </div>

            <hr style="border: 4px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px; background: #e2f7bd;">A continuación, digite el número de recursos con los que cuenta la sede, es importante que señale aquellos que se encuentran en perfectas condiciones y que actualmente se pueden utilizar:</font></p>

            <div class='row'>  
                <table class='table table-bordered'>
                    <tr>
                        <th>RECURSOS</th>
                        <th>TOTAL</th>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">VIDEO BEAM</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_videobeam_dll_sede" value='0' autofocus/></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">TABLEROS DIGITALES y/o INTELIGENTES</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_tablero_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">TELEVISORES</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_tv_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">TABLETS</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_tablets_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">PARLANTES y/o SISTEMA DE AUDIO</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_audio_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">AULAS AMIGAS</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_aulas_amigas_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">TOMI</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_tomi_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">CLOUDLABS</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_cloud_labs_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">XAVIA</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_xavia_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">KIT DE ROBÓTICA</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_robotica_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">IMPRESORA 3D</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_imp3d_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">DATA LOGER</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_net_loger_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">E-CUBED</td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_ecubed_dll_sede" value='0' /></td>
                    </tr>
                </table>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for='num_dispositivos_otros_dll_sede'>* OTROS (ESPECIFIQUE EL TIPO DE RECURSO Y LA CANTIDAD):</label>
                        <textarea class="form-control" rows="3" name="num_dispositivos_otros_dll_sede" style="text-transform:uppercase;" cols="80" ><?php echo $row['num_dispositivos_otros_dll_sede']; ?></textarea>
                    </div>
                </div>
            </div>

            <hr style="border: 4px dotted #909797; border-radius: 1px;">

            <div class='row'>  
                <table class='table table-bordered'>
                    <tr>
                        <th>ITEM</th>
                        <th>SI o NO</th>
                        <th>CANTIDAD</th>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">¿Cuenta con una sala o salas de sistemas habilitadas y/o funcionales? (indique por medio de un <b>SI</b> o un <b>NO:</b>)</td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="salas_hab_dll_sede" required >
                                <option value=""></option>   
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">SALAS INFORMÁTICA</td>
                        <td data-label="TOTAL ESTUDIANTES"></td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_salas_hab_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">COMPUTADOR DE MESA</td>
                        <td data-label="TOTAL ESTUDIANTES"></td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_computadores_hab_dll_sede" value='0' /></td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">PORTÁTILES</td>
                        <td data-label="TOTAL ESTUDIANTES"></td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="num_portatiles_dll_sede" value='0' /></td>
                    </tr>
                </table>
                <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for='num_dispositivos_otros_dll_sede'>* ESPECIFIQUE LA CANTIDAD DE EQUIPOS (COMPUTADORES DE MESA, PORTÁTILES Y TABLETS) <b>EN MAL ESTADO</b> Y LAS RAZONES DEL <b>NO FUNCIONAMIENTO:</b></label>
                        <textarea class="form-control" rows="3" name="razones_no_funcionan_dll_sede" style="text-transform:uppercase;" cols="80" ><?php echo $row['razones_no_funcionan_dll_sede']; ?></textarea>
                    </div>
                </div>
            </div>

            </div>

            <hr style="border: 4px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px; background: #e2f7bd;">Según la información de conectividad (acceso a una red local y/o Internet), indique por medio de un <b>SI</b> o un <b>NO:</b></font></p>
           
            <div class='row'>  
                <table class='table table-bordered'>
                    <tr>
                        <th>ITEM</th>
                        <th>SI o NO</th>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">Únicamente acceso a Internet:</td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="internet_dll_sede" required>
                                <option value=""></option>   
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">Red de área local con acceso a Internet:</td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="red_local_dll_sede" required>
                                <option value=""></option>   
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">Red de área local sin acceso a Internet:</td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="red_local_sin_internet_dll_sede" required>
                                <option value=""></option>   
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">No se cuenta ni con red local ni con acceso a Internet:</td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="no_red_internet_dll_sede" required>
                                <option value=""></option>   
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

        	<hr style="border: 4px dotted #909797; border-radius: 1px;">

            <p align="justify"><font color=#000000 style="font-family: georgia; font-size: 18px; background: #e2f7bd;">Según la información con respecto a dispositivos activos, indique por medio de un <b>SI</b> o un <b>NO,</b> si cuenta con ellos, además coloque la letra correspondiente al estado actual del mismo y la cantidad total por cada elemento.</font>

            <BR><font color=#000000 style="font-family: georgia; font-size: 14px; ">ESTADO ACTUAL DISPOSITIVOS ACTIVOS:
            <BR><B>E:</B> Excelente (funciona correctamente)
            <BR><B>B:</B> Bueno (funciona bien, pero su condición física y el tipo de tecnología es obsoleta, por esta razón la velocidad o el acceso no es el que se espera)
            <BR><B>M:</B> Malo / Dañado (dispositivo no operativo, no funcional, obsoleto)</font></p>
           
            <div class='row'>  
                <table class='table table-bordered'>
                    <tr>
                        <th>ITEM</th>
                        <th>SI o NO</th>
                        <th>CANTIDAD</th>
                        <th>ESTADO</th>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">Switch o Conmutador (dispositivo de interconexión)</td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="switch_1_dll_sede" required>
                                <option value=""></option>   
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="switch_2_dll_sede" value='0' /></td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="switch_3_dll_sede" required>
                                <option value=""></option>   
                                <option value="E">E</option>
                                <option value="B">B</option>
                                <option value="M">M</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="NIVEL">Router y/o Access Point</td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="router_1_dll_sede" required>
                                <option value=""></option>   
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </td>
                        <td data-label="TOTAL ESTUDIANTES"><input type="number" name="router_2_dll_sede" value='0' /></td>
                        <td data-label="TOTAL ESTUDIANTES">
                            <select class="form-control" name="router_3_dll_sede" required>
                                <option value=""></option>   
                                <option value="E">E</option>
                                <option value="B">B</option>
                                <option value="M">M</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <hr style="border: 4px solid #04547c; border-radius: 3px;">

			<button type="submit" class="btn btn-primary" name="btn-update">
				<span class="spinner-border spinner-border-sm"></span>
				GUARDAR y/o ALMACENAR INFORMACIÓN
			</button>
			<button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
			</button>
		</form>
	</div>

</body>
</html>