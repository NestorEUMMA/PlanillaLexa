<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\Request;
/* @var $this yii\web\View */
/* @var $model app\models\Rptrentaanual */
include '../include/dbconnect.php';
require("tools/NumeroALetras.php");

$Periodo = $periodo;
$Mes = $mes;
$Dias = cal_days_in_month(CAL_GREGORIAN, $Mes, $Periodo);
$FechaIni = ''.$Periodo.'-'.$Mes.'-01';
$FechaFin = ''.$Periodo.'-'.$Mes.'-'.$Dias.'';

$meses = $Mes;
    if($meses == '01'){
        $meses = 'Enero';
    }
    elseif($meses == '02'){
        $meses = 'Febrero';
    }
    elseif($meses == '03'){
        $meses = 'Marzo';
    }
    elseif($meses == '04'){
        $meses = 'Abril';
    }
    elseif($meses == '05'){
        $meses = 'Mayo';
    }
    elseif($meses == '06'){
        $meses = 'Junio';
    }
    elseif($meses == '07'){
        $meses = 'Julio';
    }
    elseif($meses == '08'){
        $meses = 'Agosto';
    }
    elseif($meses == '09'){
        $meses = 'Septiembre';
    }
    elseif($meses == '10'){
        $meses = 'Octubre';
    }
    elseif($meses == '11'){
        $meses = 'Noviembre';
    }
    else{
        $meses = 'Diciembre';
    }

  $queryreportesepp = "SELECT
  '0' AS 'PlanillaCodigosObservacion', (CONVERT((E.SalarioNominal), DECIMAL(10,2)) -
  	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  	END  -
  	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  	END)
  	AS 'PlanillaIngresoBaseCotizacion',
    '8' AS 'PlanillaHorasJornadaLaboral',
    ('$Dias' - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0 ELSE (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END )
  - (CASE WHEN (SELECT SUM(P.DiasPermiso) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0 ELSE (SELECT SUM(P.DiasPermiso) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END )) as 'PlanillaDiasCotizados',
  '0' AS 'PlanillaCotizacionVoluntariaAfiliado',
  '0' AS 'PlanillaCotizacionVoluntariaEmpleador', REPLACE(E.Nup, '_','') AS 'Nup',
  (CASE WHEN Ins.DescripcionInstitucion = 'AFP Confia' THEN 'COF'
  	 WHEN Ins.DescripcionInstitucion = 'AFP Crecer' THEN 'MAX'
  END) AS 'InstitucionPrevisional',
  E.PrimerNomEmpleado AS 'PrimerNombre',
  E.SegunNomEmpleado AS 'SegundoNombre',
  E.PrimerApellEmpleado AS 'PrimerApellido',
  E.SegunApellEmpleado AS 'SegundoApellido',
  E.ApellidoCasada AS 'ApellidoCasada',
  (CASE WHEN td.DescripcionTipoDocumento = 'Documento Unico de Identidad' THEN 'DUI'
  END) AS 'TipoDocumento', E.NumTipoDocumento AS 'NumeroDocumento'

  FROM Empleado E
  LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
  INNER JOIN institucionprevisional Ins on E.IdInstitucionPre = Ins.IdInstitucionPre
  INNER JOIN tipodocumento td on E.IdTipoDocumento = td.IdTipoDocumento
  		LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
  		WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 0 and Ins.DescripcionInstitucion <> 'IPSFA' and td.DescripcionTipoDocumento = 'Documento Unico de Identidad'
  		group by E.IdEmpleado";
  $resultadoqueryreportesepp = $mysqli->query($queryreportesepp);

$this->title = "Vista Previa Reporte SEPP correspondiente al mes $meses año $Periodo";
$this->params['breadcrumbs'][] = ['label' => 'Reporte SEPP', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rptrentaanual-view">

  <div class="col-md-12">
  <div class="card">
          <div class="card-header card-header-icon" data-background-color="orange">
              <i class="material-icons">mail_outline</i>
          </div>
          <div class="card-content">
          <div class="table">

              <table class="table">
                  <thead class="text-primary">
                    <tr>
                        <strong>
                          <td><strong><center>PlanillaIngresoBaseCotizacion</center></strong></td>
                          <td><strong><center>PlanillaHorasJornadaLaboral</center></strong></td>
                          <td><strong><center>PlanillaDiasCotizados</center></strong></td>

                          <td><strong><center>Nup</center></strong></td>
                          <td><strong><center>InstitucionPrevisional</center></strong></td>
                          <td><strong><center>PrimerNombre</center></strong></td>
                          <td><strong><center>PrimerApellido</center></strong></td>
                          <td><strong><center>ApellidoCasada</center></strong></td>
                          <td><strong><center>TipoDocumento</center></strong></td>
                          <td><strong><center>NumeroDocumento</center></strong></td>
                      </strong>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while ($row = $resultadoqueryreportesepp->fetch_assoc())
                    {
                         echo"<tr>";

                         echo"<td width='60px'><center>".$row['PlanillaIngresoBaseCotizacion']."</center></td>";
                         echo"<td width='60px'><center>".$row['PlanillaHorasJornadaLaboral']."</center></td>";
                         echo"<td width='60px'><center>".$row['PlanillaDiasCotizados']."</center></td>";
                         echo"<td width='60px'><center>".$row['Nup']."</center></td>";
                         echo"<td width='60px'><center>".$row['InstitucionPrevisional']."</center></td>";
                         echo"<td width='60px'><center>".$row['PrimerNombre']."</center></td>";
                         echo"<td width='60px'><center>".$row['PrimerApellido']."</center></td>";
                         echo"<td width='60px'><center>".$row['ApellidoCasada']."</center></td>";
                         echo"<td width='60px'><center>".$row['TipoDocumento']."</center></td>";
                         echo"<td width='60px'><center>".$row['NumeroDocumento']."</center></td>";
                    }
                    ?>
                  </tbody>
                  <thead class="text-primary">
                    <tr>
                      <td><strong><center>PlanillaIngresoBaseCotizacion</center></strong></td>
                      <td><strong><center>PlanillaHorasJornadaLaboral</center></strong></td>
                      <td><strong><center>PlanillaDiasCotizados</center></strong></td>
                      <td><strong><center>Nup</center></strong></td>
                      <td><strong><center>InstitucionPrevisional</center></strong></td>
                      <td><strong><center>PrimerNombre</center></strong></td>
                      <td><strong><center>PrimerApellido</center></strong></td>
                      <td><strong><center>ApellidoCasada</center></strong></td>
                      <td><strong><center>TipoDocumento</center></strong></td>
                      <td><strong><center>NumeroDocumento</center></strong></td>
                    </tr>
                  </thead>
              </table>
          </div>
          <div class="col-xs-12">
            <center>
                  <a href="../reportesepp/index" class="btn btn-danger"></i> REGRESAR</a>
                  <button class="btn btn-success btn-raised btn-exportar">
                           EXPORTAR REPORTE
                  </button>
                  <button class="btn btn-info btn-raised btn-guardar">
                           GUARDAR PLANILLA
                  </button>
              </center>

          </div>

          <form id="frmplanilla" action="../../views/reportesepp/exportar" method="post" class="hidden">
            <input type="text" id="Periodo" name="Periodo" value="<?php echo $Periodo;?>" />
            <input type="text" id="Mes" name="Mes" value="<?php echo $Mes;?>" />
          </form>
          <form id="frmguardar" action="../../views/reportesepp/guardarsepp" method="post"  class="hidden">
            <input type="text" id="FechaIni" name="FechaIni" value="<?php echo $FechaIni;?>" />
            <input type="text" id="FechaFin" name="FechaFin" value="<?php echo $FechaFin;?>" />
            <input type="text" id="Perido" name="Periodo" value="<?php echo $Periodo;?>" />
            <input type="text" id="Mes" name="Mes" value="<?php echo $Mes;?>" />
            <input type="text" id="Dias" name="Dias" value="<?php echo $Dias;?>" />
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
        $(".btn-guardar").click(function(){
            // var id = $(this).attr("value");
            // $("#IdIndemnizacion").val(id);
            $("#frmguardar").submit();
            //alert(id);
        });

    });

</script>
