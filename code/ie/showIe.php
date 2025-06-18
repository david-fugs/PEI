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
                                    Preescolar
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
    <!-- boton de agregar sede a la derecha que abra modal -->
    <div class="d-flex justify-content-end p-3">
        <button type="button" class="mr-3 btn btn-success btn-lg d-flex align-items-center gap-2 rounded-pill shadow"
            data-bs-toggle="modal" data-bs-target="#modalAgregarSede">
            <span>Agregar Sede</span>
        </button>
    </div>
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
                    <th>ESTRATEGIA J.U</th>
                    <th>OPCIONES</th>

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
                <td data-label="ESTRATEGIA J.U">
                    <button class="btn btn-success btn-sm" onclick="abrirModalEstrategia(\'' . $row['cod_dane_sede'] . '\')">
                        <i class="fas fa-edit"></i> 
                    </button>
                </td>
            <td data-label="OPCIONES">
                <button style="border: none; background: none;"
                    class="btn-editar-sede" 
                    data-cod="' . $row['cod_dane_sede'] . '" 
                    data-nombre="'. $row['nombre_sede'] . '" 
                    data-zona="' . htmlspecialchars($row['zona_sede']) . '"
                >
                    <img src="../../img/editar.png" width="27" height="25">
                </button>
                <a href="eliminar_sede.php?cod_dane_sede=' . $row['cod_dane_sede'] . '" class="d-inline-block" onclick="return confirm(\'¿Estás seguro de eliminar esta sede?\')">
                    <img src="../../img/trash.png" width="25" height="25">
                </a>
            </td>
            </tr>';
    }

    echo '</tbody>
        </table>
            </div>';
    ?>
    <!-- Modal Agregar Sede -->
    <div class="modal fade" id="modalAgregarSede" tabindex="-1" aria-labelledby="modalAgregarSedeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="procesar_sede.php" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarSedeLabel">Agregar Sede</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_cole" value="<?= $id_cole ?>">

                    <div class="mb-3">
                        <label for="codigo_dane" class="form-label">Código DANE Sede</label>
                        <input type="text" class="form-control" id="codigo_dane" name="codigo_dane" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_sede" class="form-label">Nombre de la Sede</label>
                        <input type="text" class="form-control" id="nombre_sede" name="nombre_sede" required>
                    </div>

                    <div class="mb-3">
                        <label for="zona" class="form-label">Zona</label>
                        <select class="form-select" id="zona" name="zona" required>
                            <option value="">Seleccione...</option>
                            <option value="RURAL">Rural</option>
                            <option value="URBANO">Urbano</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Guardar Sede</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal edicion sede -->
    <div class="modal fade" id="modalEditarSede" tabindex="-1" aria-labelledby="modalEditarSedeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditarSede">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarSedeLabel">Editar Sede</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                         <label for="nombre_sede" class="form-label">Codigo Dane</label>
                        <input type="number" class="form-control" name="cod_dane_sede" id="cod_dane_sede">
                        <input type="hidden" class="form-control" name="cod_dane_sede_old" id="cod_dane_sede1">

                        <div class="mb-3 mt-3">
                            <label for="nombre_sede" class="form-label">Nombre de la Sede</label>
                            <input type="text" class="form-control" name="nombre_sede" id="nombre_sede1" >
                        </div>

                        <div class="mb-3">
                            <label for="zona_sede" class="form-label">Zona</label>
                            <select class="form-control" name="zona_sede" id="zona_sede">
                                <option value="">Seleccione...</option>
                                <option value="URBANO">URBANO</option>
                                <option value="RURAL">RURAL</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Estrategia JU -->
    <div class="modal fade" id="estrategiaModal" tabindex="-1" aria-labelledby="estrategiaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="guardar_estrategia.php" id="formEstrategia" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="estrategiaModalLabel">Registrar Estrategia J.U</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>                    <div class="modal-body">
                        <input type="hidden" name="cod_dane_sede" id="cod_dane_sede_estrategia">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="aliado">Aliado responsable</label>
                                <select name="aliado" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option>COMFAMILIAR</option>
                                    <option>CRESE</option>
                                    <option>ONDAS</option>
                                    <option>ICBF</option>
                                    <option>Ministerios</option>
                                    <option>Alcaldias</option>
                                    <option>Chef_Fundeca</option>
                                    <option>Entre Otros</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="eje">Eje Movilizador</label>
                                <select name="eje" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option>Recreacion y deporte</option>
                                    <option>Educacion artistica y cultural</option>
                                    <option>Ciencia y tecnologia</option>
                                    <option>Articulacion de la media</option>
                                    <option>Centro de interes</option>
                                    <option>Otros</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dias">Número de días (semanal)</label>
                                <input type="number" class="form-control" name="dias">
                            </div>
                            <div class="col-md-6">
                                <label for="horas">Número de horas (semanal)</label>
                                <input type="number" class="form-control" name="horas">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jornada">Tipo de jornada</label>
                            <select name="jornada" class="form-control">
                                <option value="">Seleccione</option>
                                <option>Regular</option>
                                <option>Extra Curricular</option>
                            </select>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-center text-primary fw-bold">Grados</h5>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                            $grados = ['Prejardin', 'Jardin', 'Transicion'];
                            for ($i = 1; $i <= 11; $i++) {
                                $grados[] = $i;
                            }
                            foreach ($grados as $grado) {
                                echo '
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <label class="form-label fw-semibold text-primary">' . $grado . '</label>
                                    <input type="number" class="form-control form-control-lg cantidad" 
                                        name="cantidad[' . strtolower($grado) . ']" value="0" min="0" style="font-size: 1.1rem;">
                                </div>';
                            }
                            ?>
                        </div>

                        <div class="mt-3">
                            <label><strong>Total Estudiantes:</strong></label>
                            <span id="totalEstudiantes">0</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <center>
        <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

    <script>
        //modal para editar sede
        document.querySelectorAll('.btn-editar-sede').forEach(btn => {
            btn.addEventListener('click', function() {
                const cod = this.dataset.cod;
                const nombre = this.dataset.nombre;
                const zona = this.dataset.zona;
                console.log(nombre);

                document.getElementById('cod_dane_sede').value = cod;
                document.getElementById('cod_dane_sede1').value = cod;
                document.getElementById('nombre_sede1').value = nombre;
                document.getElementById('zona_sede').value = zona;

                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('modalEditarSede'));
                modal.show();
            });
        });
        //edicion sede
        document.getElementById('formEditarSede').addEventListener('submit', function(e) {
            e.preventDefault();

            const datos = new FormData(this);

            fetch('editarSede.php', {
                    method: 'POST',
                    body: datos
                })
                .then(res => res.text())
                .then(respuesta => {
                    alert('Cambios guardados correctamente');
                    location.reload(); // Recarga la página para ver los cambios
                })
                .catch(err => {
                    console.error(err);
                    alert('Error al guardar los cambios');
                });
        });        const estrategiaModal = document.getElementById('estrategiaModal');        estrategiaModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            if (button) {
                const codDane = button.getAttribute('data-cod-dane-sede');
                if (codDane) {
                    document.getElementById('cod_dane_sede_estrategia').value = codDane;
                }
            }
        });

        // Event listener para cuando cambie el aliado
        document.addEventListener('change', function(event) {
            if (event.target && event.target.name === 'aliado') {
                cargarDatosPorAliado();
            }
        });// Sumar totales en tiempo real
        document.querySelectorAll('.cantidad').forEach(input => {
            input.addEventListener('input', calcularTotal);
        });        // Calcular total inicial
        calcularTotal();

        function abrirModalEstrategia(codDane) {
            console.log('Abriendo modal para sede:', codDane);
            
            const form = document.getElementById('formEstrategia');
            form.reset();
            document.getElementById('cod_dane_sede_estrategia').value = codDane;

            // Abrir el modal directamente sin cargar datos previos
            const modal = new bootstrap.Modal(document.getElementById('estrategiaModal'));
            modal.show();
        }

        // Función para cargar datos según aliado seleccionado
        function cargarDatosPorAliado() {
            const codDane = document.getElementById('cod_dane_sede_estrategia').value;
            const aliado = document.querySelector('[name="aliado"]').value;
            
            if (!codDane || !aliado) {
                return;
            }

            fetch(`obtener_estrategia.php?cod_dane_sede=${codDane}&aliado=${encodeURIComponent(aliado)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Datos encontrados:', data);
                    const form = document.getElementById('formEstrategia');
                    
                    if (data && Object.keys(data).length > 0) {
                        // Rellenar campos (excepto aliado que ya está seleccionado)
                        form.querySelector('[name="eje"]').value = data.eje || '';
                        form.querySelector('[name="dias"]').value = data.dias || '';
                        form.querySelector('[name="horas"]').value = data.horas || '';
                        form.querySelector('[name="jornada"]').value = data.jornada || '';

                        // Rellenar cantidades por grado
                        const grados = ['prejardin', 'jardin', 'transicion', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
                        grados.forEach(grado => {
                            const nombreCampo = `cantidad[${grado}]`;
                            const input = form.querySelector(`input[name="${nombreCampo}"]`);
                            const clave = 'cantidad_' + grado.toString().toLowerCase();
                            if (input && data.hasOwnProperty(clave)) {
                                input.value = data[clave];
                            }
                        });

                        // Actualizar total estudiantes
                        calcularTotal();
                    } else {
                        // No hay datos, limpiar campos (excepto aliado)
                        form.querySelector('[name="eje"]').value = '';
                        form.querySelector('[name="dias"]').value = '';
                        form.querySelector('[name="horas"]').value = '';
                        form.querySelector('[name="jornada"]').value = '';
                        
                        // Limpiar cantidades
                        const grados = ['prejardin', 'jardin', 'transicion', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
                        grados.forEach(grado => {
                            const nombreCampo = `cantidad[${grado}]`;
                            const input = form.querySelector(`input[name="${nombreCampo}"]`);
                            if (input) {
                                input.value = 0;
                            }
                        });
                        
                        calcularTotal();
                    }
                })
                .catch(error => {
                    console.error('Error al obtener datos:', error);
                });
        }

        function calcularTotal() {
            let total = 0;
            document.querySelectorAll('.cantidad').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('totalEstudiantes').textContent = total;
        }// Manejar el envío del formulario de estrategia
        document.getElementById('formEstrategia').addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Formulario enviado');
              // Validar que cod_dane_sede esté presente
            const codDaneSede = document.getElementById('cod_dane_sede_estrategia').value;
            console.log('Código DANE sede:', codDaneSede);
            
            if (!codDaneSede) {
                alert('Error: No se pudo identificar la sede. Por favor, cierre el modal e intente nuevamente.');
                return;
            }

            // Validar que aliado esté seleccionado
            const aliado = document.querySelector('[name="aliado"]').value;
            if (!aliado) {
                alert('Por favor, seleccione un aliado responsable.');
                return;
            }
            
            const formData = new FormData(this);
            
            // Debug: mostrar datos del formulario
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            // Mostrar loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Guardando...';
            submitBtn.disabled = true;
            
            fetch('guardar_estrategia.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Respuesta recibida:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Datos de respuesta:', data);
                if (data.success) {
                    alert(data.message);
                    
                    // Cerrar el modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('estrategiaModal'));
                    modal.hide();
                    
                    // Recargar la página para ver los cambios
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar la estrategia');
            })
            .finally(() => {
                // Restaurar botón
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>

</body>

</html>