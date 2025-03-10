<?php include('layouts/head.php'); ?>

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

    <!-- MODAL MENUS -->
    <div class="modal fade" id="modalMenus" tabindex="-1" aria-labelledby="modalMenusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalMenusLabel">Menús</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="menuAccordion">

                        <!-- Teleológico -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#teleologico">
                                    Teleológico
                                </button>
                            </h2>
                            <div id="teleologico" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                                <div class="accordion-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="../teleologico/addteleologico.php">Ingresar a menu Teologico</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Pedagógico -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pedagogico">
                                    Pedagógico
                                </button>
                            </h2>
                            <div id="pedagogico" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                                <div class="accordion-body">
                                    <!-- Submenú Mallas -->
                                    <div class="accordion" id="subMenuPedagogico">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mallas">
                                                    Mallas
                                                </button>
                                            </h2>
                                            <div id="mallas" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogico">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../mallas/addmallas.php">Ingresar a Mallas</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submenú SIEE -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#siee">
                                                    SIEE
                                                </button>
                                            </h2>
                                            <div id="siee" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogico">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../siee/siee.php">Ingresar a SIEE</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Fin Submenús Pedagógico -->
                                </div>
                            </div>
                        </div>

                        <!-- PLANES PROYECTOS -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#planesproyectos">
                                    Planes Proyectos
                                </button>
                            </h2>
                            <div id="planesproyectos" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                                <div class="accordion-body">
                                    <div class="accordion" id="subMenuplanesproyectos">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#transversales">
                                                    Transversales
                                                </button>
                                            </h2>
                                            <div id="transversales" class="accordion-collapse collapse" data-bs-parent="#subMenuplanesproyectos">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../project/addproject.php">Ingresar Transversales</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submenú Proyecto pedagogigcos-->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proPredagogicos">
                                                    Proyectos Pedagogicos
                                                </button>
                                            </h2>
                                            <div id="proPredagogicos" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogico">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../proyect_transv/management/userViewProject.php">Ingresar a proyectos pedagogicos</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submenú Proyecto pedagogigcos-->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proyectosplanes">
                                                    Proyectos y/o Planes
                                                </button>
                                            </h2>
                                            <div id="proyectosplanes" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogico">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../plans/addplans.php">Ingresar proyectos planes</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- Fin Submenús Pedagógico -->
                                </div>
                            </div>
                        </div>
                        <!-- Transicion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#transicion">
                                    Transicion
                                </button>
                            </h2>
                            <div id="transicion" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                                <div class="accordion-body">
                                    <div class="accordion" id="subMenutransicion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#CapituloEducacionInicial">
                                                    Capitulo Educacion Inicial
                                                </button>
                                            </h2>
                                            <div id="CapituloEducacionInicial" class="accordion-collapse collapse" data-bs-parent="#subMenuplanesproyectos">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../initial/educa/addeduca.php">Ingresar a educacion inicial</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submenú Plan aula-->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#planaula">
                                                    Plan Aula
                                                </button>
                                            </h2>
                                            <div id="planaula" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogico">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../initial/aula/addaula.php">Ingresar Plan aula</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submenú Desarrollo-->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#desarolloIntegral">
                                                    Seguimiento al Desarrollo Integral
                                                </button>
                                            </h2>
                                            <div id="desarolloIntegral" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogico">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../initial/integral/addintegral.php">Ingresar desarrollo integral</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Fin Submenús Pedagógico -->
                                </div>
                            </div>
                        </div>


                    </div> <!-- Fin Accordion -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
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
                            <th>MENUS</th>
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
        	<td data-label="ARCHIVOS"><a href="find_doc.php?nit_cole=' . $row['nit_cole'] . '"><img src="../../img/files.png" width=28 heigth=28></td>
        <td data-label="EDIT"><a href="addieedit.php?cod_dane_cole=' . $row['cod_dane_cole'] . '"><img src="../../img/editar.png" width=27 heigth=25></td>
        <td> <button type="button" class="btn "data-bs-toggle="modal" data-bs-target="#modalMenus">
  <i  style="height:28px;"  class="fa-solid fa-hand-point-up"></i>
</button></td>
        </tr>';
        $i++;
    }
    echo '</table>
</div>';
    ?>
    <h1 style="margin-top: 35px;margin-bottom: 35px; margin-bottom: 35px; color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-file-signature"></i> SEDES</b></h1>
    <?php
    // Inicializa consulta SEDES
    date_default_timezone_set("America/Bogota");
    include("../../conexion.php");

    $query = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
    $res = $mysqli->query($query);

    echo "<div class='container'>
        <table class='table'>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>DANE</th>
                    <th>SEDE</th>
                    <th>ZONA</th>
                    <th>VERIFICAR</th>
                </tr>
              </thead>
        <tbody>";

    $consulta = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
    $result = $mysqli->query($consulta);

    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo '
            <tr>
                <td data-label="No.">' . $i++ . '</td>
                <td data-label="DANE">' . $row['cod_dane_sede'] . '</td>
                <td data-label="SEDE">' . $row['nombre_sede'] . '</td>
                <td data-label="ZONA">' . $row['zona_sede'] . '</td>
                <th data-label="VERIFICAR"><a href="addsedesedit.php?cod_dane_sede=' . $row['cod_dane_sede'] . '"><img src="../../img/check.png" width=25 heigth=25></td>
            </tr>';
    }

    echo '</tbody>
        </table>
            </div>';
    ?>


    <center>
        <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

</body>

</html>