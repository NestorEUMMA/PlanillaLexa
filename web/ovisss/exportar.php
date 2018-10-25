<?php


// Database Connection
 include '../../include/dbconnect.php';
 session_start();

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
$query = "    SELECT CONCAT((select NuPatronal from Empresa where IdEmpresa = 1),'','$periodoovisss','','001','',E.NIsss,'',
  RPAD(CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado),40,' '),'',
  LPAD(REPLACE((CONVERT((
  CASE
	  WHEN E.FechaDespido = '$FechaFin' THEN E.SalarioNominal
	  WHEN E.FechaDespido BETWEEN '$FechaIni' AND '$FechaFin' THEN(E.SalarioNominal / (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
		date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month)))) * ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
		date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - DAYOFMONTH(FechaDespido))
	  WHEN E.FechaDespido IS NULL AND E.FechaContratacion BETWEEN '$FechaIni' AND '$FechaFin' THEN(E.SalarioNominal / (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
		date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month)))) * ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
		date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - DAYOFMONTH(FechaContratacion))
	  ELSE E.SalarioNominal END), DECIMAL(10,2)) -
  CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END ),'.',''),9,0),'',
  LPAD(REPLACE((CONVERT(0, DECIMAL(10,2)) +
  CASE WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0.00 ELSE (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END ),'.',''),9,0),'',
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
      ),'.',''),9,0),'',
  CASE
  WHEN E.FechaDespido = '$FechaFin' THEN ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
  date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))))
  WHEN E.FechaDespido BETWEEN '$FechaIni' AND '$FechaFin' THEN ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
	date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month)))- DAYOFMONTH(FechaDespido))
  WHEN E.FechaDespido IS NULL AND E.FechaContratacion BETWEEN '$FechaIni' AND '$FechaFin' THEN ((timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
	date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month)))- DAYOFMONTH(FechaContratacion))
  WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL AND E.FechaDespido IS NULL
        THEN (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
	date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0 ELSE (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END)
        ELSE (timestampdiff(day, concat(year(now()),'-',month(now()),'-01'),
	date_add( concat(year(now()),'-',month(now()),'-01'), interval 1 month))) - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN 0 ELSE (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END) - 15 END,'',
  '08','',
  CASE WHEN (SELECT SUM(P.Vacaciones) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
        THEN '00' ELSE '15'
      END,'',
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
	ELSE '00' END) AS 'OVISSS' /***************SIN CAMBIOS AL MES ANTERIOR***********************/

  FROM Empleado E
  LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
  LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
  WHERE E.EmpleadoActivo = 1 AND E.NoDependiente = 0 AND E.NIsss > 0
  group by E.IdEmpleado
";

if (!$result = mysqli_query($mysqli, $query)) {
    exit(mysqli_error($mysqli));
}

$users = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=ovisss.txt');
$output = fopen('php://output', 'w');

$resultadointegracion = $mysqli->query($query);

while ($test = $resultadointegracion->fetch_assoc())
{
    fputs  ($output, $test["OVISSS"]);
    fputs  ($output, "\r\n");

}
fclose ($output);

?>
