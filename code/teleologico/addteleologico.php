<?php
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    header("Content-Type: text/html;charset=utf-8");
    $nombre        = $_SESSION['nombre'];
    $tipo_usuario  = $_SESSION['tipo_usuario'];
    $id_cole       = $_SESSION['id_cole'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-type" text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEI | SOFT</title>
    <script src="js/64d58efce2.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
        .container {
            width: 100%;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .truncate {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 150px;
            display: inline-block;
        }
        .more-text {
            display: none;
            white-space: normal;
        }
        .more-link {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <center>
        <img src="../../img/logo_educacion_fondo_azul.png" width="945" height="175" class="responsive">
    </center>
    <br/>
    <section class="principal">
        <div style="border-radius: 9px; border: 4px solid #FFFFFF; width: 100%;" align="center">
            <div align="center">
                <h1 style="color: #412fd1; font-size: 30px; text-shadow: #FFFFFF 0.1em 0.1em 0.2em"><b><i class="fas fa-chalkboard-teacher"></i> COMPONENTE TELEOLÓGICO </b></h1>
            </div>
            <br />
            <?php
                date_default_timezone_set("America/Bogota");
                include("../../conexion.php");
                
                $query = "SELECT * FROM componente_teleologico INNER JOIN colegios ON componente_teleologico.id_cole=colegios.id_cole WHERE colegios.id_cole=$id_cole";
                $res = $mysqli->query($query);
                
                echo "<div class='container'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>I.E.</th>
                                <th>MISIÓN</th>
                                <th>VISIÓN</th>
                                <th>PERFIL</th>
                                <th>OBJETIVOS</th>
                                <th>ARCHIVOS</th>
                                <th>EDIT</th>
                            </tr>
                        </thead>
                    <tbody>";

                $consulta = "SELECT * FROM componente_teleologico INNER JOIN colegios ON componente_teleologico.id_cole=colegios.id_cole WHERE colegios.id_cole=$id_cole";
                $result = $mysqli->query($consulta);

                $i = 1;
                while($row = mysqli_fetch_array($result)) {
                    echo '
                        <tr>
                            <td data-label="No.">'.$i++.'</td>
                            <td data-label="I.E.">'.$row['nombre_cole'].'</td>
                            <td data-label="MISIÓN"><span class="truncate">'.$row['mision_ct'].'</span><span class="more-text">'.$row['mision_ct'].'</span><span class="more-link">ver más</span></td>
                            <td data-label="VISIÓN"><span class="truncate">'.$row['vision_ct'].'</span><span class="more-text">'.$row['vision_ct'].'</span><span class="more-link">ver más</span></td>
                            <td data-label="PERFIL"><span class="truncate">'.$row['per_egr_ct'].'</span><span class="more-text">'.$row['per_egr_ct'].'</span><span class="more-link">ver más</span></td>
                            <td data-label="OBJETIVOS"><span class="truncate">'.$row['obj_ins_ct'].'</span><span class="more-text">'.$row['obj_ins_ct'].'</span><span class="more-link">ver más</span></td>
                            <td data-label="ARCHIVOS"><a href="find_doc.php?id_cole='.$row['id_cole'].'"><img src="../../img/files.png" width=28 height=28></a></td>
                            <td data-label="EDIT"><a href="addteleologicoedit.php?id_ct='.$row['id_ct'].'"><img src="../../img/editar.png" width=20 height=20></a></td>
                        </tr>';
                }
                echo '</tbody></table></div>';
            ?>
            <center>
                <br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
            </center>
        </div>
    </section>
    <script>
        document.querySelectorAll('.more-link').forEach(link => {
            link.addEventListener('click', function() {
                const truncate = this.previousElementSibling.previousElementSibling;
                const moreText = this.previousElementSibling;
                if (moreText.style.display === 'none') {
                    moreText.style.display = 'block';
                    truncate.style.display = 'none';
                    this.textContent = 'ver menos';
                } else {
                    moreText.style.display = 'none';
                    truncate.style.display = 'inline-block';
                    this.textContent = 'ver más';
                }
            });
        });
    </script>
</body>
</html>
