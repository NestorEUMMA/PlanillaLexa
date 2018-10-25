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


?>

<!doctype html>
<html lang="en">

<head>
    <title>Planilla</title>

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
                    <a class="navbar-brand" href="#"> Inicio <!-- <a class="navbar-brand" href="#"> Inicio <?php echo  $url; ?> </a> --> </a>
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
                        <li><a href="#"> Inicio</a></li>
                        <li><a href="index.php">Ingreso de Parametros</a></li>
                    </ul>
                    <!--breadcrumbs end -->
                  </div>
              </div>
              <div class="row"  >
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                <i class="material-icons">mail_outline</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Ingreso de Parametros para Planilla no Dependiente</h4>
                                <div class="material-datatables">
                                  <form action="reporte.php" role="form" method="POST">
                                  <div class="row">
                                    <div class="form-group col-md-4">
                                         <label for="title">Fecha INICIO</label>
                                         <input name="FechaIni" type="text" class="form-control datepicker"/>
                                     </div>
                                     <div class="form-group col-md-4">
                                          <label for="title">Fecha FIN</label>
                                          <input name="FechaFin" type="text" class="form-control datepicker"/>
                                      </div>
                                    </div>
                                    <div class="row">
                                       <div class="form-group col-md-4">
                                         <center>
                                         <button type="submit" class="btn btn-success" name="guardarPlanilla" >Generar Planilla</button>
                                       </center>
                                        </div>
                                      </div>
                                      </form>
                                </div>
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

<script src="../web/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){

        demo.initFormExtendedDatetimepickers();

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
