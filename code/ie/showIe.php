<?php include('layouts/head.php'); ?>


<body>

    <center style="margin-top: 20px;">
        <img src='../../img/logo_educacion_fondo_azul.png' width="600" height="212" class="responsive">
    </center>
    <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

    <h1 style="margin-bottom: 35px; color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-file-signature "></i> INSTITUCION EDUCATIVA</b></h1>
    <?php
    date_default_timezone_set("America/Bogota");
    include("../../conexion.php");
    require_once("../../zebra.php");

    // Inicializa la consulta base
    $query = "SELECT * FROM colegios WHERE id_cole=$id_cole";

    // Ejecuta la consulta
    $res = $mysqli->query($query);
    if (!$res) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $num_registros = mysqli_num_rows($res);
    $resul_x_pagina = 500;
    echo "<section class='content'>
        <div class='card-body'>
            <div class='table-responsive'>
                <table style='width:1300px;' >
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>DANE</th>
                            <th>NIT</th>
                            <th>ESTABLECIMIENTO</th>
                            <th>RECTOR</th>
                            <th>RESOLUCION</th>
                            <th>ARCHIVOS</th>
                            <th>EDIT</th>
                        </tr>
                    </thead>
                    <tbody>";

    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);
    // Agrega el LIMIT con paginación
    $query .= " LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";
    // Ejecuta la consulta con paginación
    $result = $mysqli->query($query);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }
    $paginacion->render();
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        // Formatear los valores como moneda
            echo '<tr>
        <td data-label="no.">' . $row['id_cole'] . '</td>
        <td " data-label="DANE">' . $row['cod_dane_cole'] . '</td>
        <td data-label="nit">' .$row['nit_cole'] . '</td>
        <td data-label="establecimiento" style="text-transform:uppercase;">' .$row['nombre_cole'] . '</td>
        <td data-label="rector" style="text-transform:uppercase;">' .$row['nombre_rector_cole'] . '</td>
        <td data-label="resolucion" style="text-transform:uppercase;">' .$row['num_act_adm_cole'] . '</td>
        	<td data-label="ARCHIVOS"><a href="find_doc.php?nit_cole='.$row['nit_cole'].'"><img src="../../img/files.png" width=28 heigth=28></td>
        <td data-label="EDIT"><a href="addieedit.php?cod_dane_cole='.$row['cod_dane_cole'].'"><img src="../../img/editar.png" width=27 heigth=25></td>
        </tr>';
            $i++;
        }
    echo '</table>
</div>';
?>
<h1 style="margin-top: 35px;margin-bottom: 35px; margin-bottom: 35px; color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-file-signature"></i> SEDES</b></h1>
<?php
// Inicializa consulta SEDES
    $query_sedes = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
    // Ejecuta la consulta
    $res = $mysqli->query($query_sedes);
    if (!$res) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $num_registros = mysqli_num_rows($res);
    $resul_x_pagina = 500;
    echo "<section class='content'>
        <div class='card-body'>
            <div class='table-responsive'>
                <table style='width:1300px;' >
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>DANE</th>
                            <th>NIT</th>
                            <th>ESTABLECIMIENTO</th>
                            <th>RECTOR</th>
                            <th>RESOLUCION</th>
                            <th>ARCHIVOS</th>
                            <th>EDIT</th>
                        </tr>
                    </thead>
                    <tbody>";

    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);
    // Agrega el LIMIT con paginación
    $query_sedes .= " LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";
    // Ejecuta la consulta con paginación
    $result = $mysqli->query($query_sedes);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }
    $paginacion->render();
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        // Formatear los valores como moneda
            echo '<tr>
        <td data-label="no.">' . $row['id_cole'] . '</td>
        <td " data-label="DANE">' . $row['cod_dane_cole'] . '</td>
        <td data-label="nit">' .$row['nit_cole'] . '</td>
        <td data-label="establecimiento" style="text-transform:uppercase;">' .$row['nombre_cole'] . '</td>
        <td data-label="rector" style="text-transform:uppercase;">' .$row['nombre_rector_cole'] . '</td>
        <td data-label="resolucion" style="text-transform:uppercase;">' .$row['num_act_adm_cole'] . '</td>
        	<td data-label="ARCHIVOS"><a href="find_doc.php?nit_cole='.$row['nit_cole'].'"><img src="../../img/files.png" width=28 heigth=28></td>
        <td data-label="EDIT"><a href="addieedit.php?cod_dane_cole='.$row['cod_dane_cole'].'"><img src="../../img/editar.png" width=27 heigth=25></td>
        </tr>';
            $i++;
        }
    echo '</table>
</div>';
    ?>


    <center>
        <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

</body>

</html>