<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\Request;
/* @var $this yii\web\View */
/* @var $model app\models\Rptrentaanual */
include '../include/dbconnect.php';
require("tools/NumeroALetras.php");

$Periodo = $periodo;


$queryreporteanual = "SELECT RPAD(CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado), 40,' ') AS 'NOMBRECOMPLETO', LPAD(REPLACE(e.Nit, '-', ''),14, ' ') as 'NIT',
LPAD(rpt.CodigoIngreso, 2, '0') as 'CODIGOINGRESO', LPAD(SUM(REPLACE(rpt.MontoDevengado,'.','')), 15, ' ') AS 'MONTODEVENGADO', LPAD(SUM(REPLACE(rpt.ImpuestoRetenido,'.','')), 15, ' ') AS 'IMPUESTORETENIDO',
LPAD(SUM(REPLACE(rpt.AguinaldoExento,'.',' ')), 15, ' ') AS 'AGUINALDOEX', LPAD(SUM(REPLACE(rpt.AguinaldoGravado,'.','')), 15, ' ') AS 'AGUINALDOGRAV', LPAD(SUM(REPLACE(rpt.isss,'.','')), 15, ' ') AS 'ISSS',
LPAD(SUM(REPLACE(rpt.afp,'.','')), 15, ' ') AS 'AFP', LPAD(SUM(REPLACE(rpt.ipsfa,'.','')), 15, ' ') AS 'IPSFA', LPAD(0, 15, ' ') AS 'BIENESTARMAGISTRAL', LPAD(rpt.anio, 4, ' ') AS 'AÑO'
FROM rptrentaanual rpt
INNER JOIN empleado e on rpt.IdEmpleado = e.IdEmpleado
where rpt.CodigoIngreso IN (select CodigoIngreso from codigoreporteanual) and rpt.Anio = '$Periodo' and length(E.Nit) != 0
group by e.IdEmpleado
";

$resultadoqueryreporteanual = $mysqli->query($queryreporteanual);


$this->title = "Vista Previa Reporte Anual F910 correspondiente al año $Periodo";
$this->params['breadcrumbs'][] = ['label' => 'Reporte Anual F910', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rptrentaanual-view">

  <div class="col-md-12">
  <div class="card">
          <div class="card-header card-header-icon" data-background-color="orange">
              <i class="material-icons">mail_outline</i>
          </div>
          <div class="card-content">

        </br>
          </center>
          <div class="table">
            </br>
              <table class="table">
                  <thead class="text-primary">
                    <tr>
                        <strong>
                        <td><strong><center>NOMBRE COMPLETO</center></strong></td>
                        <td><strong><center>NIT</center></strong></td>
                        <td><strong><center>CODIGO INGRESO</center></strong></td>
                        <td><strong><center>MONTO DEVENGADO</center></strong></td>
                        <td><strong><center>IMPUESTO RETENIDO</center></strong></td>
                        <td><strong><center>AGUINALDO EXENTO</center></strong></td>
                        <td><strong><center>AGUINALDO GRAVADO</center></strong></td>
                        <td><strong><center>ISSS</center></strong></td>
                        <td><strong><center>AFP</center></strong></td>
                        <td><strong><center>IPSFA</center></strong></td>
                        <td><strong><center>BIE MAGISTERIAL</center></strong></td>
                        <td><strong><center>AÑO</center></strong></td>
                      </strong>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    while ($row = $resultadoqueryreporteanual->fetch_assoc())
                  {
                       echo"<tr>";
                       echo"<td width='210px'>".$row['NOMBRECOMPLETO']."</center></td>";
                       echo"<td width='60px'><center>".$row['NIT']."</center></td>";
                       echo"<td width='60px'><center>".$row['CODIGOINGRESO']."</center></td>";
                       echo"<td width='60px'><center>".$row['MONTODEVENGADO']."</center></td>";
                       echo"<td width='60px'><center>".$row['IMPUESTORETENIDO']."</center></td>";
                       echo"<td width='60px'><center>".$row['AGUINALDOEX']."</center></td>";
                       echo"<td width='60px'><center>".$row['AGUINALDOGRAV']."</center></td>";
                       echo"<td width='60px'><center>".$row['ISSS']."</center></td>";
                       echo"<td width='60px'><center>".$row['AFP']."</center></td>";
                       echo"<td width='60px'><center>".$row['IPSFA']."</center></td>";
                       echo"<td width='60px'><center>".$row['BIENESTARMAGISTRAL']."</center></td>";
                       echo"<td width='60px'><center>".$row['AÑO']."</center></td>";
                  }
                  ?>
                  </tbody>
                  <thead class="text-primary">
                    <tr>
                      <strong>
                      <td><strong><center>NOMBRE COMPLETO</center></strong></td>
                      <td><strong><center>NIT</center></strong></td>
                      <td><strong><center>CODIGO INGRESO</center></strong></td>
                      <td><strong><center>MONTO DEVENGADO</center></strong></td>
                      <td><strong><center>IMPUESTO RETENIDO</center></strong></td>
                      <td><strong><center>AGUINALDO EXENTO</center></strong></td>
                      <td><strong><center>AGUINALDO GRAVADO</center></strong></td>
                      <td><strong><center>ISSS</center></strong></td>
                      <td><strong><center>AFP</center></strong></td>
                      <td><strong><center>IPSFA</center></strong></td>
                      <td><strong><center>BIE MAGISTERIAL</center></strong></td>
                      <td><strong><center>AÑO</center></strong></td>
                    </strong>
                    </tr>
                  </thead>
              </table>
          </div>
          <div class="col-xs-12">
            <center>
                  <a href="../reporteanuarenta/index" class="btn btn-danger"></i> REGRESAR</a>
                  <button class="btn btn-success btn-raised btn-exportar">
                           EXPORTAR REPORTE
                  </button>
              </center>

          </div>

          <form id="frmplanilla" action="../../views/reporteanuarenta/exportar" method="post" class="hidden">
            <input type="text" id="Periodo" name="Periodo" value="<?php echo $Periodo;?>" />
          </form>
      </div>
      </div>


</div>

<script type="text/javascript">
    $(document).ready(function(){

        $(".btn-exportar").click(function(){
            // var id = $(this).attr("value");
            // $("#IdIndemnizacion").val(id);
            $("#frmplanilla").submit();
            //alert(id);
        });

    });

</script>
