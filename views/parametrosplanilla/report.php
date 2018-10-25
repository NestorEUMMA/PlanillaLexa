<?php

use yii\helpers\Html;
use yii\web\Request;
// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
require("tools/NumeroALetras.php");




  $queryparametros = "select FechaIni, FechaFin, Tipo from parametrosplanilla where IdParametroPlanilla = '$model->IdParametroPlanilla'";
  $resultadoqueryparametros = $mysqli->query($queryparametros);

  while ($test = $resultadoqueryparametros->fetch_assoc())
             {
                 $fechaini = $test['FechaIni'];
                 $fechafin = $test['FechaFin'];
                 $tipo = $test['Tipo'];

             }

 $FechaIni = $fechaini;
 $FechaFin = $fechafin;
 $Tipo = $tipo;


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

 $queryempresa = "select e.NombreEmpresa, e.Direccion, e.NitEmpresa, d.NombreDepartamento, e.ImagenEmpresa
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
                $ima = $test['ImagenEmpresa'];

            }

require("queryResultPlanilla.php");
require("queryResultPlanillaTot.php");
require("queryResultPlanillaPrint.php");
require("queryResultPlanillaTotPrint.php");

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

  $resultadoquerytotplanilla = $mysqli->query($querytotplanilla);
  $ttotsalario = 0;
  $ttotextras = 0;
  $ttotsalariotot = 0;
  $ttotisss = 0;
  $ttotafp = 0;
  $ttotipsfa = 0;
  $ttotrenta = 0;
  $ttotprecepcion = 0;
  $ttotanticipos = 0;
  $ttotsalarioliquido = 0;

  while ($test = $resultadoquerytotplanilla->fetch_assoc())
             {
                 $ttotsalario += $test['SALARIO'];
                 $ttotextras += $test['EXTRA'];
                 $ttotsalariotot += $test['TOTALSALARIO'];
                 $ttotisss += $test['ISSS'];
                 $ttotafp += $test['AFP'];
                 $ttotipsfa += $test['IPSFA'];
                 $ttotrenta +=  $test['RENTA'];
                 $ttotprecepcion +=  $test['TOTALPERCEPCION'];
                 $ttotanticipos +=  $test['ANTICIPOS'];
                 $ttotsalarioliquido +=  $test['SALARIOLIQUIDO'];

                 $idempleado = $test['IDEMPLEADO'];
                 $nombreCom = $test['NOMBRECOMPLETO'];
                 $dias = $test['DIAS'];
                 $totsalario = $test['SALARIO'];
                 $totextras = $test['EXTRA'];
                 $totsalariotot = $test['TOTALSALARIO'];
                 $totisss = $test['ISSS'];
                 $totafp = $test['AFP'];
                 $toipsfa = $test['IPSFA'];
                 $totrenta =  $test['RENTA'];
                 $totprecepcion =  $test['TOTALPERCEPCION'];
                 $totanticipos =  $test['ANTICIPOS'];
                 $totsalarioliquido =  $test['SALARIOLIQUIDO'];
             }

