   

    <header class="header white-bg">
          <div class="sidebar-toggle-box">
              <i class="fa fa-bars"></i>
          </div>
          <a href="../web/index" class="logo" >Lexa <span>Planillas</span></a>
          <div class="nav notify-row" id="top_menu">
          </div>
          <?php
  
                $queryexpedientesu = "SELECT a.IdUsuario, a.InicioSesion, b.IdPuesto, b.Descripcion as NombrePuesto, concat(a.Nombres, ' ', a.Apellidos) as NombreCompleto, a.FechaIngreso as Fecha
                  FROM usuario as a 
                  inner join puesto as b on b.IdPuesto = a.IdPuesto
                  WHERE InicioSesion =  '" . $_SESSION['user'] . "'";
               $resultadoexpedientesu = $mysqli->query($queryexpedientesu);
               while ($test = $resultadoexpedientesu->fetch_assoc())
                          {
                              $puesto = $test['NombrePuesto'];
                              $nombreusuario = $test['NombreCompleto'];
                              $fecha = $test['Fecha'];
          
                          }

         ?>
          <div class="top-nav ">  
              <ul class="nav pull-right top-menu">
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <img alt="" src="img/avatar1_small.jpg">
                          <span class="username"> <?php echo $nombreusuario; ?></span>
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu extended logout">
                          <div class="log-arrow-up"></div>
                          <li><a href="#"><i class="fa fa-cog"></i> Ajustes</a></li>
                          <li><a href="../../include/logout.php?logout"><i class="fa fa-key"></i> Cerrar Sesion</a></li>
                      </ul>
                  </li>
                  <li class="sb-toggle-right">
                      <i class="fa  fa-align-right"></i>
                  </li>
              </ul>
          </div>
          
    </header>