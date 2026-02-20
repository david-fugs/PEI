<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

$id_cole = $_SESSION['id_cole'];

// Configurar headers para Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="intensidad_horaria_' . date('Y-m-d_H-i-s') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Obtener información del colegio
$sql_colegio = "SELECT * FROM colegios WHERE id_cole = $id_cole";
$result_colegio = mysqli_query($mysqli, $sql_colegio);
$colegio = mysqli_fetch_assoc($result_colegio);

// Obtener datos de intensidad horaria
$nit = mysqli_real_escape_string($mysqli, $colegio['nit_cole']);
$sql_intensidad = "SELECT ihs.* FROM intensidad_horaria_semanal ihs WHERE ihs.nit_establecimiento = '$nit' ORDER BY ihs.area, ihs.asignatura";
$result_intensidad = mysqli_query($mysqli, $sql_intensidad);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Intensidad Horaria Semanal</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #cccccc; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>INTENSIDAD HORARIA SEMANAL POR ÁREAS Y ASIGNATURAS POR GRADOS</h2>
        <h3><?php echo htmlspecialchars($colegio['nombre_cole']); ?></h3>
    </div>

    <div class="info">
        <strong>DANE:</strong> <?php echo htmlspecialchars($colegio['cod_dane_cole']); ?><br>
        <strong>NIT:</strong> <?php echo htmlspecialchars($colegio['nit_cole']); ?><br>
        <strong>Fecha de generación:</strong> <?php echo date('d/m/Y H:i:s'); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" >INSTITUCION</th>
                <th rowspan="2">ÁREA</th>
                <th rowspan="2">ASIGNATURA</th>
                <th colspan="11">GRADOS</th>
                <th rowspan="2">TOTAL HORAS</th>
            </tr>
            <tr>
                <?php for ($i = 1; $i <= 11; $i++): ?>
                    <th><?php echo $i; ?>°</th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sede_actual = '';
            $total_general = 0;
            $totales_por_grado = array_fill(1, 11, 0);
            
            if (mysqli_num_rows($result_intensidad) > 0):
                while ($row = mysqli_fetch_assoc($result_intensidad)): 
                    $total_general += $row['total_horas'];
                    
                    // Sumar totales por grado
                    for ($i = 1; $i <= 11; $i++) {
                        $totales_por_grado[$i] += $row["grado_$i"];
                    }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombre_sede']); ?></td>
                    <td><?php echo htmlspecialchars($row['area']); ?></td>
                    <td><?php echo htmlspecialchars($row['asignatura']); ?></td>
                    <?php for ($i = 1; $i <= 11; $i++): ?>
                        <td><?php echo $row["grado_$i"]; ?></td>
                    <?php endfor; ?>
                    <td><strong><?php echo $row['total_horas']; ?></strong></td>
                </tr>
            <?php 
                endwhile;
            else: 
            ?>
                <tr>
                    <td colspan="15">No hay datos de intensidad horaria registrados</td>
                </tr>
            <?php endif; ?>
            
            <!-- Fila de totales -->
            <?php if (mysqli_num_rows($result_intensidad) > 0): ?>
                <tr style="background-color: #ffff99; font-weight: bold;">
                    <td colspan="3">TOTALES</td>
                    <?php for ($i = 1; $i <= 11; $i++): ?>
                        <td><?php echo $totales_por_grado[$i]; ?></td>
                    <?php endfor; ?>
                    <td><?php echo $total_general; ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br><br>
    <div class="info">
        <strong>Resumen:</strong><br>
        Total de registros: <?php echo mysqli_num_rows($result_intensidad); ?><br>
        Total de horas semanales: <?php echo $total_general; ?><br>
        Generado por: <?php echo $_SESSION['nombre']; ?>
    </div>
</body>
</html>

<?php
mysqli_close($mysqli);
?>