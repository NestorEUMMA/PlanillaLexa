<!DOCTYPE html>
<html>
<head>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="icon" type="image/png" href="../../web/assets/img/lexa.png" />
  <title>Sistema Planilla LEXA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
<?php include '../../include/include.php'; ?>
<?php include '../../include/dbconnect.php'; ?>
<?php

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
             SUM(ho.MontoHonorario) as 'MONTO', SUM(ho.MontoISRHonorarios) as 'RENTA', SUM(ho.MontoPagar) as 'LIQUIDO' from honorario ho
             INNER JOIN empleado E on ho.IdEmpleado = E.IdEmpleado
             WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 1 AND ho.FechaHonorario between '$FechaIni' and '$FechaFin'
             group by E.IdEmpleado";

                 $resultadoqueryplanilla = $mysqli->query($querytotplanilla);


             $querytotplanilla = "SELECT CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',
             SUM(ho.MontoHonorario) as 'MONTO', SUM(ho.MontoISRHonorarios) as 'RENTA', SUM(ho.MontoPagar) as 'LIQUIDO' from honorario ho
             INNER JOIN empleado E on ho.IdEmpleado = E.IdEmpleado
             WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 1 AND ho.FechaHonorario between '$FechaIni' and '$FechaFin'
             group by E.IdEmpleado";

                 $resultadoquerytotplanilla = $mysqli->query($querytotplanilla);

                 $ttothonorario = 0;
                 $ttotisr = 0;
                 $ttothonorariotot = 0;


                 while ($test = $resultadoquerytotplanilla->fetch_assoc())
                            {
                                $ttothonorario += $test['MONTO'];
                                $ttotisr += $test['RENTA'];
                                $ttothonorariotot += $test['LIQUIDO'];


                                $nombreCom = $test['NOMBRECOMPLETO'];
                                $tothonorario = $test['MONTO'];
                                $totisr = $test['RENTA'];
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


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <div class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h4 class="page">
          <center><strong><?php echo $empresa; ?></strong>
          <center><strong>REPORTE EMPLEADOS NO DEPENDIENTE</strong></center>
          <strong><small><?php echo $direccion; ?></small></strong>
          </br><strong><small><?php echo $nitempresa; ?></small></strong>
        </br><strong>Del <?php echo $diaIni; ?> al <?php echo $diaFin; ?> de <?php echo $mes; ?> de <?php echo $anio; ?></strong>
        </br>
          </center>
      </h4>
      </div>
    </div>
            <div class="table">
              <FONT SIZE=1>
                <table class="table" border="2" style="height:5px;">
                  <thead class="text-primary">
                      <tr>
                        <strong>
                        <td><strong><center>EMPLEADO </center></strong></td>
                        <td><strong><center>HONORARIO</center></strong></td>
                        <td><strong><center>RENTA</center></strong></td>
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
                           echo"<td width='60px'><center>$ ".$test['LIQUIDO']."</center></td>";
                      }
                      ?>

                      </tbody>
                    </FONT>
                      <thead class="text-primary">
                        <tr>
                            <td align="right"><strong>TOTAL:</strong></td>
                            <td><strong><center>$<?php echo number_format($ttothonorario,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttotisr,2); ?></center></strong></td>
                            <td><strong><center>$<?php echo number_format($ttothonorariotot,2); ?></center></strong></td>
                        </tr>
                      </thead>
                </table>
            </div>
        <!-- </div> -->
    <!-- </div> -->
  </div>
</div>
</body>
</html>
