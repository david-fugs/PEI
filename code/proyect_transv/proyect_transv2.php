<?php

session_start();

if (!isset($_SESSION['id'])) {
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TIC | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <?php
    include("../../conexion.php");
    date_default_timezone_set("America/Bogota");

    if (isset($_POST['btn-update'])) {


        // $Id_proyec_pedag_transv      =   $_POST['Id_proyec_pedag_transv'];
        $selec_proyec_transv         =   $_POST['selec_proyec_transv'];

        $num_est_trans               =   $_POST['num_est_trans'];
        $num_est_pri                 =   $_POST['num_est_pri'];
        $num_est_secun               =   $_POST['num_est_secun'];
        $num_est_media               =   $_POST['num_est_media'];
        $inter_doc                   =   $_POST['inter_doc'];
        $nac_doc                     =   $_POST['nac_doc'];
        $dep_doc                     =   $_POST['dep_doc'];
        $local_doc                   =   $_POST['local_doc'];
        $insti_doc                   =   $_POST['insti_doc'];
        $inter_doc_norm              =   $_POST['inter_doc_norm'];
        $nac_doc_norm                =   $_POST['nac_doc_norm'];
        $dep_doc_norm                =   $_POST['dep_doc_norm'];
        $local_doc_norm              =   $_POST['local_doc_norm'];
        $insti_doc_norm              =   $_POST['insti_doc_norm'];
        $num_anos_implem             =   $_POST['num_anos_implem'];
        $si_pei                      =   $_POST['si_pei'];
        $Tem_curr_proy               =   $_POST['Tem_curr_proy'];
        $Prob_curr_proy              =   $_POST['Prob_curr_proy'];
        $activ_curr_proy             =   $_POST['activ_curr_proy'];
        $otros                       =   $_POST['otros'];
        $si_mes_trab                 =   $_POST['si_mes_trab'];
        $si_prob                     =   $_POST['si_prob'];
        $fuert_prob                  =   $_POST['fuert_prob'];
        $otro_prob                   =   $_POST['otro_prob'];
        $si_sol_prob                 =   $_POST['si_sol_prob'];
        $fuert_art_areas             =   $_POST['fuert_art_areas'];
        $num_revis_proy              =   $_POST['num_revis_proy'];
        $anos_rev_proyec             =   $_POST['anos_rev_proyec'];
        $fec_act_proyecto            =   $_POST['fec_act_proyecto'];
        $exist_niv_proy              =   $_POST['exist_niv_proy'];
        $exist_niv_proy_1            =   $_POST['exist_niv_proy_1'];
        $si_pmi                      =   $_POST['si_pmi'];
        $si_proy_vin                 =   $_POST['si_proy_vin'];
        $num_est_vin_23              =   $_POST['num_est_vin_23'];
        $si_vin_conv_esc             =   $_POST['si_vin_conv_esc'];
        $nomb_lid_proy               =   $_POST['nomb_lid_proy'];
        $area_form_proy              =   $_POST['area_form_proy'];
        $niv_cicl_desp               =   $_POST['niv_cicl_desp'];
        $num_anos_vin_proy           =   $_POST['num_anos_vin_proy'];
        $cuent_for_proyec            =   $_POST['cuent_for_proyec'];
        $si_cert_form_cap            =   $_POST['si_cert_form_cap'];
        $nom_curs_form_capac         =   $_POST['nom_curs_form_capac'];
        $si_fue_cert                 =   $_POST['si_fue_cert'];
        $si_fue_cert_num_anos        =   $_POST['si_fue_cert_num_anos'];
        $Num_contacts                =   $_POST['Num_contacts'];
        $secret_anos_art             =   $_POST['secret_anos_art'];
        // $centr_anos_art              =   $_POST['centr_anos_art'];
        $sena_anos_art               =   $_POST['sena_anos_art'];
        $centros_anos_art_sup        =   $_POST['centros_anos_art_sup'];
        $int_nac_dep_art             =   $_POST['int_nac_dep_art'];
        $corp_jud_leg                =   $_POST['corp_jud_leg'];
        $sec_jud_leg                 =   $_POST['sec_jud_leg'];
        $dep_jud_leg                 =   $_POST['dep_jud_leg'];
        $de_cont_dif_edu             =   $_POST['de_cont_dif_edu'];
        $cent_jud_leg                =   $_POST['cent_jud_leg'];
        $ong_depto                   =   $_POST['ong_depto'];
        $org_priv_depto              =   $_POST['org_priv_depto'];
        $org_com_depto               =   $_POST['org_com_depto'];
        $otras_depto                 =   $_POST['otras_depto'];
        $si_fuer_edu_art_int         =   $_POST['si_fuer_edu_art_int'];
        $si_fuer_edu_gub_int         =   $_POST['si_fuer_edu_gub_int'];
        $si_fuer_edu_art_no_int      =   $_POST['si_fuer_edu_art_no_int'];
        $si_fuer_no_gub              =   $_POST['si_fuer_no_gub'];
        $inst_nom_apoy_ext           =   $_POST['inst_nom_apoy_ext'];
        $num_anos_apoy               =   $_POST['num_anos_apoy'];
        $fin_tip_apoy                =   $_POST['fin_tip_apoy'];
        $log_tip_apoy                =   $_POST['log_tip_apoy'];
        $tecn_tip_apoy               =   $_POST['tecn_tip_apoy'];
        $tec_peda_tip_apoy           =   $_POST['tec_peda_tip_apoy'];
        $ases_tip_apoy               =   $_POST['ases_tip_apoy'];
        $acomp_tip_apoy              =   $_POST['acomp_tip_apoy'];
        $sin_tip_apoy                =   $_POST['sin_tip_apoy'];
        $fin_nec_proy                =   $_POST['fin_nec_proy'];
        $log_nec_proy                =   $_POST['log_nec_proy'];
        $tec_nec_proy                =   $_POST['tec_nec_proy'];
        $for_doc_nec_proy            =   $_POST['for_doc_nec_proy'];
        $tecn_pedag_nec_proy         =   $_POST['tecn_pedag_nec_proy'];
        $ases_direc_doc_nec_proy     =   $_POST['ases_direc_doc_nec_proy'];
        $acomp_nec_proy              =   $_POST['acomp_nec_proy'];
        $no_se_req_nec_proy          =   $_POST['no_se_req_nec_proy'];
        $log_ano_ult                 =   $_POST['log_ano_ult'];
        $tecn_ano_ult                =   $_POST['tecn_ano_ult'];
        $ases_ano_ult                =   $_POST['ases_ano_ult'];
        $fin_ano_ult                 =   $_POST['fin_ano_ult'];
        $form_doc_ano_ult            =   $_POST['form_doc_ano_ult'];
        $tec_pedag_ano_ult           =   $_POST['tec_pedag_ano_ult'];
        $otro_ano_ult                =   $_POST['otro_ano_ult'];
        $no_requie_eficaz            =   $_POST['no_requie_eficaz'];
        $Fue_oport                   =   $_POST['Fue_oport'];
        $id_cole                     =   $_POST['id_cole'];
        $estado_proyec_pedag_transv  =   1;
        $fecha_proyec_pedag_transv   =   date('Y-m-d h:i:s');
        $id_usu                         =   $_SESSION['id'];
        $update = "INSERT INTO proyec_pedag_transv(selec_proyec_transv, num_est_trans, num_est_pri, num_est_secun, num_est_media, inter_doc, nac_doc, dep_doc, local_doc, insti_doc, inter_doc_norm, nac_doc_norm, dep_doc_norm, local_doc_norm, insti_doc_norm, num_anos_implem, si_pei, Tem_curr_proy, Prob_curr_proy, activ_curr_proy, otros, si_mes_trab, si_prob, fuert_prob, otro_prob, si_sol_prob, fuert_art_areas, num_revis_proy, anos_rev_proyec, fec_act_proyecto, exist_niv_proy, exist_niv_proy_1, si_pmi, si_proy_vin, num_est_vin_23, si_vin_conv_esc, nomb_lid_proy, area_form_proy, niv_cicl_desp, num_anos_vin_proy, cuent_for_proyec, si_cert_form_cap, nom_curs_form_capac, si_fue_cert, si_fue_cert_num_anos, Num_contacts, secret_anos_art, centros_anos_art_sup, sena_anos_art, int_nac_dep_art, corp_jud_leg, sec_jud_leg, dep_jud_leg, de_cont_dif_edu, cent_jud_leg, ong_depto, org_priv_depto, org_com_depto, otras_depto, si_fuer_edu_art_int, si_fuer_edu_gub_int, si_fuer_edu_art_no_int, si_fuer_no_gub, inst_nom_apoy_ext, num_anos_apoy, fin_tip_apoy, log_tip_apoy, tecn_tip_apoy, tec_peda_tip_apoy, ases_tip_apoy, acomp_tip_apoy, sin_tip_apoy, fin_nec_proy, log_nec_proy, tec_nec_proy, for_doc_nec_proy, tecn_pedag_nec_proy, ases_direc_doc_nec_proy, acomp_nec_proy, no_se_req_nec_proy, log_ano_ult, tecn_ano_ult, ases_ano_ult, fin_ano_ult, form_doc_ano_ult, tec_pedag_ano_ult, otro_ano_ult, no_requie_eficaz, Fue_oport, id_cole, estado_proyec_pedag_transv, fecha_proyec_pedag_transv, id_usu) values ('$selec_proyec_transv', '$num_est_trans', '$num_est_pri', '$num_est_secun', '$num_est_media', '$inter_doc',  '$nac_doc', '$dep_doc', '$local_doc ', '$insti_doc ', '$inter_doc_norm', '$nac_doc_norm', '$dep_doc_norm', '$local_doc_norm','$insti_doc_norm', '$num_anos_implem', '$si_pei', '$Tem_curr_proy', '$Prob_curr_proy', '$activ_curr_proy', '$otros','$si_mes_trab', '$si_prob', '$fuert_prob', '$otro_prob', '$si_sol_prob', '$fuert_art_areas', '$num_revis_proy', '$anos_rev_proyec','$fec_act_proyecto', '$exist_niv_proy','$exist_niv_proy_1', '$si_pmi', '$si_proy_vin', '$num_est_vin_23', '$si_vin_conv_esc','$nomb_lid_proy', '$area_form_proy', '$niv_cicl_desp', '$num_anos_vin_proy', '$cuent_for_proyec', '$si_cert_form_cap', '$nom_curs_form_capac', '$si_fue_cert','$si_fue_cert_num_anos', '$Num_contacts', '$secret_anos_art', '$centros_anos_art_sup', '$sena_anos_art', '$int_nac_dep_art', '$corp_jud_leg', '$sec_jud_leg', '$dep_jud_leg', '$de_cont_dif_edu', '$cent_jud_leg', '$ong_depto', '$org_priv_depto','$org_com_depto', '$otras_depto', '$si_fuer_edu_art_int', '$si_fuer_edu_gub_int', '$si_fuer_edu_art_no_int', '$si_fuer_no_gub','$inst_nom_apoy_ext', '$num_anos_apoy', '$fin_tip_apoy', '$log_tip_apoy', '$tecn_tip_apoy', '$tec_peda_tip_apoy', '$ases_tip_apoy','$acomp_tip_apoy', '$sin_tip_apoy', '$fin_nec_proy', '$log_nec_proy', '$tec_nec_proy', '$for_doc_nec_proy', '$tecn_pedag_nec_proy','$ases_direc_doc_nec_proy', '$acomp_nec_proy', '$no_se_req_nec_proy', '$log_ano_ult', '$tecn_ano_ult', '$ases_ano_ult', '$fin_ano_ult','$form_doc_ano_ult', '$tec_pedag_ano_ult', '$otro_ano_ult', '$no_requie_eficaz', '$Fue_oport', '$id_cole', '$estado_proyec_pedag_transv','$fecha_proyec_pedag_transv', '$id_usu')";
        // $update= "INSERT INTO proyec_pedag_transv(selec_proyec_transv, num_est_trans, num_est_pri, num_est_secun, num_est_media, inter_doc, nac_doc, dep_doc, local_doc, insti_doc, inter_doc_norm, nac_doc_norm, dep_doc_norm, local_doc_norm, insti_doc_norm, num_anos_implem, si_pei, Tem_curr_proy, Prob_curr_proy, activ_curr_proy, otros, si_mes_trab, si_prob, fuert_prob, otro_prob, si_sol_prob, fuert_art_areas, num_revis_proy, anos_rev_proyec, fec_act_proyecto, exist_niv_proy, exist_niv_proy_1, si_pmi, si_proy_vin, num_est_vin_23, si_vin_conv_esc, nomb_lid_proy, area_form_proy, niv_cicl_desp, num_anos_vin_proy, cuent_for_proyec, si_cert_form_cap, nom_curs_form_capac, si_fue_cert, si_fue_cert_num_anos, Num_contacts, secret_anos_art, centros_anos_art_sup, sena_anos_art, int_nac_dep_art, corp_jud_leg, sec_jud_leg, dep_jud_leg, de_cont_dif_edu, cent_jud_leg, ong_depto, org_priv_depto, org_com_depto, otras_depto, si_fuer_edu_gub_int, si_fuer_edu_art_no_int, si_fuer_no_gub, inst_nom_apoy_ext, num_anos_apoy, fin_tip_apoy, log_tip_apoy, tecn_tip_apoy, tec_peda_tip_apoy, ases_tip_apoy, acomp_tip_apoy, sin_tip_apoy, fin_nec_proy, log_nec_proy, tec_nec_proy, for_doc_nec_proy, tecn_pedag_nec_proy, ases_direc_doc_nec_proy, acomp_nec_proy, no_se_req_nec_proy, log_ano_ult, tecn_ano_ult, ases_ano_ult, fin_ano_ult, form_doc_ano_ult, tec_pedag_ano_ult, otro_ano_ult, no_requie_eficaz, Fue_oport, id_cole, estado_proyec_pedag_transv, fecha_proyec_pedag_transv, id_usu) values ('$selec_proyec_transv', '$num_est_trans', '$num_est_pri', '$num_est_secun', '$num_est_media', '$inter_doc',  '$nac_doc', '$dep_doc', '$local_doc ', '$insti_doc ', '$inter_doc_norm', '$nac_doc_norm', '$dep_doc_norm', '$local_doc_norm','$insti_doc_norm', '$num_anos_implem', '$si_pei', '$Tem_curr_proy', '$Prob_curr_proy', '$activ_curr_proy', '$otros','$si_mes_trab', '$si_prob', '$fuert_prob', '$otro_prob', '$si_sol_prob', '$fuert_art_areas', '$num_revis_proy', '$anos_rev_proyec','$fec_act_proyecto', '$exist_niv_proy','$exist_niv_proy_1', '$si_pmi', '$si_proy_vin', '$num_est_vin_23', '$si_vin_conv_esc','$nomb_lid_proy', '$area_form_proy', '$niv_cicl_desp', '$num_anos_vin_proy', '$cuent_for_proyec', '$si_cert_form_cap', '$nom_curs_form_capac', '$si_fue_cert','$si_fue_cert_num_anos', '$Num_contacts', '$secret_anos_art', '$centros_anos_art_sup', '$sena_anos_art', '$int_nac_dep_art', '$corp_jud_leg', '$sec_jud_leg', '$dep_jud_leg', '$de_cont_dif_edu', '$cent_jud_leg', '$ong_depto', '$org_priv_depto','$org_com_depto', '$otras_depto', '$si_fuer_edu_gub_int', '$si_fuer_edu_art_no_int', '$si_fuer_no_gub','$inst_nom_apoy_ext', '$num_anos_apoy', '$fin_tip_apoy', '$log_tip_apoy', '$tecn_tip_apoy', '$tec_peda_tip_apoy', '$ases_tip_apoy','$acomp_tip_apoy', '$sin_tip_apoy', '$fin_nec_proy', '$log_nec_proy', '$tec_nec_proy', '$for_doc_nec_proy', '$tecn_pedag_nec_proy','$ases_direc_doc_nec_proy', '$acomp_nec_proy', '$no_se_req_nec_proy', '$log_ano_ult', '$tecn_ano_ult', '$ases_ano_ult', '$fin_ano_ult','$form_doc_ano_ult', '$tec_pedag_ano_ult', '$otro_ano_ult', '$no_requie_eficaz', '$Fue_oport', '$id_cole', '$estado_proyec_pedag_transv','$fecha_proyec_pedag_transv', '$id_usu')";


        $up = mysqli_query($mysqli, $update);

        if ($up) {
            echo "
        <!DOCTYPE html>
        <html lang='es'>
            <head>
                <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                <link rel='stylesheet' href='../../css/bootstrap.min.css'>
                <link href='../../fontawesome/css/all.css' rel='stylesheet'>
                <title>RISPRO | SOFT</title>
                <style>
                    .responsive {
                        max-width: 100%;
                        height: auto;
                    }
                </style>
            </head>
            <body>
                <center>
                    <img src='../../img/gobersecre.png' width='300' height='141' class='responsive'>
                    <div class='container'>
                        <br />
                        <h3><b><i class='fas fa-school'></i> SE ACTUALIZÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                </center>
            </body>
        </html>
    ";
        } else {
            echo "❌ Error al actualizar el registro: " . mysqli_error($mysqli);
        }
    }
    ?>

</body>

</html>
<?php
$selec_proyec_transv = $_POST['selec_proyec_transv'];

switch ($selec_proyec_transv) {
    case "PROYECTO PARA LA EDUCACION SEXUAL Y CONSTRUCCION DE CIUDADANIA PESCC":
        $nroProject = 1;
        break;
    case "PROYECTO DE EDUCACIÓN AMBIENTAL PRAE":
        $nroProject = 2;
        break;
    case "PROYECTO PARA EL EJERCICIO DE LOS DERECHOS HUMANOS":
        $nroProject = 3;
        break;
    case "PROYECTO DE EDUCACION VIAL":
        $nroProject = 4;
        break;
        // default:

        //     $nroProject = 0; 
}


foreach ($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
    //Validamos que el archivo exista
    if ($_FILES["archivo"]["name"][$key]) {
        $filename = $_FILES["archivo"]["name"][$key];
        $source = $_FILES["archivo"]["tmp_name"][$key];

        // $directorio = './projectFiles/'.$id_cole.'/'.$id.'/'; 
        $directorio = './projectFiles/' . $id_cole . '/' . $nroProject . '/';

        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true) or die("No se puede crear el directorio de extracci&oacute;n");
        }

        $dir = opendir($directorio);
        $target_path = $directorio . '/' . $filename;


        if (move_uploaded_file($source, $target_path)) {
            //echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
        } else {
            echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
        }
        closedir($dir);
    }
}
