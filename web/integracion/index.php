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
<html lang="es">

<head>
    <title>Peachtree Planilla</title>

   <?php include '../../include/include.php'; ?>
   <script src="../web/js/jquery-1.8.3.min.js"></script>
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
                                <h4 class="card-title">PECAHTREE ASIENTO PLANILLA</h4>
                                <div class="material-datatables">
                                  <center>
                                  <button class="btn btn-success btn-raised" data-toggle="modal" data-target="#asientodiario">
                                      GENERAR ASIENTO DIARIO
                                  </button>
                                  <button class="btn btn-info btn-raised" data-toggle="modal" data-target="#generarcsv">
                                      GENERAR CSV
                                  </button>
                                </center>
                                </div>
                                <div class="modal fade" id="asientodiario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">ASIENTO DIARIO</h4>
                                            </div>
                                            <div class="modal-body">
                                              <form action="integracion.php" role="form" method="POST">
                                                <div class="row">
                                                  <div class="form-group col-md-6">
                                                       <label for="title">Seleccione Mes:</label>
                                                       <select name="mes" class="form-control">
                                                             <option value="Enero">ENERO</option>
                                                             <option value="Febrero">FEBRERO</option>
                                                             <option value="Marzo">MARZO</option>
                                                             <option value="Abril">ABRIL</option>
                                                             <option value="Mayo">MAYO</option>
                                                             <option value="Junio">JUNIO</option>
                                                             <option value="Julio">JULIO</option>
                                                             <option value="Agosto">AGOSTO</option>
                                                             <option value="Septiembre">SEPTIEMBRE</option>
                                                             <option value="Octubre">OCTUBRE</option>
                                                             <option value="Noviembre">NOVIEMBRE</option>
                                                             <option value="Diciembre">DICIEMBRE</option>
                                                       </select>
                                                   </div>
                                                   <div class="form-group col-md-6">
                                                        <label for="title">Seleccione Periodo</label>
                                                        <select name="periodo" class="form-control">
                                                              <option value="2018">2018</option>
                                                              <option value="2019">2019</option>
                                                              <option value="2020">2020</option>
                                                              <option value="2021">2021</option>
                                                              <option value="2022">2022</option>
                                                              <option value="2023">2023</option>
                                                              <option value="2024">2024</option>
                                                              <option value="2025">2025</option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="form-group col-md-6">
                                                         <label for="title">Seleccione Planilla</label>
                                                         <select name="quincena" class="form-control">
                                                               <option value="1">PRIMER PLANILLA</option>
                                                               <option value="2">SEGUNDA PLANILLA</option>
                                                         </select>
                                                     </div>
                                                      <div class="form-group col-md-6">
                                                           <label for="title">Fecha</label>
                                                           <input name="fecha" type="text" class="form-control datepicker"/>
                                                       </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-success" name="generarinfo" >GENERAR INFORMACION</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="generarcsv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">GENERAR CSV</h4>
                                            </div>
                                            <div class="modal-body">
                                              <form action="exportar.php" role="form" method="POST">
                                                <div class="row">
                                                  <div class="form-group col-md-6">
                                                       <label for="title">Seleccione Mes:</label>
                                                       <select name="mes" class="form-control">
                                                             <option value="Enero">ENERO</option>
                                                             <option value="Febrero">FEBRERO</option>
                                                             <option value="Marzo">MARZO</option>
                                                             <option value="Abril">ABRIL</option>
                                                             <option value="Mayo">MAYO</option>
                                                             <option value="Junio">JUNIO</option>
                                                             <option value="Julio">JULIO</option>
                                                             <option value="Agosto">AGOSTO</option>
                                                             <option value="Septiembre">SEPTIEMBRE</option>
                                                             <option value="Octubre">OCTUBRE</option>
                                                             <option value="Noviembre">NOVIEMBRE</option>
                                                             <option value="Diciembre">DICIEMBRE</option>
                                                       </select>
                                                   </div>
                                                   <div class="form-group col-md-6">
                                                        <label for="title">Seleccione Periodo</label>
                                                        <select name="periodo" class="form-control">
                                                              <option value="2018">2018</option>
                                                              <option value="2019">2019</option>
                                                              <option value="2020">2020</option>
                                                              <option value="2021">2021</option>
                                                              <option value="2022">2022</option>
                                                              <option value="2023">2023</option>
                                                              <option value="2024">2024</option>
                                                              <option value="2025">2025</option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="form-group col-md-12">
                                                         <label for="title">Seleccione Planilla</label>
                                                         <select name="quincena" class="form-control">
                                                               <option value="1">PRIMER PLANILLA</option>
                                                               <option value="2">SEGUNDA PLANILLA</option>
                                                         </select>
                                                     </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-success" name="generarinfo" >GENERAR CSV</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                                            </div>
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
