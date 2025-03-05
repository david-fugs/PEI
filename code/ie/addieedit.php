<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEI | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body >
   	<?php
        include("../../conexion.php");
	    $cod_dane_cole  = $_GET['cod_dane_cole'];
	    if(isset($_GET['cod_dane_cole']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM colegios WHERE cod_dane_cole = '$cod_dane_cole'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo_educacion_fondo_azul.png' width="600" height="111" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fas fa-school"></i> ACTUALIZAR INFORMACIÓN DEL ESTABLECIMIENTO EDUCATIVO</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='addieedit1.php' enctype="multipart/form-data" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="cod_dane_cole">* CÓDIGO DANE:</label>
                        <input type='number' name='cod_dane_cole' class='form-control' readonly value='<?php echo $row['cod_dane_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="nit_cole">* No. NIT (ejemplo: 910420899-9):</label>
                        <input type='text' name='nit_cole' class='form-control' maxlength="11" minlength="11" required value='<?php echo $row['nit_cole']; ?>' />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="nombre_cole">* NOMBRE DEL ESTABLECIMIENTO EDUCATIVO:</label>
                        <input type='text' name='nombre_cole' class='form-control' id="nombre_cole" required style="text-transform:uppercase;" value='<?php echo $row['nombre_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="direccion_cole">* DIRECCIÓN:</label>
                        <input type='text' name='direccion_cole' id="direccion_cole" class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['direccion_cole']; ?>' />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="nombre_rector_cole">* NOMBRE DEL RECTOR:</label>
                        <input type='text' name='nombre_rector_cole' class='form-control' id="nombre_rector_cole" required style="text-transform:uppercase;" value='<?php echo $row['nombre_rector_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="tel_rector_cole">* TELÉFONO DE CONTACTO RECTOR:</label>
                        <input type='text' name='tel_rector_cole' id="tel_rector_cole" class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['tel_rector_cole']; ?>' />
                    </div>
                </div>
            </div>

            <hr style="border: 4px solid #04547c; border-radius: 5px;">
            <h4><b><CENTER>JORNADAS</h4></CENTER></b>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">JORNADA ÚNICA:</label>
                        <select class="form-control" name="jor_1_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_1_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_1_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">COMPLETA:</label>
                        <select class="form-control" name="jor_2_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_2_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_2_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">COMPLETA Y FIN DE SEMANA:</label>
                        <select class="form-control" name="jor_3_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_3_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_3_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">COMPLETA Y NOCTURNA:</label>
                        <select class="form-control" name="jor_4_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_4_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_4_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">COMPLETA, NOCTURNA Y FIN DE SEMANA</label>
                        <select class="form-control" name="jor_5_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_5_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_5_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA:</label>
                        <select class="form-control" name="jor_6_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_6_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_6_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA Y FIN DE SEMANA:</label>
                        <select class="form-control" name="jor_7_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_7_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_7_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA Y NOCTURNA:</label>
                        <select class="form-control" name="jor_8_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_8_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_8_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">MAÑANA, NOCTURNA Y FIN DE SEMANA:</label>
                        <select class="form-control" name="jor_9_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_9_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_9_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">OTRA:</label>
                        <select class="form-control" name="jor_10_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['jor_10_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['jor_10_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            <h4><b><CENTER>NIVELES QUE OFRECE</h4></CENTER></b>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">PREESCOLAR:</label>
                        <select class="form-control" name="niv_1_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_1_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_1_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">BÁSICA PRIMARIA:</label>
                        <select class="form-control" name="niv_2_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_2_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_2_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">BÁSICA SECUNDARIA:</label>
                        <select class="form-control" name="niv_3_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_3_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_3_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label class="containerCheck">MEDIA:</label>
                        <select class="form-control" name="niv_4_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['niv_4_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['niv_4_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            <h4><b><CENTER>CARACTER DE LA MEDIA</h4></CENTER></b>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label class="containerCheck">TÉCNICA:</label>
                        <select class="form-control" name="car_med_1_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['car_med_1_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['car_med_1_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="containerCheck">ACADÉMICA:</label>
                        <select class="form-control" name="car_med_2_cole" required/>
                            <option value=""></option>   
                            <option value=1 <?php if(utf8_encode($row['car_med_2_cole'])==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if(utf8_encode($row['car_med_2_cole'])==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr style="border: 4px solid #04547c; border-radius: 5px;">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="corregimiento_cole">CORREGIMIENTO:</label>
                        <input type='text' name='corregimiento_cole' id="corregimiento_cole" class='form-control' style="text-transform:uppercase;" value='<?php echo $row['corregimiento_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="id_mun">* MUNICIPIO:</label>
                        <select name='id_mun' class='form-control' required />
                            <option value=''></option>
                                <?php
                                    header('Content-Type: text/html;charset=utf-8');
                                    $consulta='SELECT * FROM municipios';
                                    $res = mysqli_query($mysqli,$consulta);
                                    $num_reg = mysqli_num_rows($res);
                                    while($row1 = $res->fetch_array())
                                    {
                                    ?>
                            <option value='<?php echo $row1['id_mun']; ?>'<?php if($row['id_mun']==$row1['id_mun']){echo 'selected';} ?>>
                                <?php echo utf8_encode($row1['nombre_mun']); ?>
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
                        <label for="tel1_cole">* TELÉFONO DE CONTACTO:</label>
                        <input type='text' name='tel1_cole' class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['tel1_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="tel2_cole">OTRO TELÉFONO DE CONTACTO:</label>
                        <input type='text' name='tel2_cole' class='form-control' style="text-transform:uppercase;" value='<?php echo $row['tel2_cole']; ?>' />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <label for="email_cole">EMAIL:</label>
                        <input type='email' name='email_cole' class='form-control' value='<?php echo $row['email_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="num_act_adm_cole">* NÚMERO ACTO ADMINISTRATIVO:</label>
                        <input type='number' name='num_act_adm_cole' class='form-control' required style="text-transform:uppercase;" value='<?php echo $row['num_act_adm_cole']; ?>' />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="fec_res_cole">* FECHA RESOLUCIÓN:</label>
                        <input type='date' name='fec_res_cole' class='form-control' required value='<?php echo $row['fec_res_cole']; ?>' />
                    </div>
                </div>
            </div>
           
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <label for="obs_cole">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" name="obs_cole" style="text-transform:uppercase;" /><?php echo $row['obs_cole']; ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR RESOLUCIÓN VIGENTE:</label>
                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/pdf">
                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;"><b><u>Solamente adicione documentos siempre y cuando este paso no se haya realizado anteriormente. </b></u>Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                GUARDAR y/o ACTUALIZAR INFORMACIÓN 
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>
</html>