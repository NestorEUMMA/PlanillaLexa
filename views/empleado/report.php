<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
require("tools/NumeroALetras.php");
require("tools/FechaALetras.php");
if(!isset($_SESSION))
    {
        session_start();
    }



$id = $model->IdEmpleado;
$queryempresa = "select
em.NombreEmpresa, em.Direccion, em.NitEmpresa, d.NombreDepartamento, em.GiroFiscal,
concat(e.PrimerNomEmpleado ,' ',e.SegunNomEmpleado,' ',e.PrimerApellEmpleado,' ',e.SegunApellEmpleado) as Nombre,
e.Genero as Sexo,
TIMESTAMPDIFF(YEAR, e.FNacimiento,CURDATE()) AS Edad,
es.DescripcionEstadoCivil as EstadoCivil,
e.Profesion as Profesion,
e.Direccion as perDireccion,
e.NumTipoDocumento as DUI,
e.DuiExpedido as Expedido,
e.DuiEl as El,
e.DuiDe as De,
e.OtrosDatos as OtrosDatos,
e.Nit as Nit
from empresa em
inner join departamentos d on em.IdDepartamentos = d.IdDepartamentos
inner join empleado e on em.IdEmpleado = e.IdEmpleado
left join estadocivil es on e.IdEstadoCivil = es.IdEstadoCivil
where em.IdEmpresa = 1";
$resultadoqueryempresa = $mysqli->query($queryempresa);
while ($test = $resultadoqueryempresa->fetch_assoc())
{
  $empresa = $test['NombreEmpresa'];
  $direccionempresa = $test['Direccion'];
  $nitempresa = $test['NitEmpresa'];
  $departamento = $test['NombreDepartamento'];
  $emnombre = $test['Nombre'];
  $emsexo = $test['Sexo'];
  $emedad = $test['Edad'];
  $emestadocivil = $test['EstadoCivil'];
  $emprofesion = $test['Profesion'];
  $emdireccion = $test['perDireccion'];
  $emdui = $test['DUI'];
  $emexpedido = $test['Expedido'];
  $emel = $test['El'];
  $emde = $test['De'];
  $emotrosdatos = $test['OtrosDatos'];
  $emnit = $test['Nit'];
  $giro = $test['GiroFiscal'];

}

$queryjornadaLaboral = "select JornadaLaboral, DiaLaboral, EntradaLaboral, SalidaLaboral from horario
where IdEmpleado = '$id'";
$resultadoqueryjornadaLaboral = $mysqli->query($queryjornadaLaboral);

$queryempleado = "select
concat(e.PrimerNomEmpleado ,' ',e.SegunNomEmpleado,' ',e.PrimerApellEmpleado,' ',e.SegunApellEmpleado) as Nombre,
e.Genero as Sexo,
TIMESTAMPDIFF(YEAR, e.FNacimiento,CURDATE()) AS Edad,
es.DescripcionEstadoCivil as EstadoCivil,
e.Profesion as Profesion,
e.Direccion as Direccion,
e.NumTipoDocumento as DUI,
e.DuiExpedido as Expedido,
e.DuiEl as El,
e.DuiDe as De,
e.OtrosDatos as OtrosDatos,
e.Nit as Nit,
e.FechaContratacion,
e.SalarioNominal as Salario,
e.HerramientasTrabajo as HerramientasTrabajo,
e.Dependiente1 as Dependiente1,
TIMESTAMPDIFF(YEAR, e.FNacimientoDep1,CURDATE()) AS Edad1,
e.Dependiente2 as Dependiente2,
TIMESTAMPDIFF(YEAR, e.FNacimientoDep2,CURDATE()) AS Edad2,
e.Dependiente3 as Dependiente3,
TIMESTAMPDIFF(YEAR, e.FNacimientoDep3,CURDATE()) AS Edad3
from empleado e
left join estadocivil es on e.IdEstadoCivil = es.IdEstadoCivil
where e.IdEmpleado = '$id'";
$resultadoqueryempleado = $mysqli->query($queryempleado);

