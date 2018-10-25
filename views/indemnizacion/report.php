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



$id = $model->IdIndemnizacion;

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

$queryhorasextras = "SELECT e.IdEmpleado,i.AnoPeriodoIndem, i.MesPeriodoIndem, i.FechaIndemnizacion, i.MontoIndemnizacion,
e.FechaContratacion,e.FechaDespido, e.EmpleadoActivo, CONCAT(e.PrimerNomEmpleado,' ', e.SegunNomEmpleado,' ',e.PrimerApellEmpleado,' ',e.SegunApellEmpleado) as 'NombreCompleto', e.Nit, e.NumTipoDocumento, e.NIsss, e.Nup
from indemnizacion i
INNER JOIN empleado e on i.IdEmpleado = e.IdEmpleado
WHERE i.IdIndemnizacion = '$id'";
$resultadoqueryhorasextras = $mysqli->query($queryhorasextras);
while ($test = $resultadoqueryhorasextras->fetch_assoc())
          {
              $IdEmpleado = $test['IdEmpleado'];
              $fecha = $test['FechaIndemnizacion'];
              $periodo = $test['AnoPeriodoIndem'];
              $nombre = $test['NombreCompleto'];
              $nit = $test['Nit'];
              $isss = $test['NIsss'];
              $dui = $test['NumTipoDocumento'];
              $nup = $test['Nup'];
              $mes = $test['MesPeriodoIndem'];
              $pagar = $test['MontoIndemnizacion'];
              $contratacion = $test['FechaContratacion'];
              $despido = $test['FechaDespido'];

          }

    $n = $pagar;
    $aux = (string) $n;
    $decimal = substr( $aux, strpos( $aux, "." ) );
    $centavos = str_replace('.',"", $decimal );



$queryempresa = "select e.NombreEmpresa, e.Direccion, e.NitEmpresa, d.NombreDepartamento, e.NrcEmpresa
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
               $nrc = $test['NrcEmpresa'];

           }

$querynrc = "select e.NrcEmpresa
                           from empresa e
                           inner join departamentos d on e.IdDepartamentos = d.IdDepartamentos
                           where IdEmpresa = 1";
$resultadoquerynrc = $mysqli->query($querynrc);


           while ($test = $resultadoquerynrc->fetch_assoc())
                      {

                          $nrcc = $test['NrcEmpresa'];

                      }

  $dia = strftime("%d");
  $anhio = date("Y");

  $UltimaMontoVac = 'SELECT MontoVacaciones FROM vacaciones WHERE IdEmpleado = '.$IdEmpleado.' ORDER BY IdVacaciones DESC LIMIT 1';
  $SQL = $mysqli->query($UltimaMontoVac);
  $ResultadoParametro = mysqli_fetch_row($SQL);
  $UltimaMontoVacacion = $ResultadoParametro[0];

  $UltimaAgui = 'SELECT MontoAguinaldo FROM aguinaldos WHERE IdEmpleado = '.$IdEmpleado.' ORDER BY IdAguinaldo DESC LIMIT 1';
  $SQL = $mysqli->query($UltimaAgui);
  $ResultadoParametro = mysqli_fetch_row($SQL);
  $UltimaMontoAguinaldo = $ResultadoParametro[0];

  $TotalIndemnizacion = $pagar + $UltimaMontoVacacion + $UltimaMontoAguinaldo;


