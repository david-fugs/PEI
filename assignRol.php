<?php include('code/ie/layouts/head.php'); ?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<style>
    /* Estilos generales del modal */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Asegurar que el modal no sea demasiado pequeño */
    .modal-dialog {
        max-width: 500px;
    }

    /* Estilos para el título del modal */
    .modal-header {
        background-color: rgb(28, 40, 54);
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    /* Botón de cerrar del modal */
    .modal-header .btn-close {
        filter: invert(1);
    }

    /* Estilos para el acordeón */
    .accordion-button {
        background-color: #f8f9fa;
        color: #333;
        font-weight: bold;
        border-radius: 5px !important;
    }

    /* Cambiar color al hacer hover sobre los botones del acordeón */
    .accordion-button:hover {
        background-color: #e2e6ea;
    }

    /* Estilos de los enlaces dentro de los submenús */
    .list-group-item a {
        text-decoration: none;
        color: rgb(0, 1, 2);
        font-weight: 500;
        display: block;
    }

    /* Hover en los enlaces */
    .list-group-item a:hover {
        text-decoration: underline;
        color: rgb(0, 0, 0);
    }

    /* Espaciado entre los elementos del acordeón */
    .accordion-body {
        padding: 10px;
    }

    /* Bordes redondeados en los acordeones */
    .accordion-item {
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    /* Estilos de los enlaces dentro de los submenús */
    .list-group-item a {
        text-decoration: none !important;
        /* Elimina la línea de hipervínculo */
        color: rgb(0, 0, 0);
        /* Color azul de Bootstrap */
        font-weight: 500;
        display: block;
        padding: 8px 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    /* Cambiar color de fondo al pasar el cursor */
    .list-group-item a:hover {
        background-color: #e2e6ea;
        color: #0056b3;
        text-decoration: none !important;
    }
</style>

<body>
    <div class="container p-3">
        <div class="d-flex align-items-center flex-column justify-content-center align-content-center ">


            <img src='img/logo_educacion_fondo_azul.png' width="600" height="212" class="responsive">

            <br /><a href="access.php"><img src='img/atras.png' width="72" height="72" title="Regresar" /></a><br>
        </div>
        <h1 style="margin-bottom: 35px; color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-file-signature "></i> ASIGNAR ROLES INSTITUCION</b></h1>
        <?php
        date_default_timezone_set("America/Bogota");
        include("conexion.php");
        require_once("zebra.php");

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
        <td data-label="nit">' . $row['nit_cole'] . '</td>
        <td data-label="establecimiento" style="text-transform:uppercase;">' . $row['nombre_cole'] . '</td>
        <td data-label="rector" style="text-transform:uppercase;">' . $row['nombre_rector_cole'] . '</td>
        <td data-label="resolucion" style="text-transform:uppercase;">' . $row['num_act_adm_cole'] . '</td>
        </tr>';
            $i++;
        }
        echo '</table>
</div>';
        ?>
        <h1 style="margin-top: 35px;margin-bottom: 35px; margin-bottom: 35px; color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-file-signature"></i> ASIGNAR ROLES</b></h1>
        <?php
        // Inicializa consulta SEDES
        date_default_timezone_set("America/Bogota");

        $query = "SELECT * FROM usuarios WHERE id_cole = $id_cole ORDER BY tipo_usuario ASC";
        $res = $mysqli->query($query);

        echo "<div class='container'>
        <table class='table'>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NOMBRE</th>
                    <th>ROL</th>
                </tr>
              </thead>
        <tbody>";
        $result = $mysqli->query($query);
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo '
            <tr>
                <td data-label="No.">' . $i++ . '</td>
                <td data-label="nombre">' . $row['nombre'] . '</td>
                <td data-label="rol">
                    <select class="form-control" onchange="actualizarRol(this, ' . $row['id'] . ')">
                        <option value="2" ' . ($row['tipo_usuario'] == 2 ? 'selected' : '') . '>Rector</option>
                        <option value="3" ' . ($row['tipo_usuario'] == 3 ? 'selected' : '') . '>Implementador Encuestas</option>
                    </select>
                </td>
            </tr>';
        }

        echo '</tbody>
        </table>
            </div>';
        ?>
    </div>

    <center>
        <br /><a href="access.php"><img src='img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>
    <script>
        function actualizarRol(select, idUsuario) {
            var nuevoRol = select.value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "actualizar_rol.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Rol actualizado correctamente.");
                }
            };

            xhr.send("id_usuario=" + idUsuario + "&tipo_usuario=" + nuevoRol);
        }
    </script>
</body>

</html>