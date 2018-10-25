       <?php
    include '../../include/dbconnect.php';
    session_start();

    if (!empty($_SESSION['user']))
      { 
         $urluri = str_replace('?'.$_SERVER["QUERY_STRING"],"", $_SERVER["REQUEST_URI"] );

      //   $validarmenu = "select me.url as 'url' from menudetalle me
      //             inner join menuusuario mu on me.IdMenuDetalle = mu.IdMenuDetalle
      //             inner join usuario u on mu.IdUsuario = u.IdUsuario
      //             where u.InicioSesion = '" . $_SESSION['user'] . "'  and me.Url = '" . str_replace('/SisPlanillasLexa/web/','../', $_SERVER["REQUEST_URI"]) . "'";
      //   $resultadovalidarmenu = $mysqli->query($validarmenu);

      // if (mysqli_num_rows($resultadovalidarmenu) <> 0)
      //     {
      //        header( "Location: ../site/index" );

    
    $url = str_replace("/SisPlanillasLexa/web/","../",  $urluri );

    
     $queryempleado = "SELECT IdEmpleado, concat(PrimerNomEmpleado,' ',SegunNomEmpleado,' ',PrimerApellEmpleado,' ',SegunApellEmpleado) AS 'NOMBRECOMPLETO', SalarioNominal AS 'SALARIO', EmpleadoActivo As 'ACTIVO' FROM empleado ORDER BY PrimerNomEmpleado ASC";
        $resultadoempleado = $mysqli->query($queryempleado);


    ?>

  <!doctype html>
<html lang="en">

<head>
        <title>Expediente</title>

       <?php include '../../include/include.php'; ?>

</head>

<body>
    <div class="wrapper">
        

      <?php include '../../include/aside2.php'; ?>


        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Inicio <?php echo  $url; ?> </a>
                    </div>
                    <div class="collapse navbar-collapse">
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                      <!--breadcrumbs start -->
                      <ul class="breadcrumb">
                          <li><a href="#"></i> Inicio</a></li>
                          <li><a href="index.php">Expediente</a></li>
                      </ul>
                      <!--breadcrumbs end -->
                  </div>
              </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">mail_outline</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Expedientes</h4>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                          <?php
                                          echo"<thead class='cf'>";
                                              echo"<tr>";
                                              echo"<th>NOMBRE COMPLETO</th>";
                                              echo"<th>ESTADO</th>";
                                              echo"<th>ACCION</th>";
                                              echo"</tr>";
                                          echo"</thead>";
                                          echo"<tbody>";

                                           while ($row = $resultadoempleado->fetch_assoc())
                                          {
                                               $id = $row['IdEmpleado'];
                                               echo"<tr>";
                                               echo"<td>".$row['NOMBRECOMPLETO']."</td>";
                                              if($row['ACTIVO'] == '1'){
                                              echo"<td><span class='label label-success label-mini' >ACTIVO</span></td>";
                                               }
                                             elseif($row['ACTIVO'] == '0'){
                                              echo"<td><span class='label label-danger label-mini'>INACTIVO</span></td>";
                                               }
                                               
                                               echo"<td width='50px'><div id='btn$id' class='btn-expe'><span class='btn btn-info btn'> VER EMPLEADO</span></div>
                                                          </td>";
                                               echo"</tr>";
                                               echo"</body>  ";
                                          }
                                    ?>
                                        </table>
                                      </div>
                                </div>
                                

                               <form id="frm" action="expedientes.php" method="post" class="hidden">
                      <input type="text" id="IdEmpleado" name="IdEmpleado" />
                    </form> 
                          </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <?php include '../../include/footer.php'; ?>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
        $(document).ready(function(){

            $(".btn-expe").click(function(){
                var id = $(this).attr("id").replace("btn","");
                $("#IdEmpleado").val(id);
                $("#frm").submit();
            });
        });

    </script>
    <?php
      //}
      // else
      // {
      //         echo "
      // <script>
      //   alert('Usted no tiene permiso para ingresar a esta pagina');
      //   document.location='../index.php';

      // </script>
      // ";

      // }
    }
    else{
      echo "
      <script>
        alert('No ha iniciado sesion');
        document.location='../index.php';

      </script>
      ";
    }
    ?>