$this->title = 'Vista Previa de Planilla: ';
$this->params['breadcrumbs'][] = ['label' => 'Planilla', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Vista Previa';
?>
</br>
<div class="row">
    <div class="col-md-12">
      <div class="ibox float-e-margins">

          <div class="ibox-content">
          <div class="card-content">
              <h4 class="card-title">Vista Previa de Planilla</h4>
              <center><strong><?php echo $empresa; ?></strong>
              <center><strong>PLANILLA DE SALARIO</strong></center>
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
                          <tr>
                            <td rowspan="2"><strong><center>EMPLEADO</center></strong></td>
                            <td rowspan="2"><strong><center>DIAS</center></strong></td>
                            <td colspan="3"><strong><center>PERCEPCIONES</center></strong></td>
                            <td colspan="5"><strong><center>DEDUCCIONES DE LEY</center></strong></td>
                            <td rowspan="2"><strong><center>OTROS DESCUENTOS</center></strong></td>
                            <td rowspan="2"><strong><center>SALARIO LIQUIDO</center></strong></td>
                          </tr>
                          <tr>
                            <strong>
                            <td><strong><center>SALARIO</center></strong></td>
                            <td><strong><center>EXTRAS</center></strong></td>
                            <td><strong><center>TOTAL</center></strong></td>
                            <td><strong><center>ISSS</center></strong></td>
                            <td><strong><center>AFP</center></strong></td>
                            <td><strong><center>IPSFA</center></strong></td>
                            <td><strong><center>RENTA</center></strong></td>
                            <td><strong><center>TOTAL</center></strong></td>
                          </tr>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        while ($row = $resultadoqueryplanilla->fetch_assoc())
                      {
                           echo"<tr>";
                           echo"<td width='210px'>".$row['NOMBRECOMPLETO']."</center></td>";
                           echo"<td width='60px'><center>".$row['DIAS']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['SALARIO']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['EXTRA']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['TOTALSALARIO']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['ISSS']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['AFP']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['IPSFA']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['RENTA']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['TOTALPERCEPCION']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['ANTICIPOS']."</center></td>";
                           echo"<td width='60px'><center>$ ".$row['SALARIOLIQUIDO']."</center></td>";
                      }
                      ?>
                      </tbody>
                      <thead class="text-primary">
                        <tr>
                            <td align="right"><strong>TOTAL:</strong></td>
                            <td></td>
                            <td><strong><center>$<?php echo number_format($ttotsalario,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotextras,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotsalariotot,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotisss,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotafp,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotipsfa,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotrenta,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotprecepcion,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotanticipos,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotsalarioliquido,2); ?></center></strong></td>
                        </tr>
                      </thead>
                  </table>
              </div>
              <div class="col-xs-12">
                <center>
                      <a href="../parametrosplanilla/index" class="btn btn-danger"></i> REGRESAR</a>
                      <?php
                      $queryvalidacionplanilla = "select FechaCreacion, MesPlanilla, PeriodoPlanilla, QuincenaPlanilla from parametrosplanilla where MesPlanilla = '$mes' and PeriodoPlanilla = '$anio' and QuincenaPlanilla = '$quincena'";
                      $resultqueryvalidacionplanilla = $mysqli->query($queryvalidacionplanilla);

                      if(mysqli_num_rows($resultqueryvalidacionplanilla)==0){
                        ?>
                        <button class="btn btn-info btn-raised btn-guardar">
                                 GUARDAR PLANILLA
                        </button>
                        <?php
                      }
                      else{
                        ?>
                        <button class="btn btn-info btn-raised btn-guardar" disabled="disabled">
                                 GUARDAR PLANILLA
                        </button>
                        <?php
                      }
                      ?>
                      <!-- <button class="btn btn-info btn-raised btn-guardar">
                               GUARDAR PLANILLA
                      </button> -->
                    <button class="btn btn-success btn-raised btn-imprimir">
                             IMPRIMIR PLANILLA
                    </button>

                    <button class="btn btn-warning btn-raised btn-boleta">
                             IMPRIMIR BOLETAS
                    </button>
                  </center>
              </div>

              <div class="col-xs-12">
                  <?php
                  $queryvalidacionplanilla = "select FechaCreacion, MesPlanilla, PeriodoPlanilla, QuincenaPlanilla from parametrosplanilla where MesPlanilla = '$mes' and PeriodoPlanilla = '$anio' and QuincenaPlanilla = '$quincena'";
                  $resultqueryvalidacionplanilla = $mysqli->query($queryvalidacionplanilla);
                  while ($row = $resultqueryvalidacionplanilla->fetch_assoc())
                {
                     $fecha = $row['FechaCreacion'];
                }

                  if(mysqli_num_rows($resultqueryvalidacionplanilla)==0){
                    ?>
                    <?php
                  }
                  else{
                    ?>
                      <center><h4>Planilla guardada el <?php echo $fecha; ?></h4></center>
                    <?php
                  }
                  ?>
              </div>

              <form id="frmplanilla" action="../../report/planilla/index" method="post" target="_blank" class="hidden">
                <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $fechaini;?>" />
                <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $fechafin;?>" />
                <input type="text" id="Tipo" name="Tipo" value="<?php echo $tipo;?>" />
              </form>
              <form id="frmboleta" action="../../report/planilla/boletaspago" method="post" target="_blank" class="hidden">
                <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $fechaini;?>" />
                <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $fechafin;?>" />
                <input type="text" id="Tipo" name="Tipo" value="<?php echo $tipo;?>" />
              </form>
              <form id="frmguardar" action="guardarplanilla.php" method="post"  class="hidden">
                <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $fechaini;?>" />
                <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $fechafin;?>" />
                <input type="text" id="Tipo" name="Tipo" value="<?php echo $tipo;?>" />
              </form>

          </div>
          </div>
      </div>
    </div>
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
</div>
