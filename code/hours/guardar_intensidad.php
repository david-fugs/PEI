<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cole = $_SESSION['id_cole'];
    $accion = $_POST['accion'];
    
    // Validar datos requeridos
    $area = mysqli_real_escape_string($mysqli, $_POST['area']);
    $asignatura = mysqli_real_escape_string($mysqli, $_POST['asignatura']);

    if (empty($area) || empty($asignatura)) {
        echo json_encode(['success' => false, 'message' => 'Área y asignatura son obligatorias']);
        exit();
    }
    
    // Obtener información del establecimiento
    $sql_colegio = "SELECT cod_dane_cole, nit_cole, nombre_cole FROM colegios WHERE id_cole = $id_cole";
    $result_colegio = mysqli_query($mysqli, $sql_colegio);
    $colegio = mysqli_fetch_assoc($result_colegio);
    
    // Procesar horas por grado
    $grados = [];
    $total_horas = 0;
    
    for ($i = 1; $i <= 11; $i++) {
        $grado_key = "grado_$i";
        $horas = isset($_POST[$grado_key]) ? floatval($_POST[$grado_key]) : 0;
        $grados[$grado_key] = $horas;
        $total_horas += $horas;
    }
    
    try {
        if ($accion == 'editar' && isset($_POST['id_registro'])) {
            // Actualizar registro existente
            $id_registro = intval($_POST['id_registro']);

            // Preparar valores escapados
            $nit = mysqli_real_escape_string($mysqli, $colegio['nit_cole']);
            $nombre_cole_esc = mysqli_real_escape_string($mysqli, $colegio['nombre_cole']);
            $area_esc = mysqli_real_escape_string($mysqli, $area);
            $asignatura_esc = mysqli_real_escape_string($mysqli, $asignatura);

            $vals = [];
            for ($i = 1; $i <= 11; $i++) {
                $k = 'grado_' . $i;
                $vals[$k] = floatval($grados[$k]);
            }

            $total = floatval($total_horas);

            $sql = "UPDATE intensidad_horaria_semanal SET 
                        nit_establecimiento = '$nit', 
                        nombre_establecimiento = '" . $nombre_cole_esc . "', 
                        area = '" . $area_esc . "', 
                        asignatura = '" . $asignatura_esc . "', 
                        grado_1 = " . $vals['grado_1'] . ", grado_2 = " . $vals['grado_2'] . ", grado_3 = " . $vals['grado_3'] . ", 
                        grado_4 = " . $vals['grado_4'] . ", grado_5 = " . $vals['grado_5'] . ", grado_6 = " . $vals['grado_6'] . ", 
                        grado_7 = " . $vals['grado_7'] . ", grado_8 = " . $vals['grado_8'] . ", grado_9 = " . $vals['grado_9'] . ", 
                        grado_10 = " . $vals['grado_10'] . ", grado_11 = " . $vals['grado_11'] . ", 
                        total_horas = " . $total . ", 
                        fecha_actualizacion = CURRENT_TIMESTAMP 
                    WHERE id = " . $id_registro;

            if (mysqli_query($mysqli, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Intensidad horaria actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . mysqli_error($mysqli)]);
            }

        } else {
            // Insertar nuevo registro
            
            // Verificar si ya existe el registro para esta institución (por nit) y la combinación área/asignatura
            $nit = mysqli_real_escape_string($mysqli, $colegio['nit_cole']);
            $nombre_cole_esc = mysqli_real_escape_string($mysqli, $colegio['nombre_cole']);
            $area_esc = mysqli_real_escape_string($mysqli, $area);
            $asignatura_esc = mysqli_real_escape_string($mysqli, $asignatura);

            // Check existente
            $sql_check = "SELECT id FROM intensidad_horaria_semanal 
                         WHERE nit_establecimiento = '$nit' AND area = '" . $area_esc . "' AND asignatura = '" . $asignatura_esc . "'";
            $result_check = mysqli_query($mysqli, $sql_check);

            if ($result_check && mysqli_num_rows($result_check) > 0) {
                echo json_encode(['success' => false, 'message' => 'Ya existe un registro para esta área y asignatura en esta institución', 'duplicate' => true]);
                exit();
            }

            $vals = [];
            for ($i = 1; $i <= 11; $i++) {
                $k = 'grado_' . $i;
                $vals[$k] = floatval($grados[$k]);
            }

            $total = floatval($total_horas);

            $sql = "INSERT INTO intensidad_horaria_semanal 
                    (nit_establecimiento, nombre_establecimiento, area, asignatura, 
                     grado_1, grado_2, grado_3, grado_4, grado_5, grado_6, grado_7, grado_8, grado_9, grado_10, grado_11, 
                     total_horas) 
                    VALUES ('" . $nit . "', '" . $nombre_cole_esc . "', '" . $area_esc . "', '" . $asignatura_esc . "', 
                            " . $vals['grado_1'] . ", " . $vals['grado_2'] . ", " . $vals['grado_3'] . ", " . $vals['grado_4'] . ", " . $vals['grado_5'] . ", 
                            " . $vals['grado_6'] . ", " . $vals['grado_7'] . ", " . $vals['grado_8'] . ", " . $vals['grado_9'] . ", " . $vals['grado_10'] . ", " . $vals['grado_11'] . ", 
                            " . $total . ")";

            if (mysqli_query($mysqli, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Intensidad horaria guardada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . mysqli_error($mysqli)]);
            }
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

mysqli_close($mysqli);
?>