while ($test = $resultadoqueryempleado->fetch_assoc())
{
  $nombre = $test['Nombre'];
  $sexo = $test['Sexo'];
  $edad = $test['Edad'];
  $estadocivil = $test['EstadoCivil'];
  $profesion = $test['Profesion'];
  $direccion = $test['Direccion'];
  $dui = $test['DUI'];
  $expedido = $test['Expedido'];
  $el = $test['El'];
  $de = $test['De'];
  $otrosdatos = $test['OtrosDatos'];
  $nit = $test['Nit'];
  $contratacion = $test['FechaContratacion'];
  $salario = $test['Salario'];
  $herramientas = $test['HerramientasTrabajo'];
  $Dependiente1 = $test['Dependiente1'];
  $Edad1 = $test['Edad1'];
  $Dependiente2 = $test['Dependiente2'];
  $Edad2 = $test['Edad2'];
  $Dependiente3 = $test['Dependiente3'];
  $Edad3 = $test['Edad3'];

}

$querydependientes = "select Dependiente1, FNacimientoDep1, Dependiente2,FNacimientoDep2, Dependiente3, FNacimientoDep3 from empleado
where IdEmpleado = '$id'";
$resultadoquerydependientes = $mysqli->query($querydependientes);


$dia = strftime("%d");

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


