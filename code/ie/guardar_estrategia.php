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

        $cod_dane_sede = $_POST['cod_dane_sede'];
        $aliado = $_POST['aliado'] ?? '';
        $eje = $_POST['eje'] ?? '';
        $dias = intval($_POST['dias'] ?? 0);
        $horas = intval($_POST['horas'] ?? 0);
        $jornada = $_POST['jornada'] ?? '';
        $cantidad = $_POST['cantidad'] ?? [];

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
        }        // Verificar si ya existe registro con la combinación cod_dane_sede + aliado
        $sqlCheckRecord = "SELECT id FROM estrategia_ju WHERE cod_dane_sede = ? AND aliado = ?";
        $stmtCheck = $mysqli->prepare($sqlCheckRecord);
        $stmtCheck->bind_param("ss", $cod_dane_sede, $aliado);
        $stmtCheck->execute();
        $resultCheckRecord = $stmtCheck->get_result();

        if ($resultCheckRecord->num_rows > 0) {
            // Ya existe, actualizamos
            $setFields = implode(" = ?, ", $campos) . " = ?";
              $sql = "UPDATE estrategia_ju SET eje = ?, dias = ?, horas = ?, jornada = ?, $setFields, total_estudiantes = ? WHERE cod_dane_sede = ? AND aliado = ?";
            
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo json_encode(['success' => false, 'message' => 'Error preparando consulta UPDATE: ' . $mysqli->error]);
                exit;
            }
            
            // Crear array de parámetros (sin aliado porque ya está en WHERE)
            $params = [$eje, $dias, $horas, $jornada];
            $params = array_merge($params, $valores);
            $params[] = $total_estudiantes;
            $params[] = $cod_dane_sede;
            $params[] = $aliado;
            
            // Crear string de tipos
            $types = 'siis' . str_repeat('i', count($valores)) . 'iss';
            
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
            
            $sql = "INSERT INTO estrategia_ju (cod_dane_sede, aliado, eje, dias, horas, jornada, $camposSql, total_estudiantes) VALUES (?, ?, ?, ?, ?, ?, $placeholders, ?)";
            
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo json_encode(['success' => false, 'message' => 'Error preparando consulta INSERT: ' . $mysqli->error]);
                exit;
            }
            
            // Crear array de parámetros
            $params = [$cod_dane_sede, $aliado, $eje, $dias, $horas, $jornada];
            $params = array_merge($params, $valores);
            $params[] = $total_estudiantes;
            
            // Crear string de tipos
            $types = 'sssiis' . str_repeat('i', count($valores)) . 'i';
            
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
