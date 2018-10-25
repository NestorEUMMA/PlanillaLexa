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
$id =$_REQUEST['Empleado'];
$fecharenuncia =$_REQUEST['Fecharenuncia'];

require("../../report/NumeroALetras.php");
require("../../report/FechaALetras.php");

$mes = strftime("%B");
    if($mes == 'January'){
        $mes = 'ENERO';
    }
    elseif($mes == 'February'){
        $mes = 'FEBRERO';
    }
    elseif($mes == 'March'){
        $mes = 'MARZO';
    }
    elseif($mes == 'April'){
        $mes = 'ABRIL';
    }
    elseif($mes == 'May'){
        $mes = 'MAYO';
    }
    elseif($mes == 'June'){
        $mes = 'JUNIO';
    }
    elseif($mes == 'July'){
        $mes = 'JULIO';
    }
    elseif($mes == 'August'){
        $mes = 'AGOSTO';
    }
    elseif($mes == 'September'){
        $mes = 'SEPTIEMBRE';
    }
    elseif($mes == 'October'){
        $mes = 'OCTUBRE';
    }
    elseif($mes == 'November'){
        $mes = 'NOVIEMBRE';
    }
    else{
        $mes = 'DICIEMBRE';
    }

$anio = date("Y");

$dias = strftime("%d");
$dia = strftime("%A");
if($dia == 'Monday'){
    $dia = 'Lunes';
}
elseif($dia == 'Tuesday'){
    $dia = 'Martes';
}
elseif($dia == 'Wednesday'){
    $dia = 'Miercoles';
}
elseif($dia == 'Thursday'){
    $dia = 'Jueves';
}
elseif($dia == 'Friday'){
    $dia = 'Viernes';
}
elseif($dia == 'Saturday'){
    $dia = 'Sabado';
}
else{
    $dia = 'Domingo';
}

$queryhorasextras = "SELECT e.IdEmpleado, e.FechaContratacion,e.FechaDespido, e.EmpleadoActivo,
CONCAT(e.PrimerNomEmpleado,' ', e.SegunNomEmpleado,' ',e.PrimerApellEmpleado,' ',e.SegunApellEmpleado) as 'NombreCompleto',
e.Nit, e.NumTipoDocumento, e.NIsss, e.Nup, TIMESTAMPDIFF(YEAR, e.FNacimiento,CURDATE()) AS Edad, mu.DescripcionMunicipios as 'Municipios', pe.DescripcionPuestoEmpresa as 'Puesto', e.SalarioNominal as 'Salario'
from empleado e
inner join departamentos de on de.IdDepartamentos = e.IdDepartamentos
inner join municipios mu on mu.IdMunicipios = e.IdDepartamentos
inner join puestoempresa pe on e.IdPuestoEmpresa = pe.IdPuestoEmpresa
WHERE e.IdEmpleado = '$id'";
$resultadoqueryhorasextras = $mysqli->query($queryhorasextras);
while ($test = $resultadoqueryhorasextras->fetch_assoc())
          {
              $IdEmpleado = $test['IdEmpleado'];
              $nombre = $test['NombreCompleto'];
              $nit = $test['Nit'];
              $isss = $test['NIsss'];
              $dui = $test['NumTipoDocumento'];
              $nup = $test['Nup'];
              $municipios = $test['Municipios'];
              $contratacion = $test['FechaContratacion'];
              $edad = $test['Edad'];
              $puestoempresa = $test['Puesto'];
              $salario = $test['Salario'];
          }



$queryempresa = "SELECT e.NombreEmpresa, e.Direccion, e.NitEmpresa, d.NombreDepartamento, e.NrcEmpresa, CONCAT(em.PrimerNomEmpleado,' ', em.SegunNomEmpleado,' ',em.PrimerApellEmpleado,' ',em.SegunApellEmpleado) as 'repersentante'
                from empresa e
                inner join departamentos d on e.IdDepartamentos = d.IdDepartamentos
                inner join empleado em on em.IdEmpleado = e.IdEmpleado
                where IdEmpresa = 1";
$resultadoqueryempresa = $mysqli->query($queryempresa);

while ($test = $resultadoqueryempresa->fetch_assoc())
           {
               $empresa = $test['NombreEmpresa'];
               $direccion = $test['Direccion'];
               $nitempresa = $test['NitEmpresa'];
               $departamento = $test['NombreDepartamento'];
               $nrc = $test['NrcEmpresa'];
               $representante = $test['repersentante'];

           }

  $dia = strftime("%d");
  $anhio = date("Y");


  $diasss = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
  $fechare = $diasss[date('N', strtotime($fecharenuncia))];

$aniorenuncia = date("Y", strtotime($fecharenuncia));
$diarenuncia = date("d", strtotime($fecharenuncia));

