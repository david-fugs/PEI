<?php
include '../../conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar que los datos estén presentes
        if (!isset($_POST['cod_dane_sede']) || empty($_POST['cod_dane_sede'])) {
            echo json_encode(['success' => false, 'message' => 'Código DANE de sede es requerido']);
            exit;
        }

        if (!isset($_POST['aliado']) || empty($_POST['aliado'])) {
            echo json_encode(['success' => false, 'message' => 'Aliado responsable es requerido']);
            exit;
        }

        if (!isset($_POST['eje']) || empty($_POST['eje'])) {
            echo json_encode(['success' => false, 'message' => 'Eje movilizador es requerido']);
            exit;
        }

        $cod_dane_sede = $_POST['cod_dane_sede'];
        $aliado = $_POST['aliado'] ?? '';
        $eje = $_POST['eje'] ?? '';
        $especificar_aliado = $_POST['especificar_aliado'] ?? '';
        $dias = intval($_POST['dias'] ?? 0);
        $horas = intval($_POST['horas'] ?? 0);
        $jornada = $_POST['jornada'] ?? '';
        $cantidad = $_POST['cantidad'] ?? [];

        // Validar campo especificar_aliado si el aliado es "Entre Otros"
        if ($aliado === 'Entre Otros' && empty($especificar_aliado)) {
            echo json_encode(['success' => false, 'message' => 'Debe especificar el nombre del aliado']);
            exit;
        }

        // Debug
        error_log("Datos recibidos: " . print_r($_POST, true));

        // Mapear grados a columnas
        $grados = [
            'prejardin',
            'jardin',
            'transicion',
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11
        ];

        $campos = [];
        $valores = [];

        $total_estudiantes = 0;

        foreach ($grados as $grado) {
            $columna = 'cantidad_' . strtolower($grado);
            $valor = isset($cantidad[$grado]) ? intval($cantidad[$grado]) : 0;

            $campos[] = $columna;
            $valores[] = $valor;
            $total_estudiantes += $valor;
        }

        // Verificar si la tabla existe
        $sqlCheck = "SHOW TABLES LIKE 'estrategia_ju'";
        $resultCheck = $mysqli->query($sqlCheck);

        if ($resultCheck->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'La tabla estrategia_ju no existe. Contacte al administrador.']);
            exit;
        }        // Verificar si ya existe registro con la combinación cod_dane_sede + aliado + eje + especificar_aliado
        if ($aliado === 'Entre Otros' && !empty($especificar_aliado)) {
            $sqlCheckRecord = "SELECT id FROM estrategia_ju WHERE cod_dane_sede = ? AND aliado = ? AND eje = ? AND especificar_aliado = ?";
            $stmtCheck = $mysqli->prepare($sqlCheckRecord);
            $stmtCheck->bind_param("ssss", $cod_dane_sede, $aliado, $eje, $especificar_aliado);
        } else {
            $sqlCheckRecord = "SELECT id FROM estrategia_ju WHERE cod_dane_sede = ? AND aliado = ? AND eje = ?";
            $stmtCheck = $mysqli->prepare($sqlCheckRecord);
            $stmtCheck->bind_param("sss", $cod_dane_sede, $aliado, $eje);
        }
        $stmtCheck->execute();
        $resultCheckRecord = $stmtCheck->get_result();

        if ($resultCheckRecord->num_rows > 0) {
            // Ya existe, actualizamos
            $setFields = implode(" = ?, ", $campos) . " = ?";
            
            if ($aliado === 'Entre Otros' && !empty($especificar_aliado)) {
                $sql = "UPDATE estrategia_ju SET dias = ?, horas = ?, jornada = ?, especificar_aliado = ?, $setFields, total_estudiantes = ? WHERE cod_dane_sede = ? AND aliado = ? AND eje = ? AND especificar_aliado = ?";
            } else {
                $sql = "UPDATE estrategia_ju SET dias = ?, horas = ?, jornada = ?, especificar_aliado = ?, $setFields, total_estudiantes = ? WHERE cod_dane_sede = ? AND aliado = ? AND eje = ?";
            }
            
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo json_encode(['success' => false, 'message' => 'Error preparando consulta UPDATE: ' . $mysqli->error]);
                exit;
            }
            
            // Crear array de parámetros
            $params = [$dias, $horas, $jornada, $especificar_aliado];
            $params = array_merge($params, $valores);
            $params[] = $total_estudiantes;
            $params[] = $cod_dane_sede;
            $params[] = $aliado;
            $params[] = $eje;
            
            // Si es "Entre Otros", agregar especificar_aliado al WHERE
            if ($aliado === 'Entre Otros' && !empty($especificar_aliado)) {
                $params[] = $especificar_aliado;
                $types = 'iiss' . str_repeat('i', count($valores)) . 'issss';
            } else {
                $types = 'iiss' . str_repeat('i', count($valores)) . 'isss';
            }
            
            $stmt->bind_param($types, ...$params);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Estrategia actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $stmt->error]);
            }
        } else {
            // No existe, insertamos
            $placeholders = str_repeat('?,', count($campos));
            $placeholders = rtrim($placeholders, ',');
            
            $camposSql = implode(", ", $campos);
            
            $sql = "INSERT INTO estrategia_ju (cod_dane_sede, aliado, eje, especificar_aliado, dias, horas, jornada, $camposSql, total_estudiantes) VALUES (?, ?, ?, ?, ?, ?, ?, $placeholders, ?)";
            
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo json_encode(['success' => false, 'message' => 'Error preparando consulta INSERT: ' . $mysqli->error]);
                exit;
            }
            
            // Crear array de parámetros
            $params = [$cod_dane_sede, $aliado, $eje, $especificar_aliado, $dias, $horas, $jornada];
            $params = array_merge($params, $valores);
            $params[] = $total_estudiantes;
            
            // Crear string de tipos
            $types = 'ssssiis' . str_repeat('i', count($valores)) . 'i';
            
            $stmt->bind_param($types, ...$params);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Estrategia guardada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $stmt->error]);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
