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

$queryconfiguraciongeneral = "SELECT SalarioMinimo from configuraciongeneral where IdConfiguracion = 1";
$resultadoconfiguraciongeneral = $mysqli->query($queryconfiguraciongeneral);

while ($test = $resultadoconfiguraciongeneral->fetch_assoc())
           {
               $salariominimo = $test['SalarioMinimo'];
           }
           
    $meses = $_POST['mes'];
    $periodo = $_POST['periodo'];

    if($meses == 'Enero'){
        $meses = '01';
    }
    elseif($meses == 'Febrero'){
        $meses = '02';
    }
    elseif($meses == 'Marzo'){
        $meses = '03';
    }
    elseif($meses == 'Abril'){
        $meses = '04';
    }
    elseif($meses == 'Mayo'){
        $meses = '05';
    }
    elseif($meses == 'Junio'){
        $meses = '06';
    }
    elseif($meses == 'Julio'){
        $meses = '07';
    }
    elseif($meses == 'Agosto'){
        $meses = '08';
    }
    elseif($meses == 'Septiembre'){
        $meses = '09';
    }
    elseif($meses == 'Octubre'){
        $meses = '10';
    }
    elseif($meses == 'Noviembre'){
        $meses = '11';
    }
    else{
        $meses = '12';
    }

    $periodoovisss = $periodo."".$meses ;
    $número = cal_days_in_month(CAL_GREGORIAN, $meses, $periodo);
    $FechaIni =  ''.$periodo.'-'.$meses.'-01';
    $FechaFin = ''.$periodo.'-'.$meses.'-'.$número.' ';

// get Users

    $meses = $_POST['mes'];
    $periodo = $_POST['periodo'];

    if($meses == 'Enero'){
        $meses = '01';
    }
    elseif($meses == 'Febrero'){
        $meses = '02';
    }
    elseif($meses == 'Marzo'){
        $meses = '03';
    }
    elseif($meses == 'Abril'){
        $meses = '04';
    }
    elseif($meses == 'Mayo'){
        $meses = '05';
    }
    elseif($meses == 'Junio'){
        $meses = '06';
    }
    elseif($meses == 'Julio'){
        $meses = '07';
    }
    elseif($meses == 'Agosto'){
        $meses = '08';
    }
    elseif($meses == 'Septiembre'){
        $meses = '09';
    }
    elseif($meses == 'Octubre'){
        $meses = '10';
    }
    elseif($meses == 'Noviembre'){
        $meses = '11';
    }
    else{
        $meses = '12';
    }

    $periodoovisss = $periodo."".$meses ;
    $número = cal_days_in_month(CAL_GREGORIAN, $meses, $periodo);
    $FechaIni =  ''.$periodo.'-'.$meses.'-01';
    $FechaFin = ''.$periodo.'-'.$meses.'-'.$número.' ';