$mesrenuncia = date("m", strtotime($fecharenuncia));
    if($mesrenuncia == '01'){
        $mesrenuncia = 'ENERO';
    }
    elseif($mesrenuncia == '02'){
        $mesrenuncia = 'FEBRERO';
    }
    elseif($mesrenuncia == '03'){
        $mesrenuncia = 'MARZO';
    }
    elseif($mesrenuncia == '04'){
        $mesrenuncia = 'ABRIL';
    }
    elseif($mesrenuncia == '05'){
        $mesrenuncia = 'MAYO';
    }
    elseif($mesrenuncia == '06'){
        $mesrenuncia = 'JUNIO';
    }
    elseif($mesrenuncia == '07'){
        $mesrenuncia = 'JULIO';
    }
    elseif($mesrenuncia == '08'){
        $mesrenuncia = 'AGOSTO';
    }
    elseif($mesrenuncia == '09'){
        $mesrenuncia = 'SEPTIEMBRE';
    }
    elseif($mesrenuncia == '10'){
        $mesrenuncia = 'OCTUBRE';
    }
    elseif($mes == '11'){
        $mesrenuncia = 'NOVIEMBRE';
    }
    else{
        $mesrenuncia = 'DICIEMBRE';
    }

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/lexa.PNG" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Carta de Renuncia</title>
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
                          <h4 class="card-title">Vista Previa de Carta de Renuncia</h4>
                    <center>
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">

                        <p align="right"><strong> SAN SALVADOR, <?php echo $dia; ?> DE <?php echo strtoupper($mes);?> DE <?php echo $anio;?></strong><p><br><br>
                        <p align="left">
                          <STRONG>SEÑORES<br>
                          <?php echo $empresa; ?>
                          <br><br>
                          ATENCION: <?php echo $representante; ?> - REPRESENTANTE LEGAL </STRONG><br><br>
                        </p>
                        <p align="justify">
                          Yo, <STRONG><?php echo $nombre; ?></STRONG>, de <?php echo $edad; ?> años de edad, del domicilio de <?php echo $municipios; ?> , con Documento
                          Único de Identidad Número <?php echo $dui; ?>, con Número de Identificación Tributaria <?php echo $nit; ?>, Por medio del presente
                          instrumento <STRONG> MANIFIESTO: I)</STRONG> Que por este medio <STRONG>Presento mi Renuncia Voluntaria, el día <?php echo $fechare; ?> <?php echo $diarenuncia; ?>
                          de <?php echo $mesrenuncia; ?> de <?php echo $aniorenuncia; ?></STRONG>, presente por escrito que haría efectiva mi renuncia voluntaria al cargo de <?php echo $puestoempresa; ?>
                          , que vengo desempeñando desde el día <?php echo strtoupper(obtenerFechaEnLetra($contratacion));?>, devengando un salario de <?php echo $salario = NumeroALetras::convertir($salario, 'DOLARES', 'CENTAVOS');?>
                          (<?php echo $salario; ?>) renuncia que, sería efectiva el día <?php echo strtoupper(obtenerFechaEnLetra($fecharenuncia));?>; <STRONG>II)</STRONG> Que siendo este el día en que debo hacer efectiva mi renuncia,
                          mediante el presente instrumento, interpongo formalmente la <STRONG>RENUNCIA VOLUNTARIA E IRREVOCABLE</STRONG> al cargo descrito en el numeral anterior, razón por la cual declaro terminada voluntariamente la
                          relación laboral que me vinculaba con la sociedad <?php echo $empresa; ?> <STRONG>III)</STRONG> Declaro que la referida sociedad no me adeuda ninguna cantidad en concepto de salarios, horas extras, nocturnidades,
                          todo con sus respectivos recargos, aguinaldos y vacaciones, completos o proporcionales, así como la totalidad de las prestaciones que me corresponden derivados de la relación laboral que mediante la presente renuncia
                          voluntaria e irrevocable, se da por terminada, razón por la cual <STRONG>DECLARO LIBRE Y SOLVENTE</STRONG> de toda obligación a la sociedad, <?php echo $empresa; ?> <STRONG>EXONERÁNDOLA</STRONG> de cualquier reclamación presente o futura,
                          de la naturaleza que fuere, derivada de la relación laboral que doy por terminada en este acto. En fe de lo cual, firmo el presente documento, en la ciudad de <?php echo $municipios; ?>, a los <?php echo $dia; ?> dias del mes de <?php echo strtoupper($mes);?>
                          del año <?php echo $anio = NumeroALetras::convertir($anio);?>
                      </p>
                      <p align="center">
                        <STRONG>
                          <br>
                          <?php echo $nombre; ?><br>
                          DUI: <?php echo $dui; ?><br>
                          NIT: <?php echo $nit; ?>
                        </STRONG>
                      </p>
                      <p align="justify">
                        <br>
                        En la ciudad de San Salvador, a las Doce horas del día <?php echo strtoupper(obtenerFechaEnLetra($fecharenuncia));?>. Ante mi, comparece el señor <?php echo $nombre; ?></STRONG> quien es de <?php echo $edad; ?> años de edad, EMPLEADO,
                        del domicilio de <?php echo $municipios; ?>, a quien hasta hoy conozco e identifico por medio de su Documento Único de Identidad Número <?php echo $dui; ?>, con Número de Identificación Tributaria <?php echo $nit; ?>, y <STRONG>ME DICE:</STRONG>
                        Que reconoce como suya la firma que calza al pie del anterior documento privado fechado este mismo día y que presenta para su debida autenticación, mediante el cual literalmente EXPRESA: “ “ “<STRONG>I)</STRONG>  Su Renuncia Voluntaria, el día
                        <?php echo strtoupper(obtenerFechaEnLetra($fecharenuncia));?>, presente por escrito, que haría efectiva mi renuncia voluntaria al cargo de <?php echo $puestoempresa; ?> que vengo desempeñando desde el día <?php echo strtoupper(obtenerFechaEnLetra($contratacion));?>
                        devengando un salario de <?php echo $salario = NumeroALetras::convertir($salario, 'DOLARES', 'CENTAVOS');?>, renuncia que, sería efectiva el día <?php echo strtoupper(obtenerFechaEnLetra($fecharenuncia));?>; <STRONG>II)</STRONG> Que siendo este el día en que debo hacer
                        efectiva mi renuncia,  interpongo formalmente la <STRONG>RENUNCIA VOLUNTARIA E IRREVOCABLE</STRONG> al cargo descrito en el numeral anterior, razón por la cual declaro terminada voluntariamente la relación laboral que me vinculaba con la sociedad <?php echo $empresa; ?>
                        <STRONG>III)</STRONG> Declaro que la referida sociedad no me adeuda ninguna cantidad en concepto de salarios, horas extras, nocturnidades,
                        todo con sus respectivos recargos, aguinaldos y vacaciones, completos o proporcionales, así como la totalidad de las prestaciones que me corresponden derivados de la relación laboral que mediante la presente renuncia
                        voluntaria e irrevocable, se da por terminada, razón por la cual <STRONG>DECLARO LIBRE Y SOLVENTE</STRONG> de toda obligación a la sociedad, <?php echo $empresa; ?> <STRONG>EXONERÁNDOLA</STRONG> de cualquier reclamación presente o futura,
                        de la naturaleza que fuere, derivada de la relación laboral que doy por terminada en este acto.” ” ” <STRONG> DOY FE</STRONG> que la firma del compareciente es auténtica, por haber sido puesta a mi presencia de su puño y letra. Así se expresó el compareciente, a quien explique los efectos legales
                        de la presente acta que consta de una hoja útil. Leído que le fue el presente instrumento, en un solo acto sin interrupción, manifiesta su conformidad por estar redactado acorde a su voluntad, ratifica su contenido y para constancia firmamos. <STRONG>DOY FE.</STRONG>
                    </p>
                    <p align="center">
                      <STRONG>
                        <br>
                        <?php echo $nombre; ?><br>
                        DUI: <?php echo $dui; ?><br>
                        NIT: <?php echo $nit; ?>
                      </STRONG>
                    </p>
                      </div>
                      </div>
                    </center>

                      </div>

                      <div class="col-xs-12">
                        <center>
                          <a href="../cartarenuncia/index" class="btn btn-warning"></i> REGRESAR</a>
                          <button class="btn btn-success btn-raised btn-imprimir">
                                   IMPRIMIR CARTA
                          </button>
                      </center>
                    </div>

                    </div>
                </div>
            </div>
            <?php include '../../include/footer.php'; ?>
        </div>
    </div>
    <form id="frmimprimir" action="../../report/cartarenuncia/index" method="post" target="_blank" class="hidden">
      <input type="text" id="Empleado" name="Empleado" value='<?php echo $id; ?>' />
      <input type="text" id="Fecharenuncia" name="Fecharenuncia" value='<?php echo $fecharenuncia; ?>' />
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
            $("#frmimprimir").submit();
            //alert(id);
        });
        // $(".btn-boleta").click(function(){
        //     // var id = $(this).attr("value");
        //     // $("#IdIndemnizacion").val(id);
        //     $("#frmboleta").submit();
        //     //alert(id);
        // });
        // $(".btn-guardar").click(function(){
        //     // var id = $(this).attr("value");
        //     // $("#IdIndemnizacion").val(id);
        //     $("#frmguardar").submit();
        //     //alert(id);
        // });
        // $(".btn-excel").click(function(){
        //     // var id = $(this).attr("value");
        //     // $("#IdIndemnizacion").val(id);
        //     $("#frmexcel").submit();
        //     //alert(id);
        // });
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