/* @var $this yii\web\View */
/* @var $model app\models\Honorario */

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Indemnizacion', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Vista Previa';
?>
</br>
<div class="row">
    <<div class="col-md-12">
    <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">mail_outline</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Vista Previa de Finiquito</h4>
          <center>
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">

              <center> EN SAN SALVADOR, A LOS <?php echo $dias = NumeroALetras::convertir($dia); ?> DÍAS DEL MES DE <?php echo strtoupper($mes);?> DE <?php echo $anios = NumeroALetras::convertir($anio);?>.<center><br><br>
              <p align="justify">
                EL EMPLEADO <?php echo strtoupper($nombre);?>, CON DOCUMENTO ÚNICO DE
                IDENTIDAD NÚMERO CERO <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[1]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[2]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[3]); ?>
                <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[4]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[5]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[6]); ?>
                <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[7]); ?> GUION <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[8]); ?>,
                NÚMERO DE IDENTIFICACIÓN TRIBUTARIA
                <?php if($nit[0] > 0){$NumNIT = NumeroALetras::convertir($nit[0]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[1] > 0){$NumNIT = NumeroALetras::convertir($nit[1]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[2] > 0){$NumNIT = NumeroALetras::convertir($nit[2]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[3] > 0){$NumNIT = NumeroALetras::convertir($nit[3]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                GUION
                <?php if($nit[5] > 0){$NumNIT = NumeroALetras::convertir($nit[5]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[6] > 0){$NumNIT = NumeroALetras::convertir($nit[6]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[7] > 0){$NumNIT = NumeroALetras::convertir($nit[7]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[8] > 0){$NumNIT = NumeroALetras::convertir($nit[8]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[9] > 0){$NumNIT = NumeroALetras::convertir($nit[9]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[10] > 0){$NumNIT = NumeroALetras::convertir($nit[10]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                GUION
                <?php if($nit[12] > 0){$NumNIT = NumeroALetras::convertir($nit[12]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[13] > 0){$NumNIT = NumeroALetras::convertir($nit[13]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                <?php if($nit[14] > 0){$NumNIT = NumeroALetras::convertir($nit[14]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
                GUION
                <?php if($nit[15] > 0){$NumNIT = NumeroALetras::convertir($nit[15]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>,
                NÚMERO DE AFILIACIÓN AL SEGURO SOCIAL
                <?php if($isss[0] > 0){$NumISSS = NumeroALetras::convertir($isss[0]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[1] > 0){$NumISSS = NumeroALetras::convertir($isss[1]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[2] > 0){$NumISSS = NumeroALetras::convertir($isss[2]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[3] > 0){$NumISSS = NumeroALetras::convertir($isss[3]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[4] > 0){$NumISSS = NumeroALetras::convertir($isss[4]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[5] > 0){$NumISSS = NumeroALetras::convertir($isss[5]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[6] > 0){$NumISSS = NumeroALetras::convertir($isss[6]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[7] > 0){$NumISSS = NumeroALetras::convertir($isss[7]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                <?php if($isss[8] > 0){$NumISSS = NumeroALetras::convertir($isss[8]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
                Y NÚMERO ÚNICO PREVISIONAL
                <?php if($nup[0] > 0){$NumNup = NumeroALetras::convertir($nup[0]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[1] > 0){$NumNup = NumeroALetras::convertir($nup[1]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[2] > 0){$NumNup = NumeroALetras::convertir($nup[2]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[3] > 0){$NumNup = NumeroALetras::convertir($nup[3]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[4] > 0){$NumNup = NumeroALetras::convertir($nup[4]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[5] > 0){$NumNup = NumeroALetras::convertir($nup[5]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[6] > 0){$NumNup = NumeroALetras::convertir($nup[6]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[7] > 0){$NumNup = NumeroALetras::convertir($nup[7]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[8] > 0){$NumNup = NumeroALetras::convertir($nup[8]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[9] > 0){$NumNup = NumeroALetras::convertir($nup[9]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[10] > 0){$NumNup = NumeroALetras::convertir($nup[10]);}else{$NumNup = 'CERO';}echo $NumNup;?>
                <?php if($nup[11] > 0){$NumNup = NumeroALetras::convertir($nup[11]);}else{$NumNup = 'CERO';}echo $NumNup;?>,
                ACEPTA LA TERMINACIÓN DE CONTRATO DE TRABAJO COLECTIVO QUE MANTIENE CON
                LA SOCIEDAD <?php echo $empresa;?> LA CUAL SE IDENTIFICA POR SU NÚMERO DE
                IDENTIFICACIÓN TRIBUTARIA
                <?php if($nitempresa[0] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[0]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[1] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[1]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[2] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[2]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[3] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[3]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                GUION
                <?php if($nitempresa[5] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[5]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[6] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[6]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[7] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[7]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[8] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[8]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[9] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[9]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[10] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[10]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                GUION
                <?php if($nitempresa[12] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[12]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[13] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[13]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                <?php if($nitempresa[14] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[14]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                GUION
                <?php if($nitempresa[15] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[15]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
                Y SU NUMERO DE REGISTRO DE CONTRIBUYENTE

                <?php
                    $cantidad = strlen($nrc);
                    for ($i=0;$i<$cantidad;$i++) {
                      if($nrc[$i] > 0){$NumNup = NumeroALetras::convertir($nrc[$i]);}elseif($nrc[$i] = '-'){$NumNup = 'GUION ';}else{$NumNup = 'CERO ';}echo $NumNup;
                    }
                ?>,
                EL CUAL MANTUVO EN UN RANGO DE FECHAS QUE INICIA DESDE EL DIA <?php echo strtoupper(obtenerFechaEnLetra($contratacion));?> Y FINALIZA EL DIA
                <?php echo strtoupper(obtenerFechaEnLetra($despido));?>. EL EMPLEADO ACEPTA LA CANTIDAD DE <?php echo $MontVaca = NumeroALetras::convertir($UltimaMontoVacacion, 'DOLARES', 'CENTAVOS');?>, EN CONCEPTO DE VACACIONES PROPORCIONALES,
                <?php echo $MontVaca = NumeroALetras::convertir($UltimaMontoAguinaldo, 'DOLARES', 'CENTAVOS');?> EN CONCEPTO DE AGUINALDO PROPORCIONAL Y, <?php echo $MontVaca = NumeroALetras::convertir($pagar, 'DOLARES', 'CENTAVOS');?> EN CONCEPTO DE INDEMNIZACIÓN,
                PERCEPCIONES LAS CUALES SUMAN UNA CANTIDAD DE <?php echo $TotalIndemnizacion = NumeroALetras::convertir($TotalIndemnizacion, 'DOLARES', 'CENTAVOS');?>. EL SEÑOR <?php echo strtoupper($nombre);?> ACEPTA LAS PERCEPCIONES Y DEDUCCIONES ANTES MENCIONADAS Y LIBERA DE
                TODA RESPONSABILIDAD LABORAL Y MERCANTIL A LA SOCIEDAD <?php echo strtoupper($empresa);?><br><br>

                Y PARA LO QUE LOS INTERESADOS ESTIMEN CONVENIENTE, SE EXTIENDE Y FIRMA EL MÁS AMPLIO <strong>FINIQUITO</strong> A LOS <?php echo $dias = NumeroALetras::convertir($dia); ?> DÍAS DEL MES DE <?php echo strtoupper($mes);?> DE <?php echo $anios = NumeroALetras::convertir($anio);?>.


            </p>

            </div>
            </div>

          </center>

            </div>

            <div class="col-xs-12">
              <center>
                <a href="../indemnizacion/index" class="btn btn-warning"></i> REGRESAR</a>
              <button class="btn btn-success btn-raised btn-exp" onclick="javascript:window.imprimirDIV('ID_DIV');">Imprimir </button>
            </center>
          </div>
          </div>
      </div>
          <div id="ID_DIV" class="hidden">
          </br></br></br>
            <center> EN SAN SALVADOR, A LOS <?php echo $dias = NumeroALetras::convertir($dia); ?> DÍAS DEL MES DE <?php echo strtoupper($mes);?> DE <?php echo $anios = NumeroALetras::convertir($anio);?>.<center><br><br>
            <p align="justify">
              EL EMPLEADO <?php echo strtoupper($nombre);?>, CON DOCUMENTO ÚNICO DE
              IDENTIDAD NÚMERO CERO <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[1]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[2]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[3]); ?>
              <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[4]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[5]); ?><?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[6]); ?>
              <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[7]); ?> GUION <?php $NumDui = $dui; echo $NumDu = NumeroALetras::convertir($NumDui[8]); ?>,
              NÚMERO DE IDENTIFICACIÓN TRIBUTARIA
              <?php if($nit[0] > 0){$NumNIT = NumeroALetras::convertir($nit[0]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[1] > 0){$NumNIT = NumeroALetras::convertir($nit[1]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[2] > 0){$NumNIT = NumeroALetras::convertir($nit[2]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[3] > 0){$NumNIT = NumeroALetras::convertir($nit[3]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              GUION
              <?php if($nit[5] > 0){$NumNIT = NumeroALetras::convertir($nit[5]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[6] > 0){$NumNIT = NumeroALetras::convertir($nit[6]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[7] > 0){$NumNIT = NumeroALetras::convertir($nit[7]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[8] > 0){$NumNIT = NumeroALetras::convertir($nit[8]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[9] > 0){$NumNIT = NumeroALetras::convertir($nit[9]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[10] > 0){$NumNIT = NumeroALetras::convertir($nit[10]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              GUION
              <?php if($nit[12] > 0){$NumNIT = NumeroALetras::convertir($nit[12]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[13] > 0){$NumNIT = NumeroALetras::convertir($nit[13]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              <?php if($nit[14] > 0){$NumNIT = NumeroALetras::convertir($nit[14]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>
              GUION
              <?php if($nit[15] > 0){$NumNIT = NumeroALetras::convertir($nit[15]);}else{$NumNIT = 'CERO';}echo $NumNIT;?>,
              NÚMERO DE AFILIACIÓN AL SEGURO SOCIAL
              <?php if($isss[0] > 0){$NumISSS = NumeroALetras::convertir($isss[0]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[1] > 0){$NumISSS = NumeroALetras::convertir($isss[1]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[2] > 0){$NumISSS = NumeroALetras::convertir($isss[2]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[3] > 0){$NumISSS = NumeroALetras::convertir($isss[3]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[4] > 0){$NumISSS = NumeroALetras::convertir($isss[4]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[5] > 0){$NumISSS = NumeroALetras::convertir($isss[5]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[6] > 0){$NumISSS = NumeroALetras::convertir($isss[6]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[7] > 0){$NumISSS = NumeroALetras::convertir($isss[7]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              <?php if($isss[8] > 0){$NumISSS = NumeroALetras::convertir($isss[8]);}else{$NumISSS = 'CERO';}echo $NumISSS;?>
              Y NÚMERO ÚNICO PREVISIONAL
              <?php if($nup[0] > 0){$NumNup = NumeroALetras::convertir($nup[0]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[1] > 0){$NumNup = NumeroALetras::convertir($nup[1]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[2] > 0){$NumNup = NumeroALetras::convertir($nup[2]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[3] > 0){$NumNup = NumeroALetras::convertir($nup[3]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[4] > 0){$NumNup = NumeroALetras::convertir($nup[4]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[5] > 0){$NumNup = NumeroALetras::convertir($nup[5]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[6] > 0){$NumNup = NumeroALetras::convertir($nup[6]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[7] > 0){$NumNup = NumeroALetras::convertir($nup[7]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[8] > 0){$NumNup = NumeroALetras::convertir($nup[8]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[9] > 0){$NumNup = NumeroALetras::convertir($nup[9]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[10] > 0){$NumNup = NumeroALetras::convertir($nup[10]);}else{$NumNup = 'CERO';}echo $NumNup;?>
              <?php if($nup[11] > 0){$NumNup = NumeroALetras::convertir($nup[11]);}else{$NumNup = 'CERO';}echo $NumNup;?>,
              ACEPTA LA TERMINACIÓN DE CONTRATO DE TRABAJO COLECTIVO QUE MANTIENE CON
              LA SOCIEDAD <?php echo $empresa;?> LA CUAL SE IDENTIFICA POR SU NÚMERO DE
              IDENTIFICACIÓN TRIBUTARIA
              <?php if($nitempresa[0] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[0]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[1] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[1]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[2] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[2]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[3] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[3]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              GUION
              <?php if($nitempresa[5] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[5]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[6] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[6]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[7] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[7]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[8] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[8]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[9] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[9]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[10] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[10]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              GUION
              <?php if($nitempresa[12] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[12]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[13] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[13]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              <?php if($nitempresa[14] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[14]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              GUION
              <?php if($nitempresa[15] > 0){$Numnitempresa = NumeroALetras::convertir($nitempresa[15]);}else{$Numnitempresa = 'CERO';}echo $Numnitempresa;?>
              Y SU NUMERO DE REGISTRO DE CONTRIBUYENTE

              <?php
                  $cantidad = strlen($nrc);
                  for ($i=0;$i<$cantidad;$i++) {
                    if($nrc[$i] > 0){$NumNup = NumeroALetras::convertir($nrc[$i]);}elseif($nrc[$i] = '-'){$NumNup = 'GUION ';}else{$NumNup = 'CERO ';}echo $NumNup;
                  }
              ?>,
              EL CUAL MANTUVO EN UN RANGO DE FECHAS QUE INICIA DESDE EL DIA <?php echo strtoupper(obtenerFechaEnLetra($contratacion));?> Y FINALIZA EL DIA
              <?php echo strtoupper(obtenerFechaEnLetra($despido));?>. EL EMPLEADO ACEPTA LA CANTIDAD DE <?php echo $MontVaca = NumeroALetras::convertir($UltimaMontoVacacion, 'DOLARES', 'CENTAVOS');?>, EN CONCEPTO DE VACACIONES PROPORCIONALES,
              <?php echo $MontVaca = NumeroALetras::convertir($UltimaMontoAguinaldo, 'DOLARES', 'CENTAVOS');?> EN CONCEPTO DE AGUINALDO PROPORCIONAL Y, <?php echo $MontVaca = NumeroALetras::convertir($pagar, 'DOLARES', 'CENTAVOS');?> EN CONCEPTO DE INDEMNIZACIÓN,
              PERCEPCIONES LAS CUALES SUMAN UNA CANTIDAD DE <?php echo $TotalIndemnizacion = NumeroALetras::convertir($TotalIndemnizacion, 'DOLARES', 'CENTAVOS');?>. EL SEÑOR <?php echo strtoupper($nombre);?> ACEPTA LAS PERCEPCIONES Y DEDUCCIONES ANTES MENCIONADAS Y LIBERA DE
              TODA RESPONSABILIDAD LABORAL Y MERCANTIL A LA SOCIEDAD <?php echo strtoupper($empresa);?><br><br>

              Y PARA LO QUE LOS INTERESADOS ESTIMEN CONVENIENTE, SE EXTIENDE Y FIRMA EL MÁS AMPLIO <strong>FINIQUITO</strong> A LOS <?php echo $dias = NumeroALetras::convertir($dia); ?> DÍAS DEL MES DE <?php echo strtoupper($mes);?> DE <?php echo $anios = NumeroALetras::convertir($anio);?>.


            </p>

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
      </div>
    </div>
</div>
