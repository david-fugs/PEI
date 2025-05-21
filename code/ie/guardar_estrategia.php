<?php
include '../../conexion.php'; // Ajusta esto a tu ruta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    print_r($_POST);
    $cod_dane_sede = $_POST['cod_dane_sede'];
    $aliado = $_POST['aliado'];
    $eje = $_POST['eje'];
    $dias = $_POST['dias'];
    $horas = $_POST['horas'];
    $jornada = $_POST['jornada'];
    $cantidad = $_POST['cantidad'];

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
    $placeholders = [];

    $total_estudiantes = 0;

    foreach ($grados as $grado) {
        $columna = 'cantidad_' . strtolower($grado);
        $valor = isset($cantidad[$grado]) ? (int)$cantidad[$grado] : 0;

        // Depuración: Mostrar el valor que se está obteniendo
        echo "Clave: $grado => Valor: $valor<br>";

        $campos[] = $columna;
        $valores[] = $valor;
        $total_estudiantes += $valor;
    }

    // Verificar si ya existe registro
    $sqlCheck = "SELECT id FROM estrategia_ju WHERE cod_dane_sede = '$cod_dane_sede'";
    $resultCheck = $mysqli->query($sqlCheck);

    if (!$resultCheck) {
        die("Error en la consulta SELECT: " . $mysqli->error);
    }

    if ($resultCheck->num_rows > 0) {
        // Ya existe, actualizamos
        // Construir la consulta SQL
        $setFields = "";
        foreach ($campos as $index => $campo) {
            $setFields .= "$campo = " . (isset($valores[$index]) ? $valores[$index] : 0) . ", ";
        }
        // Eliminar la última coma
        $setFields = rtrim($setFields, ", ");
        var_dump($setFields);


        $sql = "UPDATE estrategia_ju SET aliado='$aliado', eje='$eje', dias='$dias', horas='$horas', jornada='$jornada', $setFields, total_estudiantes='$total_estudiantes' WHERE cod_dane_sede='$cod_dane_sede'";

        // Debug: Ver la consulta SQL
        echo "SQL QUERY (UPDATE): " . $sql . "<br>";

        if ($mysqli->query($sql)) {
            header("Location: showIe.php?mensaje=guardado");
            exit;
        } else {
            echo "Error al guardar: " . $mysqli->error;
        }
    } else {
        // No existe, insertamos
        $camposSql = implode(", ", $campos);
        $valoresSql = implode(", ", $valores);

        $sql = "INSERT INTO estrategia_ju (cod_dane_sede, aliado, eje, dias, horas, jornada, $camposSql, total_estudiantes)
    VALUES ('$cod_dane_sede', '$aliado', '$eje', '$dias', '$horas', '$jornada', $valoresSql, '$total_estudiantes')";


        // Debug: Ver la consulta SQL
        echo "SQL QUERY (INSERT): " . $sql . "<br>";

        if ($mysqli->query($sql)) {
            header("Location: showIe.php?mensaje=guardado");
            exit;
        } else {
            echo "Error al guardar: " . $mysqli->error;
        }
    }
}