/* @var $this yii\web\View */
/* @var $model app\models\Honorario */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Empleado', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Vista Previa';
?>
</br>
<div class="row">
    <div class="col-md-12">
      <div class="ibox float-e-margins">
      <div class="ibox-title">

      </div>
      <div class="container-fluid">
          <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">mail_outline</i>
            </div>
                    <div class="card-content">
                        <h4 class="card-title">Contrato Individual de Trabajo</h4>
                        <div class="row">
                          <div class="col-xs-12">
                            <h4 class="page">
                              <center><strong><?php echo $empresa; ?></strong>
                                <center><strong>CONTRATO INDIVIDUAL DE TRABAJO</strong></center>
                                <strong><small><?php echo $direccionempresa; ?></small></strong>
                              </br><strong><small><?php echo $nitempresa; ?></small></strong>
                            </center>
                          </h4>
                        </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-xs-6 invoice-col">
                              </br>
                              <strong><center>GENERALES DE LA PERSONA TRABAJADORA</center></strong>
                              <strong><center></center></strong>
                              Nombre: <u> <?php echo $nombre; ?></u><br>
                              Sexo: <u> <?php echo $sexo; ?></u><br>
                              Edad: <u> <?php echo $edad; ?></u><br>
                              Estado Familiar: <u> <?php echo $estadocivil; ?></u><br>
                              Profesión ú Oficio: <u> <?php echo $profesion; ?></u><br>
                              Domicilio: <u> <?php echo $direccion; ?></u><br>
                              DUI: <u> <?php echo $dui; ?></u><br>
                              Expedido en: <u> <?php echo $expedido; ?></u><br>
                              El: <u> <?php echo $el; ?></u>de: <u> <?php echo $de; ?></u><br>
                              Otros datos: <u> <?php echo $otrosdatos; ?></u><br>
                              NIT: <u> <?php echo $nit; ?></u><br>
                          </div>

                          <div class="col-xs-6 invoice-col">
                            </br>
                            <address>
                              <strong><center>GENERALES DEL CONTRATANTE</center></strong>
                              <strong><center></center></strong>
                              Nombre: <u> <?php echo $emnombre; ?></u><br>
                              Sexo: <u> <?php echo $emsexo; ?></u><br>
                              Edad: <u> <?php echo $emedad; ?></u><br>
                              Estado Familiar: <u> <?php echo $emestadocivil; ?></u><br>
                              Profesión ú Oficio: <u> <?php echo $emprofesion; ?></u><br>
                              Domicilio: <u> <?php echo $emdireccion; ?></u><br>
                              DUI: <u> <?php echo $emdui; ?></u><br>
                              Expedido en: <u> <?php echo $emexpedido; ?></u><br>
                              El: <u> <?php echo $emel; ?></u>de: <u> <?php echo $emde; ?></u><br>
                              Otros datos: <u> <?php echo $emotrosdatos; ?></u><br>
                              NIT: <u> <?php echo $emnit; ?></u><br>
                              Actividad Economica <u> <?php echo $giro; ?></u><br>
                            </address>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12">
                            <p align="justify">
                              NOSOTROS <u> <?php echo $emnombre;?> </u> en representacion de: <u><?php echo $empresa; ?>, <?php echo $nombre; ?>  </u></br>
                              De las generales arriba indicadas y actuando en el carácter que aparece expresado, convenimos en celebrar  el presente Contrato Individual de Trabajo sujeto a las estipulaciones  siguientes: </br>
                              <strong>a) CLASE DE TRABAJO O SERVICIO:</strong> </br>
                              El trabajador se obliga a prestar sus servicios al patrono como: <u> <?php echo $profesion; ?>           </u></br>
                              <strong>b) DURACIÓN DEL CONTRATO Y TIEMPO DE SERVICIO:</strong> </br>
                              El presente Contrato se celebrar por: <u>Tiempo Indefinido </u>, a partir de:<u><?php echo $contratacion; ?></u>.
                              Fecha desde la cual la persona trabajadora presta servicios al patrono sin que la relación laboral se haya disuelto.</br>
                              <strong>c) LUGAR DE PRESTACIÓN DE SERVICIOS Y DE ALOJAMIENTO:</strong></br>
                              El lugar de prestación de los servicios será: <u><?php echo $direccionempresa; ?></u> y el trabajador habitará en: <u> Domicilio del empleado </u>, dado que la empresa NO le proporciona alojamiento.</br>
                              <strong>d) HORARIO DE TRABAJO:</strong>
                            </p>
                            <div class="col-xs-12">
                              <table class="table">
                                <?php
                                echo"<thead>";
                                echo"<tr>";
                                echo"<th>JORNADA LABORAL</th>";
                                echo"<th>DIA LABORAL</th>";
                                echo"<th>ENTRADA</th>";
                                echo"<th>SALIDA</th>";
                                echo"</tr>";
                                echo"</thead>";
                                echo"<tbody>";

                                while ($row = $resultadoqueryjornadaLaboral->fetch_assoc())
                                {

                                  echo"<tr>";
                                  echo"<td height='10%'>".$row['JornadaLaboral']."</td>";
                                  echo"<td height='10%'>".$row['DiaLaboral']."</td>";
                                  echo"<td height='10%'>".$row['EntradaLaboral']."</td>";
                                  echo"<td height='10%'>".$row['SalidaLaboral']."</td>";
                                  echo"</tr>";
                                  echo"</body>  ";
                                }
                                ?>
                              </table>
                            </div>
                            <p align="justify">
                              Únicamente podrán ejecutarse trabajos extraordinarios cuando sean pactados de común acuerdo entre el Patrono o Representante Legal o la persona asignada por éstos y la persona trabajadora. </br>
                              <strong>e) SALARIO: FORMA, PERÍODO Y LUGAR DEL PAGO:</strong></br>
                              El salario que recibirá la persona trabajadora, por sus servicios será la suma de: <u><?php echo $salario; ?></u>, por tiempo completo, Y se pagará en dólares de los Estados Unidos de América en: <u><?php echo $direccionempresa; ?>.</u>.
                              Dicho pago se hará de la manera siguiente: <u>Quincenal</u>. La operación del pago principiará y se continuará sin interrupción, a más tardar a la Terminación de la jornada de trabajo correspondiente a la respectiva fecha en caso de reclamo del trabajador
                              originado por dicho pago de salarios deberá resolverse a más tardar dentro de los tres días hábiles siguientes.</br>
                              <strong>f) HERRAMIENTAS Y MATERIALES:</strong></br>
                              El patrono suministrará a la persona trabajadora las herramientas y materiales siguientes: <u><?php echo $herramientas; ?></u> Que se entregan en: <u><?php echo $direccionempresa; ?></u>,  y  deben  ser  devueltos  así  por  la persona trabajadora (Estado y calidad) cuando sean requeridas al efecto por su jefe inmediato, salvo la disminución o deterioro causados por caso fortuito o fuerza mayor, o por la acción del tiempo o  por  el consumo y uso normal de los mismos.
                            </br>
                            <strong>g) PERSONAS QUE DEPENDEN ECONÓMICAMENTE DE LA PERSONA TRABAJADORA: </strong></br>
                            Nombre:<u><?php echo $Dependiente1;?></u>, Edad:<u><?php echo $Edad1;?></u>, Direc:<u><?php echo $direccion;?></u></br>
                            Nombre:<u><?php echo $Dependiente2;?></u>, Edad:<u><?php echo $Edad2;?></u>, Direc:<u><?php echo $direccion;?></u></br>
                            Nombre:<u><?php echo $Dependiente3;?></u>, Edad:<u><?php echo $Edad3;?></u>, Direc:<u><?php echo $direccion;?></u></br>
                            <strong>h) OTRAS ESTIPULACIONES:</strong></br>
                            <strong>i)</strong> En el presente Contrato Individual de Trabajo se entenderán  incluidos, según el caso, los derechos y deberes laborales establecidos por las Leyes y Reglamentos, por el Reglamento Interno de Trabajo  y por el o los Contratos Colectivos de Trabajo que celebre el patrono; los reconocidos en las sentencias que resuelvan conflictos colectivos de trabajo en la  empresa, y los consagrados por la costumbre.</br>
                            <strong>j)</strong> Este contrato sustituye cualquier otro Convenio Individual de Trabajo anterior, ya sea escrito o verbal, que haya estado  vigente entre el patrono y la persona trabajadora, pero  no altera en manera alguna los derechos y prerrogativas del trabajador que  emanen de su antigüedad en el servicio, ni se entenderá como negativa de mejores condiciones  concedidas a la persona trabajadora en  el Contrato anterior y que no consten en el presente.</br>
                            En fe de lo cual firmamos el presente documento por triplicado en:<u><?php echo $departamento;?></u>, a los <u><?php echo $dia;?></u> dias del mes <u><?php echo $mes;?></u> de <u><?php echo $anio;?></u></br></br></br>
                          </p>


                        </div>
                        </div>
                        <div class="row invoice-info">
                          <div class="col-xs-6 invoice-col">
                            </br>
                            <strong><center>(F)_________________________</center></strong>
                            <strong><center>PATRONO O REPRESENTANTE</center></strong>
                          </div>

                          <div class="col-xs-6 invoice-col">
                            </br>
                            <address>
                              <strong><center>(F)_________________________</center></strong>
                              <strong><center>TRABAJADOR(A)</center></strong></br></br></br>
                              <strong><center>(F)_________________________</center></strong>
                              <strong><center>A RUEGO DEL TRABAJADOR(A)</center></strong>
                            </address>
                          </div>
                        </div>
                    </div>

            <div class="col-xs-12">
              <center>
                <a href="../empleado/index" class="btn btn-warning"></i> REGRESAR</a>
              <button class="btn btn-success btn-raised btn-exp" onclick="javascript:window.imprimirDIV('ID_DIV');">Imprimir </button>
            </center>
          </div>
          </div>
      </div>
        <div id="ID_DIV" class="hidden">
          </br></br>
                      <div class="row">
                        <div class="col-xs-12">
                          <h4 class="page">
                            <center><strong><?php echo $empresa; ?></strong>
                              <center><strong>CONTRATO INDIVIDUAL DE TRABAJO</strong></center>
                              <strong><small><?php echo $direccionempresa; ?></small></strong>
                            </br><strong><small><?php echo $nitempresa; ?></small></strong>
                          </center>
                        </h4>
                      </div>
                      </div>
                      <div class="row invoice-info">
                          <div class="col-xs-6 invoice-col">
                            </br>
                            <strong><center>GENERALES DE LA PERSONA TRABAJADORA</center></strong>
                            <strong><center></center></strong>
                            Nombre: <u> <?php echo $nombre; ?></u><br>
                            Sexo: <u> <?php echo $sexo; ?></u><br>
                            Edad: <u> <?php echo $edad; ?></u><br>
                            Estado Familiar: <u> <?php echo $estadocivil; ?></u><br>
                            Profesión ú Oficio: <u> <?php echo $profesion; ?></u><br>
                            Domicilio: <u> <?php echo $direccion; ?></u><br>
                            DUI: <u> <?php echo $dui; ?></u><br>
                            Expedido en: <u> <?php echo $expedido; ?></u><br>
                            El: <u> <?php echo $el; ?></u>de: <u> <?php echo $de; ?></u><br>
                            Otros datos: <u> <?php echo $otrosdatos; ?></u><br>
                            NIT: <u> <?php echo $nit; ?></u><br>
                        </div>

                        <div class="col-xs-6 invoice-col">
                          </br>
                          <address>
                            <strong><center>GENERALES DEL CONTRATANTE</center></strong>
                            <strong><center></center></strong>
                            Nombre: <u> <?php echo $emnombre; ?></u><br>
                            Sexo: <u> <?php echo $emsexo; ?></u><br>
                            Edad: <u> <?php echo $emedad; ?></u><br>
                            Estado Familiar: <u> <?php echo $emestadocivil; ?></u><br>
                            Profesión ú Oficio: <u> <?php echo $emprofesion; ?></u><br>
                            Domicilio: <u> <?php echo $emdireccion; ?></u><br>
                            DUI: <u> <?php echo $emdui; ?></u><br>
                            Expedido en: <u> <?php echo $emexpedido; ?></u><br>
                            El: <u> <?php echo $emel; ?></u>de: <u> <?php echo $emde; ?></u><br>
                            Otros datos: <u> <?php echo $emotrosdatos; ?></u><br>
                            NIT: <u> <?php echo $emnit; ?></u><br>
                            Actividad Economica <u> <?php echo $giro; ?></u><br>
                          </address>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12">
                          <p align="justify">
                            NOSOTROS <u> <?php echo $emnombre;?> </u> en representacion de: <u><?php echo $empresa; ?>, <?php echo $nombre; ?>  </u></br>
                            De las generales arriba indicadas y actuando en el carácter que aparece expresado, convenimos en celebrar  el presente Contrato Individual de Trabajo sujeto a las estipulaciones  siguientes: </br>
                            <strong>a) CLASE DE TRABAJO O SERVICIO:</strong> </br>
                            El trabajador se obliga a prestar sus servicios al patrono como: <u> <?php echo $profesion; ?>           </u></br>
                            <strong>b) DURACIÓN DEL CONTRATO Y TIEMPO DE SERVICIO:</strong> </br>
                            El presente Contrato se celebrar por: <u>Tiempo Indefinido </u>, a partir de:<u><?php echo $contratacion; ?></u>.
                            Fecha desde la cual la persona trabajadora presta servicios al patrono sin que la relación laboral se haya disuelto.</br>
                            <strong>c) LUGAR DE PRESTACIÓN DE SERVICIOS Y DE ALOJAMIENTO:</strong></br>
                            El lugar de prestación de los servicios será: <u><?php echo $direccionempresa; ?></u> y el trabajador habitará en: <u> Domicilio del empleado </u>, dado que la empresa NO le proporciona alojamiento.</br>
                            <strong>d) HORARIO DE TRABAJO:</strong>
                          </p>
                          <div class="col-xs-12">
                            <table class="table">
                              <?php
                              echo"<thead>";
                              echo"<tr>";
                              echo"<th>JORNADA LABORAL</th>";
                              echo"<th>DIA LABORAL</th>";
                              echo"<th>ENTRADA</th>";
                              echo"<th>SALIDA</th>";
                              echo"</tr>";
                              echo"</thead>";
                              echo"<tbody>";

                              while ($row = $resultadoqueryjornadaLaboral->fetch_assoc())
                              {

                                echo"<tr>";
                                echo"<td height='10%'>".$row['JornadaLaboral']."</td>";
                                echo"<td height='10%'>".$row['DiaLaboral']."</td>";
                                echo"<td height='10%'>".$row['EntradaLaboral']."</td>";
                                echo"<td height='10%'>".$row['SalidaLaboral']."</td>";
                                echo"</tr>";
                                echo"</body>  ";
                              }
                              ?>
                            </table>
                          </div>
                          <p align="justify">
                            Únicamente podrán ejecutarse trabajos extraordinarios cuando sean pactados de común acuerdo entre el Patrono o Representante Legal o la persona asignada por éstos y la persona trabajadora. </br>
                            <strong>e) SALARIO: FORMA, PERÍODO Y LUGAR DEL PAGO:</strong></br>
                            El salario que recibirá la persona trabajadora, por sus servicios será la suma de: <u><?php echo $salario; ?></u>, por tiempo completo, Y se pagará en dólares de los Estados Unidos de América en: <u><?php echo $direccionempresa; ?>.</u>.
                            Dicho pago se hará de la manera siguiente: <u>Quincenal</u>. La operación del pago principiará y se continuará sin interrupción, a más tardar a la Terminación de la jornada de trabajo correspondiente a la respectiva fecha en caso de reclamo del trabajador
                            originado por dicho pago de salarios deberá resolverse a más tardar dentro de los tres días hábiles siguientes.</br>
                            <strong>f) HERRAMIENTAS Y MATERIALES:</strong></br>
                            El patrono suministrará a la persona trabajadora las herramientas y materiales siguientes: <u><?php echo $herramientas; ?></u> Que se entregan en: <u><?php echo $direccionempresa; ?></u>,  y  deben  ser  devueltos  así  por  la persona trabajadora (Estado y calidad) cuando sean requeridas al efecto por su jefe inmediato, salvo la disminución o deterioro causados por caso fortuito o fuerza mayor, o por la acción del tiempo o  por  el consumo y uso normal de los mismos.
                          </br>
                          <strong>g) PERSONAS QUE DEPENDEN ECONÓMICAMENTE DE LA PERSONA TRABAJADORA: </strong></br>
                          Nombre:<u><?php echo $Dependiente1;?></u>, Edad:<u><?php echo $Edad1;?></u>, Direc:<u><?php echo $direccion;?></u></br>
                          Nombre:<u><?php echo $Dependiente2;?></u>, Edad:<u><?php echo $Edad2;?></u>, Direc:<u><?php echo $direccion;?></u></br>
                          Nombre:<u><?php echo $Dependiente3;?></u>, Edad:<u><?php echo $Edad3;?></u>, Direc:<u><?php echo $direccion;?></u></br>
                          <strong>h) OTRAS ESTIPULACIONES:</strong></br>
                          <strong>i)</strong> En el presente Contrato Individual de Trabajo se entenderán  incluidos, según el caso, los derechos y deberes laborales establecidos por las Leyes y Reglamentos, por el Reglamento Interno de Trabajo  y por el o los Contratos Colectivos de Trabajo que celebre el patrono; los reconocidos en las sentencias que resuelvan conflictos colectivos de trabajo en la  empresa, y los consagrados por la costumbre.</br>
                          <strong>j)</strong> Este contrato sustituye cualquier otro Convenio Individual de Trabajo anterior, ya sea escrito o verbal, que haya estado  vigente entre el patrono y la persona trabajadora, pero  no altera en manera alguna los derechos y prerrogativas del trabajador que  emanen de su antigüedad en el servicio, ni se entenderá como negativa de mejores condiciones  concedidas a la persona trabajadora en  el Contrato anterior y que no consten en el presente.</br>
                          En fe de lo cual firmamos el presente documento por triplicado en:<u><?php echo $departamento;?></u>, a los <u><?php echo $dia;?></u> dias del mes <u><?php echo $mes;?></u> de <u><?php echo $anio;?></u></br></br></br>
                        </p>


                      </div>
                      </div>
                      <div class="row invoice-info">
                        <div class="col-xs-6 invoice-col">
                          </br>
                          <strong><center>(F)_________________________</center></strong>
                          <strong><center>PATRONO O REPRESENTANTE</center></strong>
                        </div>

                        <div class="col-xs-6 invoice-col">
                          </br>
                          <address>
                            <strong><center>(F)_________________________</center></strong>
                            <strong><center>TRABAJADOR(A)</center></strong></br></br></br>
                            <strong><center>(F)_________________________</center></strong>
                            <strong><center>A RUEGO DEL TRABAJADOR(A)</center></strong>
                          </address>
                        </div>
                      </div>


          </div>


      </div>
    </div>
</div>
<script>
  function imprimirDIV(contenido) {
       var getpanel = document.getElementById(contenido);
       var MainWindow = window.open(' ', 'popUp');
       MainWindow.document.write('<html><head><title></title>');
       MainWindow.document.write("<link rel=\"stylesheet\" href=\"../assets/css/bootstrap.min.css\" type=\"text/css\"/>");
       MainWindow.document.write('</head><body onload="window.print();window.close()">');
       MainWindow.document.write(getpanel.innerHTML);
       MainWindow.document.write('</body></html>');
       MainWindow.document.close();
       setTimeout(function () {
           MainWindow.print();
       }, 500)
        return false;
      }
</script>
