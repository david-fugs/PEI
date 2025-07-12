<?php
    
    session_start();     // iniciar seccion
    
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
        <meta charset="utf-8" />
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
        if(isset($_GET['id_cole']))
        {
           $sql = mysqli_query($mysqli, "SELECT * FROM colegios WHERE id_cole = '$id_cole'");
           $row = mysqli_fetch_array($sql);
        }
    ?>

    <div class="container">

        <h1><b><i class="fas fa-school"></i>ESTADO ACTUAL DE LOS PROYECTOS PEDAGÓGICOS TRANSVERSALES </b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='proyect_transv2.php'method="POST" enctype="multipart/form-data">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <div class="form-group">
                <div class="row">
                    <label for="id_cole">NOMBRE DEL ESTABLECIMIENTO EDUCATIVO (verifique que muestre de forma correcta el nombre de su establecimiento educativo):</label>
                            <select name='id_cole' required class='form-control' disabled/>
                                <option value=''></option>
                                    <?php
                                        header('Content-Type: text/html;charset=utf-8');
                                        $consulta='SELECT * FROM colegios';
                                        $res = mysqli_query($mysqli,$consulta);
                                        $num_reg = mysqli_num_rows($res);
                                        while($row1 = $res->fetch_array())
                                        {
                                        ?>
                                <option value='<?php echo $row1['id_cole']; ?>'<?php if($id_cole==$row1['id_cole']){echo 'selected';} ?>>
                                    <?php echo utf8_encode($row1['nombre_cole']); ?>
                                </option>
                                        <?php
                                        }
                                        ?>    
                            </select>
                </div>
            </div>
            <!-- ------------------------ -->
            <?php
            $sql = "SELECT m.zona_colegio
                    FROM colegios m
                    JOIN proyec_pedag_transv c ON m.id_cole = c.id_cole
                    WHERE c.id_cole = $id_cole";

            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $zona_colegio = $row["zona_colegio"];
            } else {
                $zona_colegio = "zona colegio no encontrada";
            }

            // $mysqli->close();
            ?>
            <div class="form-group">
                <label for="zona_colegio">Zona</label>
                <div class="row">
                    <div class="col-12 col-sm-3">
                    <input type='text' name='zona_colegio' class='form-control' style="text-transform:uppercase;" value="<?php echo $zona_colegio; ?>" readonly/> 
                    </div>
                </div>
            </div> 
            
         <!-- municipio -->
         <?php
            $sql = "SELECT m.nombre_mun
                    FROM municipios m
                    JOIN colegios c ON m.id_mun = c.id_mun
                    WHERE c.id_cole = $id_cole";

            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nombre_mun = $row["nombre_mun"];
            } else {
                $nombre_mun = "Municipio no encontrado";
            }

            $mysqli->close();
            ?>
            <div class="form-group">
                <label for="municipio">Municipio</label>
                <div class="row">
                    <div class="col-12 col-sm-3">
                    <!-- <label for="nombre_tipo_proy_trans">Municipio</label>        -->
                    <input type='text' name='municipio' class='form-control' style="text-transform:uppercase;" value="<?php echo $nombre_mun; ?>" readonly/> 
                    </div>
                </div>
            </div>
            
            <!-- ------------------------ -->
            <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="nombre_proy_trans">* NOMBRE DEL PROYECTO:</label>

                            

                            <select class="form-control" name="selec_proyec_transv" required id="selectProy">

                                

                                <option value=""></option>
                                <option value="PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC">PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC</option>
                                <option value="PROYECTO DE EDUCACIÓN AMBIENTAL PRAE">PROYECTO DE EDUCACIÓN AMBIENTAL PRAE</option>
                                <option value="PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS">PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS</option>
                                <option value="PROYECTO DE EDUCACION VIAL">PROYECTO DE EDUCACIÓN VIAL </option>                                
                            </select>
                        </div>
                    </div>
                </div>           
                     

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Número de estudiantes vinculados al proyecto en los diferentes niveles educativos En: </font></p>            

            <label for="num_est_trans">Transición:</label>
          
            <input type='number' name='num_est_trans' class='form-control' required required value="" style="text-transform:uppercase;" />
                      
            <label for="num_est_pri">Primaria:</label>
          
            <input type='number' name='num_est_pri' class='form-control' required value="" required value=0 style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Secundaria:</label>
          
            <input type='number' name='num_est_secun' class='form-control' required value=""style="text-transform:uppercase;" />

            <label for="nombre_tipo_proy_trans">Media:</label>
          
            <input type='number' name='num_est_media' class='form-control' required value="" style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">  


            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Documentos de soporte con que cuenta el proyecto (relacione el nombre del documento): </font></p>

            <label for="nombre_tipo_proy_trans">Internacionales:</label>
          
               <input type='text' name='inter_doc' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Nacionales:</label>
          
               <input type='text' name='nac_doc' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Departamentales:</label>
          
               <input type='text' name='dep_doc' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Locales:</label>
          
               <input type='text' name='local_doc' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Institucionales:</label>
          
               <input type='text' name='insti_doc' class='form-control' required value="" style="text-transform:uppercase;" />


            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Documentos de soporte normativo (nombre las Leyes, decretos, resoluciones, directrices, lineamientos, otros): </font></p>

            <label for="nombre_tipo_proy_trans">Internacionales:</label>
          
            <input type='text' name='inter_doc_norm' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Nacionales:</label>
          
            <input type='text' name='nac_doc_norm' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Departamentales:</label>
          
            <input type='text' name='dep_doc_norm' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Locales:</label>
          
            <input type='text' name='local_doc_norm' class='form-control' required value="" style="text-transform:uppercase;" /> 

            <label for="nombre_tipo_proy_trans">Institucionales:</label>
          
            <input type='text' name='insti_doc_norm' class='form-control' required value="" style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">
            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <label for="nombre_tipo_proy_trans">Número de años de implementación:</label>

            <input type='number' name='num_anos_implem' class='form-control' required value="" style="text-transform:uppercase;" />  

            <div class="container">


            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">


            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿Esta integrado el proyecto al PEI?</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_pei" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div> 

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">
            
            

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Ejes de trabajo curricular del proyecto (enuncie):</font></p>
            
            <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='Tem_curr_proy'>* Temas:</label>
                            <textarea class="form-control" rows="3" name="Tem_curr_proy" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>
            

             
            <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='Prob_curr_proy'>* Problemas:</label>
                            <textarea class="form-control" rows="3" name="Prob_curr_proy" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div> 

                 
              

            <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='activ_curr_proy'>* Actividades:</label>
                            <textarea class="form-control" rows="3" name="activ_curr_proy"required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>


                

            

            <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='preg1_2_plan_uso'>* Otros:</label>
                            <textarea class="form-control" rows="3" name="otros" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>


            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿Cuenta el proyecto con mesas de trabajo o espacios institucionales donde participen estudiantes, docentes, directivos, administrativos y padres de familia que realizan seguimiento y evaluación al mismo?</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_mes_trab" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div> 

             <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿Los ejes (problemáticos) de trabajo del proyecto obedecen a una lectura de contexto institucional? ¿Están identiificadas las causas del problema?:</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_prob" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>

            <hr style="border: 2px dotted #909797; border-radius: 1px;"> 

            
            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿Las actividades y acciones del proyecto están claramente explícitadas y enmarcadas en la construcción de ciudadanía, en la convivencia y en el ejercicio de los derechos humanos en la solución del problema (o problemática) identificado?</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="fuert_prob" required/>
                                   <option value=""></option>   
                                   <option value="FUERTEMENTE">FUERTEMENTE</option>
                                   <option value="DEBILMENTE">DEBILMENTE</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>

             <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <label for="nombre_tipo_proy_trans">Otros:</label>
          
            <input type='text' name="otro_prob" class='form-control' required value=0 style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿El proyecto realmente prepara a los estudiantes para la solución de problemas cotidianos que están relacionados con su entorno social, cultural, científico, tecnológico?:</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_sol_prob" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>            

            <hr style="border: 2px dotted #909797; border-radius: 1px;"> 

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿El proyecto articula y correlaciona varias áreas o campos del saber en el desarrollo de conocimientos, habilidades, actitudes y aptitudes en los estudiantes, maestros, directivos y comunidad educativa en general?:</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="fuert_art_areas" required/>
                                   <option value=""></option>   
                                   <option value="FUERTEMENTE">FUERTEMENTE</option>
                                   <option value="DEBILMENTE">DEBILMENTE</option>
                                   <option value="NO EXISTE ARTICULACION">NO EXISTE ARTICULACION</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>

            <hr style="border: 2px dotted #909797; border-radius: 1px;"> 

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Numero de revisiones realizadas al proyecto: </font></p>

            <label for="nombre_tipo_proy_trans">Numero:</label>
          
            <input type='number' name='num_revis_proy' class='form-control' required style="text-transform:uppercase;" />
            <hr style="border: 2px dotted #909797; border-radius: 1px;">  

            <label for="nombre_tipo_proy_trans">Años en que los realizo:</label>
          
            <input type='number' name='anos_rev_proyec' class='form-control' required style="text-transform:uppercase;" />
            <hr style="border: 2px dotted #909797; border-radius: 1px;"> 

            
            <div class="col-12 col-sm-3">
                            <label for="fecha_seg">Fecha de actualización del proyecto:</label>
                             <input type='date' name='fec_act_proyecto' required value='<?php echo date("Y-m-d");?>' class='form-control' />

            </div>

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;"> 

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">El proyecto ha sido reconocido como significativo por alguna entidad (nombre de la entidad, año)?: </font></p>

            <label for="nombre_tipo_proy_trans">Nombre de la entidad y año:</label>

          
            <input type='text' name='exist_niv_proy' class='form-control' style="text-transform:uppercase;" />
            <hr style="border: 2px dotted #909797; border-radius: 1px;">  

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿En qué nivel de desarrollo institucional se sitúa el Proyecto?</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="exist_niv_proy_1" required/>
                                   <option value=""></option>   
                                   <option value="EXISTENCIA">EXISTENCIA</option>
                                   <option value="PERTINENCIA">PERTINENCIA</option>
                                   <option value="APROPIACION">APROPIACION</option>
                                   <option value="MEJORAMIENTO CONTINUO">MEJORAMIENTO CONTINUO</option>

                        </select>
                    </div>
                    
                </div>
            </div>            

            <hr style="border: 2px dotted #909797; border-radius: 1px;"> 

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿El proyecto hace parte del PMI del 2023?:</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_pmi" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>             

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿El proyecto está vinculado al programa de Servicio Social del estudiantado de educación Media?:</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_proy_vin" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>            

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Numero de Estudiantes vinculados 2023 </font></p>

            <input type='number' name='num_est_vin_23' class='form-control' required value="" style="text-transform:uppercase;" />
            <hr style="border: 2px dotted #909797; border-radius: 1px;">  
            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿ El proyecto está claramente vinculado y articulado al programa de convivencia escolar, y contribuye con acciones y estrategias específicas a la Ruta de Atención Integral para la Convivencia Escolar?:</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_vin_conv_esc" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>        

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">


            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Responsable o líder del proyecto: </font></p>

            <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='nomb_lid_proy'>Nombres:</label>
                            <textarea class="form-control" rows="3" name="nomb_lid_proy" required value=0 style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>            
            

             <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Area de formación:</font></p>

             <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='area_form_proy'>Explicar</label>
                            <textarea class="form-control" rows="3" name="area_form_proy" required value=0 style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>               


                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="nombre_proy_trans">* Nivel o ciclo educativo de desempeño:</label>

                            

                            <select class="form-control" name="niv_cicl_desp" required>

                                

                                <option value=""></option>
                                <option value="Transición">Transición</option>
                                <option value="Básica primaria">Básica primaria</option>
                                <option value="Básica secundaria">Básica secundaria</option>
                                <option value="Media">Media </option>                                
                            </select>
                        </div>
                    </div>
                </div>
            <hr style="border: 2px dotted #909797; border-radius: 1px;">


            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Número de años vinculados al proyecto:</font></p>
            <input type='number' name='num_anos_vin_proy' class='form-control' style="text-transform:uppercase;" />

            

                <hr style="border: 2px dotted #909797; border-radius: 1px;">

                <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Cuenta con formación sobre el tema del proyecto:</font></p>

                 <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='cuent_for_proyec'>Explicar</label>
                            <textarea class="form-control" rows="3" name="cuent_for_proyec" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>

                <hr style="border: 2px dotted #909797; border-radius: 1px;">

                <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Ha recibido formación o capacitación (Si es del caso, nombre del curso recibido, si fue certificado, él numero de horas, y el año(s) de realización):</font></p>

               <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_cert_form_cap" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>
            
            <label for="nombre_tipo_proy_trans">Nombre del curso:</label>
             <input type='text' name='nom_curs_form_capac' required value="" class='form-control' style="text-transform:uppercase;" />
             
            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿Si fue certificado?:</font></p>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_fue_cert" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>
            <hr style="border: 2px dotted #909797; border-radius: 1px;">
            
            <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='preg1_2_plan_uso'>Numero de horas y año de realización:</label>
                            <textarea class="form-control" rows="3" name="si_fue_cert_num_anos" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>
                <hr style="border: 2px dotted #909797; border-radius: 1px;">                

                <label for="nombre_tipo_proy_trans">Número de teléfono de contacto:</label>
          
                <input type='number' name='Num_contacts' class='form-control' style="text-transform:uppercase;" />


                <hr style="border: 2px dotted #909797; border-radius: 1px;">

                <hr style="border: 2px dotted #909797; border-radius: 1px;">

                   

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">ARTICULACION INTERINSTITUCIONAL E INTERSECTORIAL (Enuncie, Años de articulación): </font></p>            

            <label for="nombre_tipo_proy_trans">Secretaría de educación(Enuncie, Años de articulación):</label>
          
            <input type='text' name='secret_anos_art' class='form-control' style="text-transform:uppercase;" />

            <label for="nombre_tipo_proy_trans">Centros de educación superior(Enuncie, Años de articulación):</label>
          
            <input type='text' name='centros_anos_art_sup' required value="" class='form-control' style="text-transform:uppercase;" />
            
            <label for="nombre_tipo_proy_trans">Sena(Enuncie, Años de articulación):</label>
          
            <input type='text' name='sena_anos_art' required value="" class='form-control' style="text-transform:uppercase;" />

            <!-- <label for="nombre_tipo_proy_trans">Centros de educación superior(Enuncie, Años de articulación):</label>
          
            <input type='text' name='centros_anos_art_sup' required value=0 class='form-control' style="text-transform:uppercase;" />  -->

             <hr style="border: 2px dotted #909797; border-radius: 1px;">
              <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <label for="nombre_tipo_proy_trans">INSTITUCIONES NACIONALES CON ASIENTO EN EL DEPARTAMENTO(COMO EL ICBF,ICA...)(Enuncie, Años de articulación):</label>
          
            <input type='text' name='int_nac_dep_art' required value="" class='form-control' style="text-transform:uppercase;" />


            <hr style="border: 2px dotted #909797; border-radius: 1px;">
            <hr style="border: 2px dotted #909797; border-radius: 1px;">


            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Gubernamentales, judiciales, legislativas (diferentes a las educativas):</font></p>

            <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='corp_jud_leg'>Corporaciones:</label>
                            <textarea class="form-control" rows="3" name="corp_jud_leg" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>                
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='sec_jud_leg'>Secretaria de despacho:</label>
                            <textarea class="form-control" rows="3" name="sec_jud_leg" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>                
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='dep_jud_leg'>Dependencias judiciales:</label>
                            <textarea class="form-control" rows="3" name="dep_jud_leg" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>                

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='de_cont_dif_edu'>De control:</label>
                            <textarea class="form-control" rows="3" name="de_cont_dif_edu" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>                

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='cent_jud_leg'>Centros de investigación:</label>
                            <textarea class="form-control" rows="3" name="cent_jud_leg" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>

                <hr style="border: 2px dotted #909797; border-radius: 1px;">
                <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">No gubernamentales:</font></p>

               

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='ong_depto'>Ong:</label>
                            <textarea class="form-control" rows="3" name="ong_depto" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='org_priv_depto'>Organizaciones privadas:</label>
                            <textarea class="form-control" rows="3" name="org_priv_depto" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='org_com_depto'>Organizaciones comunitarias:</label>
                            <textarea class="form-control" rows="3" name="org_com_depto" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for='otras_depto'>Otras(¿cuales?):</label>
                            <textarea class="form-control" rows="3" name="otras_depto" required value="" style="text-transform:uppercase;" cols="123" ></textarea>
                        </div>
                    </div>
                </div>

                 <hr style="border: 2px dotted #909797; border-radius: 1px;">
                  <hr style="border: 2px dotted #909797; border-radius: 1px;">
                <!-- repetida -->
                <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">La articulación realizada con las instituciones es:</font></p>

                <label for="nombre_tipo_proy_trans">Educativas:</label>
            
                <div class="form-group">
                  <div class="row">
                      <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_fuer_edu_art_int" required/>
                                   <option value=""></option>   
                                   <option value="FUERTE">FUERTE</option>
                                   <option value="DEBIL">DEBIL</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>           
              <!-- repetida -->
            
            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">La articulación realizada con las instituciones es:</font></p>

                <label for="nombre_tipo_proy_trans">Educativas:</label>
            
                <div class="form-group">
                  <div class="row">
                      <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_fuer_edu_gub_int" required/>
                                   <option value=""></option>   
                                   <option value="FUERTE">FUERTE</option>
                                   <option value="DEBIL">DEBIL</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>           

        <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Gubernamentales, diferentes a las educativas:</font></p>

                <div class="form-group">
                  <div class="row">
                      <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_fuer_edu_art_no_int" required/>
                                   <option value=""></option>   
                                   <option value="FUERTE">FUERTE</option>
                                   <option value="DEBIL">DEBIL</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>            
            
        <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">No gubernamentales</font></p>

                <div class="form-group">
                  <div class="row">
                      <div class="col-12 col-sm-3">
                        <select class="form-control" name="si_fuer_no_gub" required/>
                                   <option value=""></option>   
                                   <option value="FUERTE">FUERTE</option>
                                   <option value="DEBIL">DEBIL</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>
            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

        <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Apoyo externo recibido:</font></p>



            <label for="inst_nom_apoy_ext">Instituciones (nombre):</label>
          
            <input type='text' name='inst_nom_apoy_ext' required value="" class='form-control' style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <label for="num_anos_apoy">Numero de año de apoyo:</label>
          
            <input type='number' name='num_anos_apoy' required value="" class='form-control' style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Tipo de apoyo (financiero,logistico,tecnologico,tecnico-pedagogico,asesoria,acompañamiento,otro):</font></p>



            <label for="fin_tip_apoy">Financiero</label>          
            <input type='text' name='fin_tip_apoy'required value="" class='form-control' style="text-transform:uppercase;" />

            <label for="log_tip_apoy">Logistico</label>          
            <input type='text' name='log_tip_apoy'required value="" class='form-control' style="text-transform:uppercase;" />
                     
            <label for="tecn_tip_apoy">Tecnológico</label>            
            <input type='text' name='tecn_tip_apoy'required value="" class='form-control' style="text-transform:uppercase;" />
            
            <label for="tec_peda_tip_apoy">Técnico pedagogico</label>
            <input type='text' name='tec_peda_tip_apoy'required value="" class='form-control' style="text-transform:uppercase;" />
          
            <label for="ases_tip_apoy">Asesoria</label>
            <input type='text' name='ases_tip_apoy'required value="" class='form-control' style="text-transform:uppercase;" />
          
            <label for="acomp_tip_apoy">Acompañamiento</label>
            <input type='text' name='acomp_tip_apoy'required value="" class='form-control' style="text-transform:uppercase;" />
          
            <label for="sin_tip_apoy">Sin apoyo</label>
            <input type='text' name='sin_tip_apoy'required value="" class='form-control' style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

             <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">Necesidades del proyecto</font></p>

            <label for='preg1_2_plan_uso'>Necesidades actuales asistencia y/o apoyo:</label>
            <label for="fin_nec_proy">Financiera</label>          
            <input type='text' name='fin_nec_proy'required value="" class='form-control' style="text-transform:uppercase;" />

            <label for="log_nec_proy">Logistica</label>          
            <input type='text' name='log_nec_proy'required value="" class='form-control' style="text-transform:uppercase;" />
            
            <label for="tec_nec_proy">Tecnológica</label>            
            <input type='text' name='tec_nec_proy'required value="" class='form-control' style="text-transform:uppercase;" />
            
            <label for="for_doc_nec_proy">Formación docente</label>
            <input type='text' name='for_doc_nec_proy' class='form-control' style="text-transform:uppercase;" />
          
            <label for="tecn_pedag_nec_proy">Técnico - pedagógico</label>
            <input type='text' name='tecn_pedag_nec_proy'required value="" class='form-control' style="text-transform:uppercase;" />         
            

            <label for="ases_direc_doc_nec_proy">Asesoría a directivos docentes</label>
            <input type='text' name='ases_direc_doc_nec_proy'required value="" class='form-control' style="text-transform:uppercase;" />         
            

            <label for="acomp_nec_proy">Acompañamiento</label>
            <input type='text' name='acomp_nec_proy'required value="" class='form-control' style="text-transform:uppercase;" />

            <label for="no_se_req_nec_proy">No se requiere</label>
            <input type='text' name='no_se_req_nec_proy'required value="" class='form-control' style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿En qué año recibió la última asesoría y/o apoyo de la Secretaría de Educación departamental, relacionada con el proyecto?:</font></p>

            <label for="log_ano_ult">Logística</label>          
            <input type='number' name='log_ano_ult'required value="" class='form-control' style="text-transform:uppercase;" />

            <label for="tecn_ano_ult">Tecnología</label>          
            <input type='number' name='tecn_ano_ult'required value="" class='form-control' style="text-transform:uppercase;" />
            
            <label for="ases_ano_ult">Asesoría</label>            
            <input type='number' name='ases_ano_ult'required value="" class='form-control' style="text-transform:uppercase;" />
            
            <label for="fin_ano_ult">Financiera</label>
            <input type='number' name='fin_ano_ult'required value="" class='form-control' style="text-transform:uppercase;" />
          
            <label for="form_doc_año_ult">Formación docente(especifique el (los) temas:</label>
            <input type='text' name='form_doc_ano_ult'required value="" class='form-control' style="text-transform:uppercase;" />
          
            <label for="tec_pedag_año_ult">Técnico pedagógico (especifique el (los) temas :</label>
            <input type='text' name='tec_pedag_ano_ult'required value="" class='form-control' style="text-transform:uppercase;" />
          
            <label for="otro_ano_ult">Otros (¿Cual?)</label>
            <input type='text' name='otro_ano_ult'required value="" class='form-control' style="text-transform:uppercase;" />            

            <label for="no_requie_eficaz">No se requiere</label>
            <input type='text' name='no_requie_eficaz'required value="" class='form-control' style="text-transform:uppercase;" />

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

            <hr style="border: 2px dotted #909797; border-radius: 1px;">

             <p align="justify"><font size=4 color=#000000 style="font-family: georgia; font-size: 18px;">¿Fue oportuna, pertinente y eficaz la asesoría y/o apoyo?</font></p>

                        
                <div class="form-group">
                  <div class="row">
                      <div class="col-12 col-sm-3">
                        <select class="form-control" name="Fue_oport" required/>
                                   <option value=""></option>   
                                   <option value="SI">SI</option>
                                   <option value="NO">NO</option>
                       
                        </select>
                    </div>
                    
                </div>
            </div>

                <hr style="border: 2px dotted #909797; border-radius: 1px;">

                <hr style="border: 2px dotted #909797; border-radius: 1px;">

                        
                <hr style="border: 4px solid #04547c; border-radius: 3px;">
                <div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <label for="archivo"><i class="fas fa-file-pdf"></i> ADJUNTAR DOCUMENTOS RELACIONADOS CON EL PROYECTOS PEDAGÓGICOS:</label>
	                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/msexcel, application/msword, application/pdf, application/rtf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/*">
	                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;">Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
	                    </div>
                	</div>
            	</div>
                <input type="hidden" name="id_cole" value="<?= $id_cole; ?>" />

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