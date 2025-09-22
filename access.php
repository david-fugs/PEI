<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}

$usuario = $_SESSION['usuario'];
$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usuario'];
$id_cole = $_SESSION['id_cole'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <title>PEI | SOFT</title>
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/access.css" />
</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="logo_item">
            <i class="bx bx-menu" id="sidebarOpen"></i>
            <img src="img/logo_educacion_fondo_azul.png" alt=""></i>PEI | SOFT
        </div>
        <div class="navbar_content">
            <i class="bi bi-grid"></i>
            <i class="fa-solid fa-sun" id="darkLight"></i><!--<i class='bx bx-sun' id="darkLight"></i>-->
            <a href="logout.php"> <i class="fa-solid fa-door-open"></i></a>
            <img src="img/logo_educacion_fondo_azul.png" alt="" class="profile" />
        </div>
    </nav>
    <?php if ($tipo_usu == 1) { ?>
        <!-- sidebar -->
        <nav class="sidebar">
            <div class="menu_content">
                <ul class="menu_items">
                    <div class="menu_title menu_dahsboard"></div>
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-school-flag"></i>
                            </span>
                            <span class="navlink">USUARIOS</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="./code/usuarios/adduser.php" class="nav_link sublink">Ver Usuarios</a>
                        </ul>
                    </li>
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-bell"></i>
                            </span>
                            <span class="navlink">SEGUMIENTO PEI</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="./code/general/generalReport.php" class="nav_link sublink">Ver Seguimiento PEI</a>
                        </ul>
                    </li>
                     <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-bell"></i>
                            </span>
                            <span class="navlink">SEGUMIENTO INSTITUCIONES</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="./code/ie/showIeAdmin.php" class="nav_link sublink">Ver Seguimiento Instituciones</a>
                        </ul>
                    </li>
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-person-chalkboard"></i>
                            </span>
                            <span class="navlink">PROYECTOS PEDAGÓGICOS</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="./code/proyect_transv/management/admin/colleges.php" class="nav_link sublink">Ver Proyectos</a>
                        </ul>
                        <ul class="menu_items submenu">
                            <a href="./code/proyect_transv/management/admin/supervisor/supervisor.php" class="nav_link sublink">Seguimiento Proyectos</a>
                        </ul>
                    </li>

                    <hr style="border: 1px solid #F3840D; border-radius: 5px;">
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </span>
                            <span class="navlink">Mi Cuenta</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>

                        <ul class="menu_items submenu">
                            <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
                        </ul>
                    </li>
                    <!-- Sidebar Open / Close -->
                    <div class="bottom_content">
                        <div class="bottom expand_sidebar">
                            <span> Expand</span>
                            <i class='bx bx-log-in'></i>
                        </div>
                        <div class="bottom collapse_sidebar">
                            <span> Collapse</span>
                            <i class='bx bx-log-out'></i>
                        </div>
                    </div>
            </div>
        </nav>
    <?php } ?>
    <!--************************MENÚ ENCUESTAS DE CAMPO************************-->
    <?php if ($tipo_usu == 2 || $tipo_usu == 3) { ?>
        <!-- sidebar -->
        <nav class="sidebar">
            <div class="menu_content">
                <ul class="menu_items">
                    <div class="menu_title menu_dahsboard"></div>
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-school-flag"></i>
                            </span>
                            <span class="navlink">ESTABLECIMIENTO EDUCATIVO</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="code/ie/showIe.php" class="nav_link sublink">Ver Institucion Educativa</a>
                        </ul>
                    </li>
                    <!-- <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-thumbs-up"></i>
                            </span>
                            <span class="navlink">MEJORAS INSTITUCION</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="code/ie/mejoras/addmejorasedit.php" class="nav_link sublink">Consultar mejoras</a>
                        </ul>
                    </li> -->
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-comment"></i>
                            </span>
                            <span class="navlink">ANOTACIONES</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="code/anotaciones/addanotaciones.php" class="nav_link sublink">Consultar Anotaciones</a>
                        </ul>
                    </li>
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-note-sticky"></i>
                            </span>
                            <span class="navlink">OBSERVACIONES</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="code/anotaciones/addobservaciones.php" class="nav_link sublink">Consultar Observaciones</a>
                        </ul>
                    </li>
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-hand"></i>
                            </span>
                            <span class="navlink">SOLICITUDES</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
                            <a href="code/anotaciones/addsolicitudes.php" class="nav_link sublink">Consultar Solicitudes</a>
                        </ul>
                    </li>
                    <hr style="border: 1px solid #F3840D; border-radius: 5px;">
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </span>
                            <span class="navlink">Mi Cuenta</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>

                        <ul class="menu_items submenu">
                            <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
                        </ul>
                    </li>
                    <?php if ($tipo_usu == 2  || $tipo_usu == 1) : ?>
                        <li class="item">
                            <div href="#" class="nav_link submenu_item">
                                <span class="navlink_icon">
                                    <i class="fa-solid fa-address-book"></i>
                                </span>
                                <span class="navlink">Asignar Roles</span>
                                <i class="bx bx-chevron-right arrow-left"></i>
                            </div>

                            <ul class="menu_items submenu">
                                <a href="assignRol.php" class="nav_link sublink">Asignar Roles</a>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <!-- Sidebar Open / Close -->
                    <div class="bottom_content">
                        <div class="bottom expand_sidebar">
                            <span> Expand</span>
                            <i class='bx bx-log-in'></i>
                        </div>
                        <div class="bottom collapse_sidebar">
                            <span> Collapse</span>
                            <i class='bx bx-log-out'></i>
                        </div>
                    </div>
            </div>
        </nav>
    <?php } ?>
    <!-- JavaScript -->
    <script src="js/access.js"></script>
</body>

</html>