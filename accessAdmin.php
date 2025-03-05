<?php
    
    
    include("./conexion.php");
    include("./sessionCheck.php");
    if ($tipo_usuario !== "1") {
        header("Location: index.php"); 
        exit();
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="js/64d58efce2.js" ></script>
        <link rel="stylesheet" href="css/menu.css">
    <head>
    <body>
        <header>
            <div class="container">
                <input type="checkbox" name="" id="check">

                <div class="logo-container">
                    <h3 class="logo"><?php echo $nombre; ?><span></span></h3>
                </div>

                <?php if($tipo_usuario == 1) { ?>

                <div class="nav-btn">
                    <div class="nav-links">
                        <ul>
                            <li class="nav-link" style="--i: .6s">
                           
                                <a href="./code/usuarios/adduser.php">Usuarios</a>
                            </li>

                            <li class="nav-link" style="--i: .85s">
                                <a href="#">General<i class="fas fa-caret-down"></i></a>
                                <div class="dropdown">
                                    <ul>
                                        <li class="dropdown-link">
                                            <a href="./code/general/generalReport.php">SEGUIMIENTO PEI<i class="fas fa-caret-down"></i></a>
                                            <!-- <div class="dropdown second"> -->
                                                <!-- <ul>
                                                   <li class="dropdown-link">
                                                        <a href="">Ver</a>
                                                    </li> 
                                                    <li class="dropdown-link">
                                                        <a href="code/teleologico/addteleologico.php">Consultar</a>
                                                    </li> 
                                                    <div class="arrow"></div>
                                                </ul> -->
                                            <!-- </div> -->
                                        </li>
                                        <div class="arrow"></div>
                                    </ul>
                                </div>
                            </li>
                
                
                            <li class="nav-link" style="--i: .85s">
                                <a href="#">PLANES|PROYECTOS<i class="fas fa-caret-down"></i></a>
                                <div class="dropdown">
                                    <ul>
                                        <!-- <li class="dropdown-link">
                                            <a href="#">Link 1</a>
                                        </li>
                                        <li class="dropdown-link">
                                            <a href="#">Link 2</a>
                                        </li> -->
                                        <li class="dropdown-link">
                                            <a href="#">PROYECTOS PEDAGÓGICOS<i class="fas fa-caret-down"></i></a>
                                            <div class="dropdown second">
                                                <ul>
                                                <li class="dropdown-link">
                                                            <ul>
                                                                <li class="dropdown-link">
                                                                    <a href="./code/proyect_transv/management/admin/colleges.php">Ver</a>
                                                                </li>
                                                                <li class="dropdown-link">
                                                                    <a href="./code/proyect_transv/management/admin/colleges.php">Editar</a>
                                                                </li>
                                                                <li class="dropdown-link">
                                                                    <a href="./code/proyect_transv/management/admin/supervisor/supervisor.php">Seguimiento</a>
                                                                </li>
                                                            </ul>
                                                       
                                                </li>
                                            </div>
                                        </li> 
                                       <!-- <li class="dropdown-link">
                                            <a  href="#">Link 4</a>
                                        </li>  -->
                                        <div class="arrow"></div>
                                    </ul>
                                </div>
                            </li>
                
                            <!-- <li class="nav-link" style="--i: 1.1s">
                                <a href="#">Services<i class="fas fa-caret-down"></i></a>
                                <div class="dropdown">
                                    <ul>
                                        <li class="dropdown-link">
                                            <a href="#">Link 1</a>
                                        </li>
                                        <li class="dropdown-link">
                                            <a href="#">Link 2</a>
                                        </li>
                                        <li class="dropdown-link">
                                            <a href="#">Link 3<i class="fas fa-caret-down"></i></a>
                                            <div class="dropdown second">
                                                <ul>
                                                    <li class="dropdown-link">
                                                        <a href="#">Link 1</a>
                                                    </li>
                                                    <li class="dropdown-link">
                                                        <a href="#">Link 2</a>
                                                    </li>
                                                    <li class="dropdown-link">
                                                        <a href="#">Link 3</a>
                                                    </li>
                                                    <li class="dropdown-link">
                                                        <a href="#">More<i class="fas fa-caret-down"></i></a>
                                                        <div class="dropdown second">
                                                            <ul>
                                                                <li class="dropdown-link">
                                                                    <a href="#">Link 1</a>
                                                                </li>
                                                                <li class="dropdown-link">
                                                                    <a href="#">Link 2</a>
                                                                </li>
                                                                <li class="dropdown-link">
                                                                    <a href="#">Link 3</a>
                                                                </li>
                                                                <div class="arrow"></div>
                                                            </ul>
                                                        </div>
                                                    </li> 
                                                    <div class="arrow"></div>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="dropdown-link">
                                            <a href="#">Link 4</a>
                                        </li>
                                        <div class="arrow"></div>
                                    </ul>
                                </div>
                            </li>  -->
                

                             <!-- <li class="nav-link" style="--i: 1.35s">
                                <a href="#">About</a>
                            </li>  -->
                        </ul>
                    </div>

                        <div class="log-sign" style="--i: 1.8s">
                        <!--<a href="#" class="btn transparent">Log in</a>-->
                        <a href="logout.php" class="btn solid">Salir</a>
                        </div>
                </div>
                <?php } ?>
                
                <div class="hamburger-menu-container">
                    <div class="hamburger-menu">
                        <div></div>
                    </div>
                </div>
            </div>
        </header>
            <main>
                <section>
                    <div class="overlay"></div>
                </section>
            </main>
    </body>
</html>