// get Users
$query = "  SELECT (select NuPatronal from Empresa where IdEmpresa = 1) as 'NUMEROPATRONAL', '$periodoovisss' as 'PERIODO', '001' as 'CORRELATIVO',
  RPAD(CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado),40,' ') as 'NOMBRECOMPLETO',
  E.NIsss AS 'ISSS',

  LPAD(REPLACE((CONVERT((
  CASE
	WHEN E.FechaDespido = '$FechaFin' THEN E.SalarioNominal
    WHEN E.FechaDespido BETWEEN '$FechaIni' AND '$FechaFin' THEN
    (E.SalarioNominal / (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
    date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month)))) * ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
    date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - DAYOFMONTH(FechaDespido))
    WHEN E.FechaDespido IS NULL AND E.FechaContratacion BETWEEN '$FechaIni' AND '$FechaFin' THEN(E.SalarioNominal / (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
    date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month)))) * ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
    date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - DAYOFMONTH(FechaContratacion))
    ELSE E.SalarioNominal END), DECIMAL(10,2)) -
  CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END ),'.',''),9,0)
  AS 'SALARIO',
  /***************validar si tiene vacaciones, descontar los dias y pasarlos a salario***********************/


 LPAD(REPLACE((CONVERT(0, DECIMAL(10,2)) +
  CASE WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END ),'.',''),9,0)
  AS 'VACACIONES',

  LPAD(REPLACE((CONVERT((0), DECIMAL(10,2)) -
  (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) +
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) +
   (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END)
      ),'.',''),9,0)
  AS 'PAGOSADICIONALES',


  CASE
  WHEN E.FechaDespido = '$FechaFin' THEN ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
  date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))))
  WHEN E.FechaDespido BETWEEN '$FechaIni' AND '$FechaFin' THEN ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
  date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))))
  WHEN E.FechaDespido IS NULL AND E.FechaContratacion BETWEEN '$FechaIni' AND '$FechaFin' THEN ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
  date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month)))- DAYOFMONTH(FechaContratacion))
  WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL AND E.FechaDespido IS NULL
        THEN (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
  date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN '00' ELSE (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END)
        ELSE (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
  date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN '00' ELSE (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) - 15

END as 'DIAS',

  '08' as 'HORASLABORALES',

  CASE WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN '00' ELSE '15'
      END AS 'DIASVACACIONES',

  CASE
  WHEN (CASE WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) +
      (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) +
      (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) +
      (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) > 0.00 THEN '09'  /***************VACACIONES MAS PAGOS ADICIONALES************************/
  WHEN (CASE WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) > 0.00 THEN '08'  /***************VACACIONES***********************/
    WHEN E.FechaContratacion BETWEEN '$FechaIni' AND '$FechaFin' THEN '07' /***************INGRESO O REINGRESO DEL TRABAJADOR***********************/
    WHEN E.FechaDespido BETWEEN '$FechaIni' AND '$FechaFin' THEN '06' /***************RETIRO***********************/
  WHEN P.Incapacidades > 0.00 THEN '05'  /***************INCAPACIDAD***********************/
    WHEN E.Pensionado = 1  THEN '03'  /***************PENSIONADO***********************/
    WHEN CONVERT((E.SalarioNominal), DECIMAL(10,2)) < '$salariominimo' THEN '02'   /***************APRENDICES***********************/
  WHEN
    (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) +
    (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) +
    (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) > 0 THEN '01' /***************PAGOS ADICIONALES***********************/
  ELSE '00' END AS 'CODIGOAUTORIZACION'  /***************SIN CAMBIOS AL MES ANTERIOR***********************/

  FROM Empleado E
  LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
  LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
  WHERE E.EmpleadoActivo = 1 AND E.NoDependiente = 0 AND E.NIsss > 0
  group by E.IdEmpleado
";
  $resultadoqueryplanilla = $mysqli->query($query);
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
                          <h4 class="card-title">Vista Previa de OVISSS</h4>
                          <!-- <center><strong><?php echo $empresa; ?></strong>
                          <center><strong>PLANILLA DE SALARIO</strong></center>
                          <strong><small><?php echo $direccion; ?></small></strong>
                          </br><strong><small><?php echo $nitempresa; ?></small></strong>
                        </br><strong>Del <?php echo $diaIni; ?> al <?php echo $diaFin; ?> de <?php echo $mes; ?> de <?php echo $anio; ?></strong>
                        </br> -->
                          </center>
                          <div class="table">
                            </br>
                              <table class="table">
                                  <thead class="text-primary">
                                    <tr>
                                        <td><strong><center>NUMERO PATRONAL</center></strong></td>
                                        <td><strong><center>PERIODO</center></strong></td>
                                        <td><strong><center>CORRELATIVO</center></strong></td>
                                        <td><strong><center>NOMBRE</center></strong></td>
                                        <td><strong><center>N. ISSS</center></strong></td>
                                        <td><strong><center>SALARIO</center></strong></td>
                                        <td><strong><center>VACACIONES</center></strong></td>
                                        <td><strong><center>PAGOS ADICIONALES</center></strong></td>
                                        <td><strong><center>DIAS</center></strong></td>
                                        <td><strong><center>HORAS</center></strong></td>
                                        <td><strong><center>DIAS VACACION</center></strong></td>
                                        <td><strong><center>CODIGO AUTORIZACION</center></strong></td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                    while ($row = $resultadoqueryplanilla->fetch_assoc())
                                  {
                                       echo"<tr>";
                                       echo"<td>".$row['NUMEROPATRONAL']."</center></td>";
                                       echo"<td><center>".$row['PERIODO']."</center></td>";
                                       echo"<td><center>".$row['CORRELATIVO']."</center></td>";
                                       echo"<td>".$row['NOMBRECOMPLETO']."</td>";
                                       echo"<td><center>".$row['ISSS']."</center></td>";
                                       echo"<td><center>".$row['SALARIO']."</center></td>";
                                       echo"<td><center>".$row['VACACIONES']."</center></td>";
                                       echo"<td><center>".$row['PAGOSADICIONALES']."</center></td>";
                                       echo"<td><center>".$row['DIAS']."</center></td>";
                                       echo"<td><center>".$row['HORASLABORALES']."</center></td>";
                                       echo"<td><center>".$row['DIASVACACIONES']."</center></td>";
                                       echo"<td><center>".$row['CODIGOAUTORIZACION']."</center></td>";
                                  }
                                  ?>

                                  </tbody>
                                  <thead class="text-primary">
                                    <tr>
                                      <td><strong><center>NUMERO PATRONAL</center></strong></td>
                                      <td><strong><center>PERIODO</center></strong></td>
                                      <td><strong><center>CORRELATIVO</center></strong></td>
                                      <td><strong><center>NOMBRE</center></strong></td>
                                      <td><strong><center>N. ISSS</center></strong></td>
                                      <td><strong><center>SALARIO</center></strong></td>
                                      <td><strong><center>VACACIONES</center></strong></td>
                                      <td><strong><center>PAGOS ADICIONALES</center></strong></td>
                                      <td><strong><center>DIAS</center></strong></td>
                                      <td><strong><center>HORAS</center></strong></td>
                                      <td><strong><center>DIAS VACACION</center></strong></td>
                                      <td><strong><center>CODIGO AUTORIZACION</center></strong></td>
                                    </tr>
                                  </thead>
                              </table>
                          </div>

                      </div>

                      <div class="col-xs-12">
                        <center>

                      </center>

                    </div>
                    <div class="col-xs-12">

                  </div>
                </div>
            </div>
            <?php include '../../include/footer.php'; ?>
        </div>
    </div>

    <form id="frmplanilla" action="../../report/planilla/index" method="post" target="_blank" class="hidden">
      <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $_POST['FechaInic'];?>" />
      <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $_POST['FechaFin'];?>" />
      <input type="text" id="Tipo" name="Tipo" value="<?php echo $_POST['Tipo'];?>" />
    </form>
    <form id="frmboleta" action="../../report/planilla/boletaspago" method="post" target="_blank" class="hidden">
      <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $_POST['FechaInic'];?>" />
      <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $_POST['FechaFin'];?>" />
      <input type="text" id="Tipo" name="Tipo" value="<?php echo $_POST['Tipo'];?>" />
    </form>
    <form id="frmguardar" action="guardarplanilla.php" method="post"  class="hidden">
      <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $_POST['FechaInic'];?>" />
      <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $_POST['FechaFin'];?>" />
      <input type="text" id="Tipo" name="Tipo" value="<?php echo $_POST['Tipo'];?>" />
    </form>
    <form id="frmexcel" action="reporteexcel.php" method="post" target="_blank" class="hidden">
      <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $_POST['FechaInic'];?>" />
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
