<?php

require_once 'menuclass2.php';

$queryexpedientesu = "SELECT a.IdUsuario, a.InicioSesion, b.IdPuesto, b.Descripcion as NombrePuesto, concat(a.Nombres, ' ', a.Apellidos) as NombreCompleto, a.FechaIngreso as Fecha, a.ImagenUsuario as Imagen
               FROM usuario as a
               inner join puesto as b on b.IdPuesto = a.IdPuesto
               WHERE InicioSesion =  '" . $_SESSION['user'] . "'";
            $resultadoexpedientesu = $mysqli->query($queryexpedientesu);
            while ($test = $resultadoexpedientesu->fetch_assoc())
                       {
                           $puesto = $test['NombrePuesto'];
                           $nombreusuario = $test['NombreCompleto'];
                           $fecha = $test['Fecha'];
                           $imagen = $test['Imagen'];

                       }

?>

        <div class="sidebar" data-active-color="orange" data-background-color="black" data-image="../assets/img/sidebar-5.jpg">

            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
            <div class="logo">
                <a href="../site/index" class="simple-text logo-mini">
                    PL
                </a>
                <a href="../site/index" class="simple-text logo-normal">
                    Planilla LEXA
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="../<?php echo $imagen; ?>" />
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                <?php echo $nombreusuario; ?>
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="../../include/logout.php?logout">
                                        <span class="sidebar-mini"> CS </span>
                                        <span class="sidebar-normal"> Cerrar Sesion </a></span>
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="#">
                                        <span class="sidebar-mini"> AJ </span>
                                        <span class="sidebar-normal"> Ajustes </a></span>
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <?php
                        $menu = new Menu();
                      ?>
                       <?php foreach ($menu->getMenu() as $m) : ?>
                    <li>
                        <a data-toggle="collapse" href="#<?php echo $m['IdMenu'] ?>">
                            <i class="material-icons"><?php echo $m['Icono'] ?></i>
                            <p> <?php echo $m['DescripcionMenu'] ?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="<?php echo $m['IdMenu'] ?>">
                            <?php foreach ($menu->getSubMenu($m['IdMenu']) as $s) : ?>
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo $s['Url'] ?>">
                                        <span class="sidebar-mini">  <?php echo $s['Icono'] ?>  </span>
                                        <span class="sidebar-normal"> <?php echo $s['DescripcionMenuDetalle'] ?> </span>
                                    </a>
                                </li>
                            </ul>
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
