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


  $mes =$_REQUEST['mes'];
  $periodo =$_REQUEST['periodo'];
  $del =$_REQUEST['fecha1'];
  $al =$_REQUEST['fecha2'];
  $quincena = $_POST['quincena'];
  $fechaElaboracion =$_REQUEST['fechaElaboracion'];
  $timestamp = strtotime($fechaElaboracion);
  $new_date = date('d/m/Y', $timestamp);


  $queryintegracion = "select sum(MontoHonorario) as 'MontoHonorario', sum(MontoISRHonorarios) as 'MontoISR', sum(MontoPagar) as 'MontoPagar' from honorario where MesPeriodoHono = '$mes' and
                      AnoPeriodoHono = '$periodo' and FechaHonorario between '$del' and '$al'";
  $resultadointegracion = $mysqli->query($queryintegracion);

  while ($test = $resultadointegracion->fetch_assoc())
  {
      $IPHonoario = $test['MontoHonorario'];
      $IPISR = $test['MontoISR'];
      $IPPagar = $test['MontoPagar'];
  }


  $percepciones = $IPHonoario;
  $deducciones = $IPISR + $IPPagar;


?>

<!doctype html>
<html lang="en">

<head>
    <title>Integracion Peachtree</title>
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
                                <h4 class="card-title">Asiento de Diario</h4>
                                <div class="material-datatables">
                                  <form action="integracionguardar.php" role="form" method="POST">
                                     <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                                     <input type="hidden" name="periodo" value="<?php echo $periodo; ?>">

                                     <input type="hidden" name="quincena" value="<?php echo $quincena; ?>">
                                     <input type="hidden" name="fecha" value="<?php echo $new_date; ?>">

                                     <input type="hidden" name="honorario" value="<?php echo $IPHonoario; ?>">
                                     <input type="hidden" name="isr" value="<?php echo $IPISR; ?>">
                                     <input type="hidden" name="pagar" value="<?php echo $IPPagar;?>">
                                    <br>
                                    <right>
                                    <button type="submit" class="btn btn-success" name="guardarPlanilla" >GENERAR ARCHIVO</button>
                                  </right>
                                    <div class="table-responsive">
                                      <table class="table">
                                          <thead class="text-primary">
                                              <th>NOMBRE</th>
                                              <th>CARGOS</th>
                                              <th>ABONOS</th>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td>HONORARIO</td>
                                                  <td>$<?php echo $IPHonoario;?></td>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td>ISR</td>
                                                  <td></td>
                                                  <td>$<?php echo $IPISR;?></td>
                                              </tr>
                                              <tr>
                                                  <td>SALARIO LIQUIDO</td>
                                                  <td></td>
                                                  <td>$<?php echo $IPPagar;?></td>
                                              </tr>
                                              <tr>
                                                  <td>TOTAL</td>
                                                  <td><b><u>$<?php echo $percepciones;?></u></b></td>
                                                  <td><b><u>$<?php echo number_format((float)$deducciones, 2, '.', '');?></u></b></td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </form>
                                  </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include '../../include/footer.php'; ?>
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
