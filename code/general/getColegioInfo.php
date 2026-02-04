<?php
header("Content-Type: application/json; charset=utf-8");
include("./../../conexion.php");
session_start();

if(!isset($_SESSION['id'])){
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

if(isset($_GET['cod_dane_cole'])) {
    $cod_dane_cole = mysqli_real_escape_string($mysqli, $_GET['cod_dane_cole']);
    
    $sql = mysqli_query($mysqli, "SELECT c.*, m.nombre_mun 
                                   FROM colegios c 
                                   LEFT JOIN municipios m ON c.id_mun = m.id_mun 
                                   WHERE c.cod_dane_cole = '$cod_dane_cole'");
    
    if($row = mysqli_fetch_array($sql)) {
        // Preparar los datos en formato JSON
        $data = array(
            'cod_dane_cole' => $row['cod_dane_cole'],
            'nit_cole' => $row['nit_cole'],
            'nombre_cole' => $row['nombre_cole'],
            'direccion_cole' => $row['direccion_cole'],
            'nombre_rector_cole' => $row['nombre_rector_cole'],
            'tel_rector_cole' => $row['tel_rector_cole'],
            
            // Jornadas
            'jor_1_cole' => $row['jor_1_cole'],
            'jor_2_cole' => $row['jor_2_cole'],
            'jor_3_cole' => $row['jor_3_cole'],
            'jor_4_cole' => $row['jor_4_cole'],
            'jor_5_cole' => $row['jor_5_cole'],
            'jor_6_cole' => $row['jor_6_cole'],
            'jor_7_cole' => $row['jor_7_cole'],
            'jor_8_cole' => $row['jor_8_cole'],
            'jor_9_cole' => $row['jor_9_cole'],
            'jor_10_cole' => $row['jor_10_cole'],
            
            // Niveles
            'niv_1_cole' => $row['niv_1_cole'],
            'niv_2_cole' => $row['niv_2_cole'],
            'niv_3_cole' => $row['niv_3_cole'],
            'niv_4_cole' => $row['niv_4_cole'],
            
            // Ciclos
            'tiene_ciclos' => isset($row['tiene_ciclos']) ? $row['tiene_ciclos'] : 0,
            'ciclo_0' => isset($row['ciclo_0']) ? $row['ciclo_0'] : 0,
            'ciclo_1' => isset($row['ciclo_1']) ? $row['ciclo_1'] : 0,
            'ciclo_2' => isset($row['ciclo_2']) ? $row['ciclo_2'] : 0,
            'ciclo_3' => isset($row['ciclo_3']) ? $row['ciclo_3'] : 0,
            'ciclo_4' => isset($row['ciclo_4']) ? $row['ciclo_4'] : 0,
            'ciclo_5' => isset($row['ciclo_5']) ? $row['ciclo_5'] : 0,
            'ciclo_6' => isset($row['ciclo_6']) ? $row['ciclo_6'] : 0,
            
            // Modelos Educativos Flexibles
            'modelo_escuela_nueva' => isset($row['modelo_escuela_nueva']) ? $row['modelo_escuela_nueva'] : 0,
            'modelo_aceleracion' => isset($row['modelo_aceleracion']) ? $row['modelo_aceleracion'] : 0,
            'modelo_post_primaria' => isset($row['modelo_post_primaria']) ? $row['modelo_post_primaria'] : 0,
            'modelo_caminar_secundaria' => isset($row['modelo_caminar_secundaria']) ? $row['modelo_caminar_secundaria'] : 0,
            'modelo_pensar_secundaria' => isset($row['modelo_pensar_secundaria']) ? $row['modelo_pensar_secundaria'] : 0,
            'modelo_media_rural' => isset($row['modelo_media_rural']) ? $row['modelo_media_rural'] : 0,
            'modelo_pensar_media' => isset($row['modelo_pensar_media']) ? $row['modelo_pensar_media'] : 0,
            'modelo_otro' => isset($row['modelo_otro']) ? $row['modelo_otro'] : 0,
            'modelo_otro_cual' => isset($row['modelo_otro_cual']) ? $row['modelo_otro_cual'] : '',
            
            // Carácter de la Media
            'car_med_1_cole' => $row['car_med_1_cole'],
            'car_med_2_cole' => $row['car_med_2_cole'],
            'especialidades_tecnica' => isset($row['especialidades_tecnica']) ? $row['especialidades_tecnica'] : '',
            'especialidad_academica' => isset($row['especialidad_academica']) ? $row['especialidad_academica'] : '',
            
            // Otros datos
            'corregimiento_cole' => $row['corregimiento_cole'],
            'nombre_mun' => isset($row['nombre_mun']) ? $row['nombre_mun'] : '',
            'tel1_cole' => $row['tel1_cole'],
            'tel2_cole' => $row['tel2_cole'],
            'email_cole' => $row['email_cole'],
            'num_act_adm_cole' => $row['num_act_adm_cole'],
            'fec_res_cole' => $row['fec_res_cole'],
            'obs_cole' => $row['obs_cole'],
            'fecha_edit_cole' => isset($row['fecha_edit_cole']) ? $row['fecha_edit_cole'] : ''
        );
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => 'No se encontró el colegio']);
    }
} else {
    echo json_encode(['error' => 'Parámetro cod_dane_cole no proporcionado']);
}
?>
