<?php
// Forzar codificacion UTF-8 desde el inicio
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include('layouts/head.php');
?>

<style>
    /* Variables CSS para colores consistentes */
    :root {
        --primary-color: #1a2332;
        --secondary-color: #2c3e50;
        --accent-color: #3498db;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --light-gray: #f8f9fa;
        --medium-gray: #6c757d;
        --dark-gray: #495057;
        --white: #ffffff;
        --border-radius: 12px;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Reset y estilos base */
    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        color: var(--dark-gray);
        line-height: 1.6;
    }

    /* Contenedor principal */
    .container-fluid {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin: 20px auto;
        padding: 30px;
        max-width: 1400px;
    }

    /* Titulos principales */
    h1,
    .main-title {
        font-weight: 700 !important;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 2rem;
        font-size: 2.5rem;
    }

    /* Estilos modernos para tablas */
    .table {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        border: none;
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--white);
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 18px 15px;
        position: relative;
    }

    .table tbody td {
        border: none;
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
        transition: var(--transition);
    }

    .table tbody tr:hover {
        background-color: var(--light-gray);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Botones modernos */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 24px;
        border: none;
        transition: var(--transition);
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-success,
    .btn-add-sede {
        background: linear-gradient(135deg, var(--success-color), #2ecc71);
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        color: var(--white);
    }

    .btn-success:hover,
    .btn-add-sede:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        color: var(--white);
    }

    .btn-primary,
    .btn-primary-modern {
        background: linear-gradient(135deg, var(--accent-color), #5dade2);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        color: var(--white);
    }

    .btn-primary:hover,
    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        color: var(--white);
    }

    .btn-secondary,
    .btn-secondary-modern {
        background: linear-gradient(135deg, var(--medium-gray), #95a5a6);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        color: var(--white);
    }

    .btn-dark {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
    }

    .btn-action {
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.8rem;
        margin: 2px;
        min-width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Estilos para modales */
    .modal-content {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--white);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        border-bottom: none;
        padding: 20px 30px;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.3rem;
    }

    .modal-body {
        padding: 30px;
        background: var(--white);
    }

    .modal-footer {
        background: var(--light-gray);
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        padding: 20px 30px;
    }

    .btn-close {
        filter: invert(1);
        opacity: 0.8;
        font-size: 1.2rem;
    }

    .btn-close:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Modal más grande para estrategia */
    .modal-xl {
        max-width: 1200px;
    }

    /* Formularios modernos */
    .form-control,
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: var(--transition);
        background-color: var(--white);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
        transform: translateY(-1px);
    }

    .form-label {
        font-weight: 600;
        color: var(--dark-gray);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    /* Secciones del modal de estrategia */
    .section-card {
        background: var(--light-gray);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid var(--accent-color);
        transition: var(--transition);
    }

    .section-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    /* Grid de grados */
    .grado-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .grado-item {
        background: var(--white);
        padding: 15px;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: var(--transition);
        text-align: center;
    }

    .grado-item:hover {
        border-color: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .grado-label {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cantidad-input {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        text-align: center;
        font-weight: 600;
        font-size: 1.1rem;
        transition: var(--transition);
        background-color: var(--white);
        width: 100%;
    }

    .cantidad-input:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
        transform: translateY(-1px);
    }

    /* Total estudiantes */
    .total-estudiantes {
        background: linear-gradient(135deg, var(--accent-color), #5dade2);
        color: var(--white);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin-top: 20px;
    }

    .total-estudiantes .total-label {
        font-size: 0.9rem;
        margin-bottom: 8px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .total-number {
        font-size: 2.5rem;
        font-weight: 800;
        display: block;
    }

    /* Acordeon moderno */
    .accordion-button {
        background: var(--white);
        color: var(--primary-color);
        font-weight: 600;
        border: 2px solid #e9ecef;
        border-radius: 10px !important;
        padding: 15px 20px;
        transition: var(--transition);
    }

    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, var(--accent-color), #5dade2);
        color: var(--white);
        border-color: var(--accent-color);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .accordion-button:hover {
        background-color: var(--light-gray);
        border-color: var(--accent-color);
        transform: translateY(-1px);
    }

    .accordion-item {
        border: none;
        margin-bottom: 10px;
        border-radius: 10px;
        overflow: hidden;
    }

    .accordion-body {
        padding: 20px;
        background: var(--white);
    }

    /* Enlaces del menú */
    .list-group-item {
        border: none;
        margin-bottom: 5px;
        border-radius: 8px;
        background: transparent;
    }

    .list-group-item a {
        text-decoration: none !important;
        color: var(--primary-color);
        font-weight: 500;
        display: block;
        padding: 12px 15px;
        border-radius: 8px;
        transition: var(--transition);
    }

    .list-group-item a:hover {
        background: linear-gradient(135deg, var(--accent-color), #5dade2);
        color: var(--white);
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    /* Iconos de accion */
    .action-icon {
        width: 24px;
        height: 24px;
        transition: var(--transition);
    }

    .action-icon:hover {
        transform: scale(1.1);
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .container-fluid {
            margin: 10px;
            padding: 20px;
        }

        .grado-container {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }

        .modal-xl {
            max-width: 95%;
            margin: 1rem auto;
        }

        .modal-body {
            padding: 20px;
        }

        h1 {
            font-size: 2rem !important;
        }

        .btn {
            padding: 10px 20px;
            font-size: 0.8rem;
        }
    }

    /* Animaciones suaves */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .modal.fade .modal-dialog {
        animation: fadeInUp 0.3s ease-out;
    }

    .table tbody tr {
        animation: slideInRight 0.3s ease-out;
    }

    /* Estilos para sedes suspendidas */
    .table-danger {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .table-danger td {
        border-color: rgba(220, 53, 69, 0.2);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.75em;
    }

    .btn-suspender-sede {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .btn-suspender-sede:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        color: #000;
    }

    .btn-activar-sede {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .btn-activar-sede:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Efectos de hover mejorados */
    .table tbody tr:hover td {
        color: var(--primary-color);
    }

    /* Mejoras en la accesibilidad */
    .btn:focus,
    .form-control:focus,
    .form-select:focus {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    /* Estilos adicionales para inputs con iconos */
    .input-group-text {
        background: var(--light-gray);
        border: 2px solid #e9ecef;
        border-left: none;
        border-radius: 0 10px 10px 0;
        font-weight: 600;
        color: var(--dark-gray);
    }

    .input-group .form-control {
        border-radius: 10px 0 0 10px;
        border-right: none;
    }

    .input-group .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    }

    .input-group .form-control:focus+.input-group-text {
        border-color: var(--accent-color);
    }

    /* Efectos de carga */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid var(--accent-color);
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Mejoras en iconos y emojis */
    .section-title i {
        width: 20px;
        text-align: center;
    }

    /* Estilos para los placeholders */
    .form-control::placeholder,
    .form-select option:first-child {
        color: var(--medium-gray);
        opacity: 0.7;
    }

    /* Hover mejorado para cards */
    .section-card:hover {
        border-left-color: var(--success-color);
    }

    /* Estilos para notificaciones */
    .alert {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }

    /* Mejoras en el header */
    .header-section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 249, 250, 0.9));
        border-radius: var(--border-radius);
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .header-section img {
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    /* Estilos específicos para el campo de especificación */
    #especificarAliadoContainer {
        animation: fadeInDown 0.3s ease-out;
        background: rgba(52, 152, 219, 0.05);
        border-radius: 8px;
        padding: 15px;
        border-left: 3px solid var(--accent-color);
    }

    #especificarAliadoContainer .form-label {
        color: var(--accent-color);
        font-weight: 600;
    }

    #especificar_aliado {
        border-color: var(--accent-color);
        background-color: var(--white);
    }

    #especificar_aliado:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(26, 35, 50, 0.15);
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>
    <?php
    // Forzar codificacion UTF-8
    mb_internal_encoding('UTF-8');
    mb_http_output('UTF-8');
    ?>

    <!-- MODAL MENUS -->
    <div class="modal fade" id="modalMenus" tabindex="-1" aria-labelledby="modalMenusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalMenusLabel">Menus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="menuAccordion">

                        <!-- Teleologico -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#teleologico">
                                    Teleologico
                                </button>
                            </h2>
                            <div id="teleologico" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                                <div class="accordion-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="../teleologico/addteleologico.php">Ingresar a menu Teleologico</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Pedagogico -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pedagogico">
                                    Pedagogico
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
                                    </div> <!-- Fin Submenús Pedagogico -->
                                </div>
                            </div>
                        </div>

                        <!-- PLANES PROYECTOS -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#planesproyectos">
                                    Planes - Programas - Proyectos
                                </button>
                            </h2>
                            <div id="planesproyectos" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                                <div class="accordion-body">
                                    <div class="accordion" id="subMenuplanesproyectos">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#transversales">
                                                    Transversales Obligatorios
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

                                        <!-- Submenú Proyecto pedagogicos-->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proPredagogicos">
                                                    Planes - Programas y Proyectos
                                                </button>
                                            </h2>
                                            <div id="proPredagogicos" class="accordion-collapse collapse" data-bs-parent="#subMenuPedagogico">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><a href="../proyect_transv/management/userViewProject.php">Ingresar a proyectos</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submenú Proyecto pedagogicos-->
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

                                    </div> <!-- Fin Submenús Pedagogico -->
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
                                    </div> <!-- Fin Submenús Pedagogico -->
                                </div>
                            </div>
                        </div>
                        <!-- CONVIVENCIA -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#convivencia">
                                    Convivencia
                                </button>
                            </h2>
                            <div id="convivencia" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                                <div class="accordion-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="../convivencia/manualConvivencia.php">Manual Convivencia</a></li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="../convivencia/convivenciaEscolar.php"> Convivencia Escolar</a></li>
                                    </ul>
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

    <!-- Header moderno -->
    <div class="container-fluid">
        <div class="header-section text-center mb-4">
            <img src='../../img/logo_educacion_fondo_azul.png' width="400" height="142" class="img-fluid mb-3" style="max-width: 100%; height: auto;">

            <div class="d-flex justify-content-start mb-3">
                <a href="../../access.php" class="btn btn-secondary d-flex align-items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Regresar</span>
                </a>
            </div>

            <h1 class="main-title mb-4">
                <i class="fas fa-graduation-cap me-3"></i>
                INSTITUCION EDUCATIVA
            </h1>

            <!-- Botones de acciones modernizados -->
            <div class="d-flex justify-content-end mb-4 gap-3">
                <a href="exportar_estrategia_excel.php?id_cole=<?php echo $id_cole; ?>"
                    class="btn btn-success btn-lg d-flex align-items-center gap-2"
                    title="Exportar Estrategia J.U a Excel"
                    onclick="return exportarEstrategiaExcel(event);">
                    <i class="fas fa-file-excel"></i>
                    <span>Exportar Estrategia J.U</span>
                </a>
                <button type="button" class="btn btn-add-sede btn-lg d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#modalAgregarSede">
                    <i class="fas fa-plus-circle"></i>
                    <span>Agregar Sede</span>
                </button>
            </div>
        </div>
        <?php
        date_default_timezone_set("America/Bogota");
        include("../../conexion.php");
        require_once("../../zebra.php");

        // Configurar charset UTF-8 para la conexion
        mysqli_set_charset($mysqli, 'utf8');

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
        <div class='table-responsive'>
            <table class='table table-striped table-hover'>
                <thead>
                    <tr>
                        <th><i class='fas fa-hashtag me-2'></i>No.</th>
                        <th><i class='fas fa-id-card me-2'></i>DANE</th>
                        <th><i class='fas fa-building me-2'></i>NIT</th>
                        <th><i class='fas fa-school me-2'></i>ESTABLECIMIENTO</th>
                        <th><i class='fas fa-user-tie me-2'></i>RECTOR</th>
                        <th><i class='fas fa-file-contract me-2'></i>RESOLUCION</th>
                        <th><i class='fas fa-folder me-2'></i>ARCHIVOS</th>
                        <th><i class='fas fa-edit me-2'></i>EDITAR</th>
                        <th><i class='fas fa-bars me-2'></i>MENUS</th>
                    </tr>
                </thead>
                <tbody>";

        $paginacion = new Zebra_Pagination();
        $paginacion->records($num_registros);
        $paginacion->records_per_page($resul_x_pagina);
        // Agrega el LIMIT con paginacion
        $query .= " LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";
        // Ejecuta la consulta con paginacion
        $result = $mysqli->query($query);
        if (!$result) {
            die("Error en la consulta: " . $mysqli->error);
        }
        $paginacion->render();
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            // Formatear los valores como moneda
            echo '<tr>
        <td data-label="no." class="fw-bold text-primary">' . $row['id_cole'] . '</td>
        <td data-label="DANE" class="fw-semibold">' . $row['cod_dane_cole'] . '</td>
        <td data-label="nit">' . $row['nit_cole'] . '</td>
        <td data-label="establecimiento" class="text-uppercase fw-semibold">' . $row['nombre_cole'] . '</td>
        <td data-label="rector" class="text-uppercase">' . $row['nombre_rector_cole'] . '</td>
        <td data-label="resolucion" class="text-uppercase">' . $row['num_act_adm_cole'] . '</td>
        <td data-label="ARCHIVOS" class="text-center">
            <a href="find_doc.php?nit_cole=' . $row['nit_cole'] . '" class="btn btn-action btn-primary" title="Ver Archivos">
                <i class="fas fa-folder-open"></i>
            </a>
        </td>
        <td data-label="EDIT" class="text-center">
            <a href="addieedit.php?cod_dane_cole=' . $row['cod_dane_cole'] . '" class="btn btn-action btn-warning" title="Editar">
                <i class="fas fa-edit"></i>
            </a>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-action btn-secondary" data-bs-toggle="modal" data-bs-target="#modalMenus" title="Menus">
                <i class="fas fa-bars"></i>
            </button>
        </td>
        </tr>';
            $i++;
        }
        echo '</tbody></table>
        </div>
    </section>';
        ?>

        <!-- Seccion de Sedes -->
        <div class="mt-5">
            <h1 class="main-title text-center mb-4">
                <i class="fas fa-map-marker-alt me-3"></i>
                SEDES EDUCATIVAS
            </h1>
            <?php
            // Inicializa consulta SEDES
            date_default_timezone_set("America/Bogota");
            include("../../conexion.php");

            // Configurar charset UTF-8 para la conexion
            mysqli_set_charset($mysqli, 'utf8');

            $query = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
            $res = $mysqli->query($query);

            echo "<div class='table-responsive'>
        <table class='table table-striped table-hover'>
            <thead>
                <tr>
                    <th><i class='fas fa-hashtag me-2'></i>No.</th>
                    <th><i class='fas fa-id-card me-2'></i>DANE</th>
                    <th><i class='fas fa-building me-2'></i>SEDE</th>
                    <th><i class='fas fa-map-pin me-2'></i>ZONA</th>
                    <th><i class='fas fa-info-circle me-2'></i>ESTADO</th>
                    <th><i class='fas fa-chess-board me-2'></i>ESTRATEGIA J.U</th>
                    <th><i class='fas fa-cogs me-2'></i>OPCIONES</th>
                </tr>
            </thead>
            <tbody>";

            $consulta = "SELECT * FROM colegios INNER JOIN sedes ON colegios.id_cole=sedes.id_cole WHERE colegios.id_cole=$id_cole ORDER BY sedes.nombre_sede ASC";
            $result = $mysqli->query($consulta);

            $i = 1;
            while ($row = mysqli_fetch_array($result)) {
                // Determinar estado y clase CSS
                $estado = isset($row['estado']) ? $row['estado'] : 'activo';
                $estadoClass = $estado === 'suspendido' ? 'table-danger' : '';
                $estadoBadge = $estado === 'suspendido' ?
                    '<span class="badge bg-danger"><i class="fas fa-pause me-1"></i>Suspendido</span>' :
                    '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Activo</span>';

                echo '
            <tr class="' . $estadoClass . '">
                <td data-label="No." class="fw-bold text-primary">' . $i++ . '</td>
                <td data-label="DANE" class="fw-semibold">' . $row['cod_dane_sede'] . '</td>
                <td data-label="SEDE" class="text-uppercase fw-semibold">' . $row['nombre_sede'] . '</td>
                <td data-label="ZONA">' . $row['zona_sede'] . '</td>
                <td data-label="ESTADO" class="text-center">' . $estadoBadge . '</td>
                <td data-label="ESTRATEGIA J.U" class="text-center">
                    <button class="btn btn-success btn-sm rounded-pill d-flex align-items-center gap-2" onclick="abrirModalEstrategia(\'' . $row['cod_dane_sede'] . '\')" ' . ($estado === 'suspendido' ? 'disabled title="Sede suspendida"' : '') . '>
                        <i class="fas fa-chart-line"></i>
                        <span>Estrategia J.U</span>
                    </button>
                </td>
                <td data-label="OPCIONES" class="text-center">
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-action btn-warning btn-editar-sede" 
                            data-cod="' . $row['cod_dane_sede'] . '" 
                            data-nombre="' . $row['nombre_sede'] . '" 
                            data-zona="' . htmlspecialchars($row['zona_sede']) . '"
                            data-estado="' . $estado . '"
                            title="Editar Sede">
                            <i class="fas fa-edit"></i>
                        </button>';

                // Boton de suspender/activar
                if ($estado === 'activo') {
                    echo '<button class="btn btn-action btn-warning btn-suspender-sede" 
                    data-cod="' . $row['cod_dane_sede'] . '" 
                    title="Suspender Sede">
                    <i class="fas fa-pause"></i>
                </button>';
                } else {
                    echo '<button class="btn btn-action btn-success btn-activar-sede" 
                    data-cod="' . $row['cod_dane_sede'] . '" 
                    title="Activar Sede">
                    <i class="fas fa-play"></i>
                </button>';
                }

                echo '  <a href="eliminar_sede.php?cod_dane_sede=' . $row['cod_dane_sede'] . '" 
                           class="btn btn-action btn-danger" 
                           onclick="return confirm(\'¿Estas seguro de eliminar esta sede?\')"
                           title="Eliminar Sede">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>';
            }

            echo '</tbody>
        </table>
    </div>
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
                                <label for="codigo_dane" class="form-label">Codigo DANE Sede</label>
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
                                <input type="number" class="form-control" name="cod_dane_sede" id="cod_dane_sede" min="0">
                                <input type="hidden" class="form-control" name="cod_dane_sede_old" id="cod_dane_sede1">

                                <div class="mb-3 mt-3">
                                    <label for="nombre_sede" class="form-label">Nombre de la Sede</label>
                                    <input type="text" class="form-control" name="nombre_sede" id="nombre_sede1">
                                </div>

                                <div class="mb-3">
                                    <label for="zona_sede" class="form-label">Zona</label>
                                    <select class="form-control" name="zona_sede" id="zona_sede">
                                        <option value="">Seleccione...</option>
                                        <option value="URBANO">URBANO</option>
                                        <option value="RURAL">RURAL</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="estado_sede" class="form-label">Estado</label>
                                    <select class="form-control" name="estado_sede" id="estado_sede">
                                        <option value="activo">Activo</option>
                                        <option value="suspendido">Suspendido</option>
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

            <!-- Modal Estrategia JU - Diseño Moderno -->
            <div class="modal fade" id="estrategiaModal" tabindex="-1" aria-labelledby="estrategiaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form action="guardar_estrategia.php" id="formEstrategia" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="estrategiaModalLabel">
                                    <i class="fas fa-chess-board me-2"></i>Configurar Estrategia Jornada Unica
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="cod_dane_sede" id="cod_dane_sede_estrategia">

                                <!-- Seccion: Informacion Principal -->
                                <div class="section-card">
                                    <h6 class="section-title">
                                        <i class="fas fa-handshake me-2 text-primary"></i>Alianzas y Responsabilidades
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="aliado" class="form-label">
                                                <i class="fas fa-users me-1"></i>Aliado Responsable
                                            </label>
                                            <select name="aliado" class="form-select" required>
                                                <option value="">── Seleccione un aliado ──</option>
                                                <option value="COMFAMILIAR">🏢 COMFAMILIAR</option>
                                                <option value="CRESE">🎓 CRESE</option>
                                                <option value="ONDAS">🌊 ONDAS</option>
                                                <option value="ICBF">👨‍👩‍👧‍👦 ICBF</option>
                                                <option value="Ministerios">🏛️ Ministerios</option>
                                                <option value="Alcaldias">🏛️ Alcaldias</option>
                                                <option value="Chef_Fundeca">👨‍🍳 Chef Fundeca</option>
                                                <option value="Entre Otros">📋 Entre Otros</option>
                                            </select>

                                            <!-- Campo para especificar "Entre Otros" -->
                                            <div id="especificarAliadoContainer" class="mt-3" style="display: none;">
                                                <label for="especificar_aliado" class="form-label">
                                                    <i class="fas fa-edit me-1"></i>Especifique el aliado
                                                </label>
                                                <input type="text" class="form-control" name="especificar_aliado" id="especificar_aliado"
                                                    placeholder="Ingrese el nombre del aliado especifico">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="eje" class="form-label">
                                                <i class="fas fa-compass me-1"></i>Eje Movilizador
                                            </label>
                                            <select name="eje" class="form-select" required>
                                                <option value="">── Seleccione un eje ──</option>
                                                <option value="Recreacion y deporte">⚽ Recreacion y Deporte</option>
                                                <option value="Educacion artistica y cultural">🎨 Educacion Artistica y Cultural</option>
                                                <option value="Ciencia y tecnologia">🔬 Ciencia y Tecnologia</option>
                                                <option value="Articulacion de la media">🎓 Articulacion de la Media</option>
                                                <option value="Centro de interes">💡 Centro de Interes</option>
                                                <option value="Otros">📚 Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seccion: Configuracion Horaria -->
                                <div class="section-card">
                                    <h6 class="section-title">
                                        <i class="fas fa-calendar-alt me-2 text-warning"></i>Planificacion Horaria
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="dias" class="form-label">
                                                <i class="fas fa-calendar-day me-1"></i>Dias por Semana
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="dias" min="0" max="7" placeholder="Ej: 5">
                                                <span class="input-group-text">dias</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="horas" class="form-label">
                                                <i class="fas fa-clock me-1"></i>Horas por Semana
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="horas" min="0" max="40" placeholder="Ej: 10">
                                                <span class="input-group-text">hrs</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="jornada" class="form-label">
                                                <i class="fas fa-user-clock me-1"></i>Tipo de Jornada
                                            </label>
                                            <select name="jornada" class="form-select">
                                                <option value="">── Seleccione tipo ──</option>
                                                <option value="Regular">🕐 Regular</option>
                                                <option value="Extra Curricular">🕕 Extra Curricular</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seccion: Estudiantes por Grado -->
                                <div class="section-card">
                                    <h6 class="section-title">
                                        <i class="fas fa-user-graduate me-2 text-success"></i>Distribucion de Estudiantes por Grado
                                    </h6>
                                    <p class="text-muted mb-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Indique la cantidad de estudiantes por grado que participarán en esta estrategia.
                                    </p>
                                    <div class="grado-container">
                                        <?php
                                        $grados = ['Prejardin', 'Jardin', 'Transicion'];
                                        for ($i = 1; $i <= 11; $i++) {
                                            $grados[] = $i;
                                        }
                                        foreach ($grados as $grado) {
                                            $icono = is_numeric($grado) ? '📚' : '🎈';
                                            echo '
                                    <div class="grado-item">
                                        <label class="grado-label">' . $icono . ' ' . $grado . '</label>
                                        <input type="number" class="form-control cantidad-input cantidad" 
                                            name="cantidad[' . strtolower($grado) . ']" value="0" min="0" max="999"
                                            placeholder="0">
                                    </div>';
                                        }
                                        ?>
                                    </div>

                                    <!-- Total de Estudiantes -->
                                    <div class="total-estudiantes">
                                        <div class="total-label">
                                            <i class="fas fa-calculator me-2"></i>Total de Estudiantes
                                        </div>
                                        <div class="total-number" id="totalEstudiantes">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar Estrategia
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer moderno -->
            <div class="text-center mt-5 py-4">
                <p class="text-muted mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Sistema de Gestion Educativa - Institucion Educativa
                </p>
            </div>
        </div>

        <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

        <script>
            // Configurar la codificacion de caracteres
            document.charset = 'UTF-8';

            //modal para editar sede
            document.querySelectorAll('.btn-editar-sede').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cod = this.dataset.cod;
                    const nombre = this.dataset.nombre;
                    const zona = this.dataset.zona;
                    const estado = this.dataset.estado || 'activo';
                    console.log(nombre);

                    document.getElementById('cod_dane_sede').value = cod;
                    document.getElementById('cod_dane_sede1').value = cod;
                    document.getElementById('nombre_sede1').value = nombre;
                    document.getElementById('zona_sede').value = zona;
                    document.getElementById('estado_sede').value = estado;

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
            });

            // Manejar suspensión de sede
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-suspender-sede')) {
                    const btn = e.target.closest('.btn-suspender-sede');
                    const codDane = btn.dataset.cod;

                    if (confirm('Esta seguro de suspender esta sede? No podra gestionar estrategias mientras este suspendida.')) {
                        cambiarEstadoSede(codDane, 'suspendido');
                    }
                }

                if (e.target.closest('.btn-activar-sede')) {
                    const btn = e.target.closest('.btn-activar-sede');
                    const codDane = btn.dataset.cod;

                    if (confirm('¿Está seguro de activar esta sede?')) {
                        cambiarEstadoSede(codDane, 'activo');
                    }
                }
            });

            // Función para cambiar estado de sede
            function cambiarEstadoSede(codDane, nuevoEstado) {
                const formData = new FormData();
                formData.append('cod_dane_sede', codDane);
                formData.append('estado', nuevoEstado);

                fetch('cambiar_estado_sede.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cambiar el estado de la sede');
                    });
            }
            const estrategiaModal = document.getElementById('estrategiaModal');
            estrategiaModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (button) {
                    const codDane = button.getAttribute('data-cod-dane-sede');
                    if (codDane) {
                        document.getElementById('cod_dane_sede_estrategia').value = codDane;
                    }
                }
            });

            // Event listener para cuando cambie el aliado o el eje
            document.addEventListener('change', function(event) {
                if (event.target && event.target.name === 'aliado') {
                    // Mostrar/ocultar campo de especificación para "Entre Otros"
                    const especificarContainer = document.getElementById('especificarAliadoContainer');
                    const especificarInput = document.getElementById('especificar_aliado');

                    if (event.target.value === 'Entre Otros') {
                        especificarContainer.style.display = 'block';
                        especificarInput.required = true;
                    } else {
                        especificarContainer.style.display = 'none';
                        especificarInput.required = false;
                        especificarInput.value = '';
                    }

                    cargarDatosPorAliadoYEje();
                } else if (event.target && event.target.name === 'eje') {
                    cargarDatosPorAliadoYEje();
                }
            });

            // Event listener específico para el campo de especificación de aliado
            document.addEventListener('input', function(event) {
                if (event.target && event.target.id === 'especificar_aliado') {
                    // Usar debounce para evitar muchas llamadas mientras el usuario escribe
                    clearTimeout(window.especificarAliadoTimeout);
                    window.especificarAliadoTimeout = setTimeout(() => {
                        const aliado = document.querySelector('[name="aliado"]').value;
                        if (aliado === 'Entre Otros' && event.target.value.length >= 3) {
                            cargarDatosPorAliadoYEje();
                        }
                    }, 500);
                }
            }); // Sumar totales en tiempo real
            document.querySelectorAll('.cantidad').forEach(input => {
                input.addEventListener('input', calcularTotal);
            }); // Calcular total inicial
            calcularTotal();

            function abrirModalEstrategia(codDane) {
                console.log('Abriendo modal para sede:', codDane);

                const form = document.getElementById('formEstrategia');
                form.reset();
                document.getElementById('cod_dane_sede_estrategia').value = codDane;

                // Abrir el modal con animacion suave
                const modal = new bootstrap.Modal(document.getElementById('estrategiaModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();

                // Enfocar el primer select después de que se abra el modal
                setTimeout(() => {
                    form.querySelector('[name="aliado"]').focus();
                }, 500);
            }

            // Funcion para cargar datos según aliado y eje seleccionados
            function cargarDatosPorAliadoYEje() {
                const codDane = document.getElementById('cod_dane_sede_estrategia').value;
                const aliado = document.querySelector('[name="aliado"]').value;
                const eje = document.querySelector('[name="eje"]').value;
                const especificarAliado = document.getElementById('especificar_aliado').value;

                if (!codDane || !aliado || !eje) {
                    // Si no están todos los campos, limpiar los campos dependientes
                    if (codDane && aliado && !eje) {
                        // Solo limpiar campos que dependen del eje
                        limpiarCamposDependientesDelEje();
                    }
                    return;
                }

                // Construir la URL con los parámetros
                let url = `obtener_estrategia.php?cod_dane_sede=${codDane}&aliado=${encodeURIComponent(aliado)}&eje=${encodeURIComponent(eje)}`;

                // Si el aliado es "Entre Otros" y hay especificación, agregarla a la URL
                if (aliado === 'Entre Otros' && especificarAliado) {
                    url += `&especificar_aliado=${encodeURIComponent(especificarAliado)}`;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Datos encontrados:', data);
                        const form = document.getElementById('formEstrategia');

                        if (data && Object.keys(data).length > 0) {
                            // Rellenar campos (excepto aliado y eje que ya están seleccionados)
                            form.querySelector('[name="dias"]').value = data.dias || '';
                            form.querySelector('[name="horas"]').value = data.horas || '';
                            form.querySelector('[name="jornada"]').value = data.jornada || '';

                            // Mostrar el campo de especificación si el aliado es "Entre Otros"
                            if (aliado === 'Entre Otros') {
                                mostrarCampoEspecificacion(aliado, data.especificar_aliado || '');
                            }

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
                            // No hay datos, limpiar campos dependientes del eje
                            limpiarCamposDependientesDelEje();
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener datos:', error);
                    });
            }

            // Funcion para limpiar solo los campos que dependen del eje
            function limpiarCamposDependientesDelEje() {
                const form = document.getElementById('formEstrategia');

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

            // Función para mostrar el campo de especificación cuando se carga data existente
            function mostrarCampoEspecificacion(aliado, especificarAliado) {
                const especificarContainer = document.getElementById('especificarAliadoContainer');
                const especificarInput = document.getElementById('especificar_aliado');

                if (aliado === 'Entre Otros') {
                    especificarContainer.style.display = 'block';
                    especificarInput.required = true;
                    if (especificarAliado) {
                        especificarInput.value = especificarAliado;
                    }
                } else {
                    especificarContainer.style.display = 'none';
                    especificarInput.required = false;
                    especificarInput.value = '';
                }
            }

            function calcularTotal() {
                let total = 0;
                document.querySelectorAll('.cantidad').forEach(input => {
                    total += parseInt(input.value) || 0;
                });
                document.getElementById('totalEstudiantes').textContent = total;
            } // Manejar el envio del formulario de estrategia
            document.getElementById('formEstrategia').addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Formulario enviado');
                // Validar que cod_dane_sede esté presente
                const codDaneSede = document.getElementById('cod_dane_sede_estrategia').value;
                console.log('Codigo DANE sede:', codDaneSede);

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

                // Validar campo de especificación si es "Entre Otros"
                const especificarAliado = document.getElementById('especificar_aliado').value;
                if (aliado === 'Entre Otros' && !especificarAliado.trim()) {
                    alert('Por favor, especifique el nombre del aliado.');
                    document.getElementById('especificar_aliado').focus();
                    return;
                }

                // Validar que eje esté seleccionado
                const eje = document.querySelector('[name="eje"]').value;
                if (!eje) {
                    alert('Por favor, seleccione un eje movilizador.');
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
                        // Restaurar boton
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    });
            });

            // Validación para prevenir valores negativos en inputs numéricos
            document.addEventListener('DOMContentLoaded', function() {
                // Seleccionar todos los inputs de tipo number
                const numberInputs = document.querySelectorAll('input[type="number"]');

                numberInputs.forEach(input => {
                    // Prevenir la entrada de valores negativos mediante teclado
                    input.addEventListener('keydown', function(e) {
                        // Permitir teclas de navegación y control
                        const allowedKeys = [
                            'Backspace', 'Delete', 'Tab', 'Escape', 'Enter',
                            'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown',
                            'Home', 'End'
                        ];

                        // Permitir Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X, Ctrl+Z
                        if (e.ctrlKey || e.metaKey) {
                            return;
                        }

                        // Si es una tecla permitida, continuar
                        if (allowedKeys.includes(e.key)) {
                            return;
                        }

                        // Prevenir el signo menos (-) y el signo más (+)
                        if (e.key === '-' || e.key === '+') {
                            e.preventDefault();
                            return;
                        }

                        // Permitir solo números
                        if (!/^[0-9]$/.test(e.key)) {
                            e.preventDefault();
                            return;
                        }
                    });

                    // Validar al cambiar el valor (paste, drag, etc.)
                    input.addEventListener('input', function(e) {
                        let value = parseFloat(this.value);

                        // Si el valor es negativo, establecerlo a 0
                        if (value < 0 || isNaN(value)) {
                            this.value = 0;

                            // Si es un input de cantidad, recalcular total
                            if (this.classList.contains('cantidad')) {
                                calcularTotal();
                            }
                        }

                        // Validar máximos específicos
                        const max = parseFloat(this.getAttribute('max'));
                        if (max && value > max) {
                            this.value = max;

                            // Si es un input de cantidad, recalcular total
                            if (this.classList.contains('cantidad')) {
                                calcularTotal();
                            }
                        }
                    });

                    // Validar al perder el foco
                    input.addEventListener('blur', function(e) {
                        let value = parseFloat(this.value);

                        // Si está vacío o es negativo, establecer el mínimo permitido
                        if (isNaN(value) || value < 0) {
                            const min = parseFloat(this.getAttribute('min')) || 0;
                            this.value = min;

                            // Si es un input de cantidad, recalcular total
                            if (this.classList.contains('cantidad')) {
                                calcularTotal();
                            }
                        }
                    });
                });
            });

            // Función para exportar a Excel con mensaje de carga
            function exportarEstrategiaExcel(event) {
                // Prevenir navegación inmediata
                event.preventDefault();

                const target = event.target.closest('a'); // Obtener el enlace
                const originalText = target.innerHTML;
                const originalHref = target.href;

                // Mostrar mensaje de carga
                target.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generando Excel...';
                target.style.pointerEvents = 'none'; // Deshabilitar clics

                // Simular delay para mostrar el mensaje y luego navegar
                setTimeout(() => {
                    window.location.href = originalHref;

                    // Restaurar botón después de un momento
                    setTimeout(() => {
                        target.innerHTML = originalText;
                        target.style.pointerEvents = 'auto'; // Habilitar clics nuevamente
                    }, 2000);
                }, 500);

                return false;
            }
        </script>

</body>

</html>