<?php
include '../../include/dbconnect.php';
session_start();

if (!empty($_SESSION['user']))
  {
      $urluri = str_replace('?'.$_SERVER["QUERY_STRING"],"", $_SERVER["REQUEST_URI"] );



$url = str_replace("/SisPlanillasLexa/web/","../",  $urluri );

$queryconfiguraciongeneral = "SELECT HonorariosConfig from configuraciongeneral where IdConfiguracion = 1";
$resultadoconfiguraciongeneral = $mysqli->query($queryconfiguraciongeneral);

while ($test = $resultadoconfiguraciongeneral->fetch_assoc())
					 {
							 $HonorariosConfig = $test['HonorariosConfig'];
					 }

$FechaIni = str_replace('/',"-", $_POST['FechaIni'] );
$FechaFin = str_replace('/',"-", $_POST['FechaFin'] );


$diaIni = substr($FechaIni, 8, 2);
$diaFin = substr($FechaFin, 8, 2);
if(($diaIni = substr($FechaIni, 8, 2)) >= 01 and ($diaFin = substr($FechaFin, 8, 2)) <= 15){
  $quincena = 1;
}
elseif(($diaIni = substr($FechaIni, 8, 2)) >= 15 and ($diaFin = substr($FechaFin, 8, 2)) <= 31){
   $quincena = 2;
}
else{
   $quincena = 3;
}



$queryplanilla = "SELECT CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO', SUM(ho.MontoHonorario) as 'MONTO', SUM(ho.MontoISRHonorarios) as 'RENTA', SUM(ho.MontoHonorario) as 'LIQUIDO' from honorario ho
INNER JOIN empleado E on ho.IdEmpleado = E.IdEmpleado
WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 1 AND ho.FechaHonorario between '$FechaIni' and '$FechaFin'
group by E.IdEmpleado";

             $mes = strftime("%B");
                 if($mes == 'January'){
                     $mes = 'Enero';
                 }
                 elseif($mes == 'February'){
                     $mes = 'Febrero';
                 }
                 elseif($mes == 'March'){
                     $mes = 'Marzo';
                 }
                 elseif($mes == 'April'){
                     $mes = 'Abril';
                 }
                 elseif($mes == 'May'){
                     $mes = 'Mayo';
                 }
                 elseif($mes == 'June'){
                     $mes = 'Junio';
                 }
                 elseif($mes == 'July'){
                     $mes = 'Julio';
                 }
                 elseif($mes == 'August'){
                     $mes = 'Agosto';
                 }
                 elseif($mes == 'September'){
                     $mes = 'Septiembre';
                 }
                 elseif($mes == 'October'){
                     $mes = 'Octubre';
                 }
                 elseif($mes == 'November'){
                     $mes = 'Noviembre';
                 }
                 else{
                     $mes = 'Diciembre';
                 }

             $anio = date("Y");


             $querytotplanilla = "SELECT CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',
             SUM(ho.MontoHonorario) as 'MONTO',SUM(AN.MontoAnticipo) as 'ANTICIPOS', SUM(ho.MontoISRHonorarios) as 'RENTA', (SUM(ho.MontoPagar) - SUM(AN.MontoAnticipo)) as 'LIQUIDO', SUM(ho.ISSSHonorario) as 'ISSS', SUM(ho.AFPHonorario) as 'AFP' from honorario ho
             INNER JOIN empleado E on ho.IdEmpleado = E.IdEmpleado
             INNER JOIN anticipos AN on AN.IdEmpleado = E.IdEmpleado
             WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 1 AND ho.FechaHonorario between '$FechaIni' and '$FechaFin'
             group by E.IdEmpleado";

                 $resultadoqueryplanilla = $mysqli->query($querytotplanilla);


             $querytotplanilla = "SELECT CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',
             SUM(ho.MontoHonorario) as 'MONTO',SUM(AN.MontoAnticipo) as 'ANTICIPOS', SUM(ho.MontoISRHonorarios) as 'RENTA', (SUM(ho.MontoPagar) - SUM(AN.MontoAnticipo)) as 'LIQUIDO', SUM(ho.ISSSHonorario) as 'ISSS', SUM(ho.AFPHonorario) as 'AFP' from honorario ho
             INNER JOIN empleado E on ho.IdEmpleado = E.IdEmpleado
             INNER JOIN anticipos AN on AN.IdEmpleado = E.IdEmpleado
             WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 1 AND ho.FechaHonorario between '$FechaIni' and '$FechaFin'
             group by E.IdEmpleado";

                 $resultadoquerytotplanilla = $mysqli->query($querytotplanilla);

                 $ttothonorario = 0;
                 $ttotisr = 0;
                 $ttotafp = 0;
                 $ttotisss = 0;
                 $ttotanticipos = 0;
                 $ttothonorariotot = 0;


                 while ($test = $resultadoquerytotplanilla->fetch_assoc())
                            {
                                $ttothonorario += $test['MONTO'];
                                $ttotisr += $test['RENTA'];
                                $ttotisss += $test['ISSS'];
                                $ttotafp += $test['AFP'];
                                $ttotanticipos += $test['ANTICIPOS'];
                                $ttothonorariotot += $test['LIQUIDO'];


                                $nombreCom = $test['NOMBRECOMPLETO'];
                                $tothonorario = $test['MONTO'];
                                $totisr = $test['RENTA'];
                                $totanticipos = $test['ANTICIPOS'];
                                $tothonorariototal = $test['LIQUIDO'];

                            }

        $queryempresa = "select e.NombreEmpresa, e.Direccion, e.NitEmpresa, d.NombreDepartamento
                        from empresa e
                        inner join departamentos d on e.IdDepartamentos = d.IdDepartamentos
                        where IdEmpresa = 1";
        $resultadoqueryempresa = $mysqli->query($queryempresa);

        while ($test = $resultadoqueryempresa->fetch_assoc())
                   {
                       $empresa = $test['NombreEmpresa'];
                       $direccion = $test['Direccion'];
                       $nitempresa = $test['NitEmpresa'];
                       $departamento = $test['NombreDepartamento'];

                   }

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/lexa.PNG" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Previa Planilla</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
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

                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-icon" data-background-color="orange">
                          <i class="material-icons">mail_outline</i>
                      </div>
                      <div class="card-content">
                          <h4 class="card-title">Vista Previa de Planilla no Dependiente</h4>

                          <?php
                            if($HonorariosConfig == 0)
                            {
                              ?>
                          <center><strong><?php echo $empresa; ?></strong>
                          <center><strong>REPORTE EMPLEADOS NO DEPENDIENTE</strong></center>
                          <strong><small><?php echo $direccion; ?></small></strong>
                          </br><strong><small><?php echo $nitempresa; ?></small></strong>
                        </br><strong>Del <?php echo $diaIni; ?> al <?php echo $diaFin; ?> de <?php echo $mes; ?> de <?php echo $anio; ?></strong>
                        </br>
                          </center>
                          <div class="table">
                            </br>
                              <table class="table">
                                  <thead class="text-primary">
                                      <tr>
                                        <strong>
                                        <td><strong><center>EMPLEADO</center></strong></td>
                                        <td><strong><center>HONORARIO</center></strong></td>
                                        <td><strong><center>RENTA</center></strong></td>
                                        <td><strong><center>ANTICIPOS</center></strong></td>
                                        <td><strong><center>LIQUIDO</center></strong></td>

                                      </tr>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                    while ($test = $resultadoqueryplanilla->fetch_assoc())
                                  {
                                       echo"<tr>";
                                       echo"<td width='90px'><center>".$test['NOMBRECOMPLETO']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['MONTO']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['RENTA']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['ANTICIPOS']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['LIQUIDO']."</center></td>";
                                  }
                                  ?>

                                  </tbody>
                                  <thead class="text-primary">
                                    <tr>
                                        <td align="right"><strong>TOTAL:</strong></td>
                                        <td><strong><center>$<?php echo number_format($ttothonorario,2); ?></center></strong></td>
                                        <td><strong><center>$<?php echo number_format($ttotisr,2); ?></center></strong></td>
                                        <td><strong><center>$<?php echo number_format($ttotanticipos,2); ?></center></strong></td>
                                        <td><strong><center>$<?php echo number_format($ttothonorariotot,2); ?></center></strong></td>
                                    </tr>
                                  </thead>
                              </table>
                          </div>
                          <?php
                        }
                        else{ //ISSS-AFP
                        ?>

                        <center><strong><?php echo $empresa; ?></strong>
                        <center><strong>REPORTE EMPLEADOS NO DEPENDIENTE</strong></center>
                        <strong><small><?php echo $direccion; ?></small></strong>
                        </br><strong><small><?php echo $nitempresa; ?></small></strong>
                        </br><strong>Del <?php echo $diaIni; ?> al <?php echo $diaFin; ?> de <?php echo $mes; ?> de <?php echo $anio; ?></strong>
                        </br>
                        </center>
                        <div class="table">
                          </br>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                      <strong>
                                      <td><strong><center>EMPLEADO</center></strong></td>
                                      <td><strong><center>HONORARIO</center></strong></td>
                                      <td><strong><center>AFP</center></strong></td>
                                      <td><strong><center>ISSS</center></strong></td>
                                      <td><strong><center>LIQUIDO</center></strong></td>

                                    </tr>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                  while ($test = $resultadoqueryplanilla->fetch_assoc())
                                {
                                    echo"<tr>";
                                       echo"<td width='90px'><center>".$test['NOMBRECOMPLETO']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['MONTO']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['RENTA']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['ANTICIPOS']."</center></td>";
                                       echo"<td width='60px'><center>$ ".$test['LIQUIDO']."</center></td>";
                                }
                                ?>

                                </tbody>
                                <thead class="text-primary">
                                  <tr>
                                      <td align="right"><strong>TOTAL:</strong></td>
                                      <td><strong><center>$<?php echo number_format($ttothonorario,2); ?></center></strong></td>
                                      <td><strong><center>$<?php echo number_format($ttotafp,2); ?></center></strong></td>
                                      <td><strong><center>$<?php echo number_format($ttotisss,2); ?></center></strong></td>
                                      <td><strong><center>$<?php echo number_format($ttotanticipos,2); ?></center></strong></td>
                                      <td><strong><center>$<?php echo number_format($ttothonorariotot,2); ?></center></strong></td>
                                  </tr>
                                </thead>
                            </table>
                        </div>
                        <?php
                        }
                        ?>

                      </div>
                      <div class="col-xs-12">
                        <center>
                          <a href="../planillanodependiente/index.php" class="btn btn-danger"></i> REGRESAR</a>
                        <button class="btn btn-success btn-raised btn-imprimir">
                                 IMPRIMIR PLANILLA
                        </button>
                      </center>

                    </div>

                    </div>
                </div>
            </div>
            <?php include '../../include/footer.php'; ?>
        </div>
    </div>

    <form id="frmplanilla" action="../../report/planillanodependiente/index" method="post" target="_blank" class="hidden">
      <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $_POST['FechaIni'];?>" />
      <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $_POST['FechaFin'];?>" />
    </form>

    <form id="frmexcel" action="reporteexcel.php" method="post" target="_blank" class="hidden">
      <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $_POST['FechaIni'];?>" />
      <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $_POST['FechaFin'];?>" />
      <input type="text" id="Tipo" name="Tipo" value="<?php echo $_POST['Tipo'];?>" />
    </form>
</body>
<!--   Core JS Files   -->

<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/js/material.min.js" type="text/javascript"></script>
<script src="../assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="../assets/js/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="../assets/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="../assets/js/moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="../assets/js/chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="../assets/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="../assets/js/bootstrap-notify.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="../assets/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="../assets/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="../assets/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="../assets/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="../assets/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="../assets/js/sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="../assets/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="../assets/js/fullcalendar.min.js"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="../assets/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="../assets/js/material-dashboard.js?v=1.2.1"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="../assets/js/demo.js"></script>

</html>
<script type="text/javascript">
    $(document).ready(function(){

        $(".btn-imprimir").click(function(){
            // var id = $(this).attr("value");
            // $("#IdIndemnizacion").val(id);
            $("#frmplanilla").submit();
            //alert(id);
        });
        $(".btn-boleta").click(function(){
            // var id = $(this).attr("value");
            // $("#IdIndemnizacion").val(id);
            $("#frmboleta").submit();
            //alert(id);
        });
        $(".btn-guardar").click(function(){
            // var id = $(this).attr("value");
            // $("#IdIndemnizacion").val(id);
            $("#frmguardar").submit();
            //alert(id);
        });
        $(".btn-excel").click(function(){
            // var id = $(this).attr("value");
            // $("#IdIndemnizacion").val(id);
            $("#frmexcel").submit();
            //alert(id);
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
    document.location='../index';

  </script>
  ";
}
?>
