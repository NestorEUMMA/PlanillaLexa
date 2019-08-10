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
  <link rel="stylesheet" href="../../include/adminlte.min.css">
  <?php include '../../include/include2.php'; ?>
  <!-- Bootstrap 3.3.7 -->

<?php include '../../include/dbconnect.php'; ?>
<?php

   $FechaIni = str_replace('/',"-", $_POST['FechaIni'] );
      $FechaFin = str_replace('/',"-", $_POST['FechaFin'] );


      $diaIni = substr($FechaIni, 8, 2);
      $diaFin = substr($FechaFin, 8, 2);
      if(($diaIni = substr($FechaIni, 8, 2)) >= 01 and ($diaFin = substr($FechaFin, 8, 2)) <= 15){
        $quincena = 1;
      }
  elseif(($diaIni = substr($FechaIni, 8, 2)) >= 16 and ($diaFin = substr($FechaFin, 8, 2)) <= 31){
         $quincena = 2;
      }
      else{
         $quincena = 3;
      }



      $queryplanilla = "SELECT ba.DescripcionBanco as 'BANCO', e.CBancaria as 'CUENTA', e.nit as 'NIT', 
pu.DescripcionPuestoEmpresa as 'PUESTOEMPRESA', E.IdEmpleado as 'IDEMPLEADO', CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',
15  as 'DIAS',
SUM(P.Honorario) as 'SALARIO',
(CASE WHEN (SELECT SUM(AFPPlanilla)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(AFPPlanilla)
) END) as 'AFP',
(CASE WHEN (SELECT SUM(ISSSPlanilla)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(ISSSPlanilla)
) END) as 'ISSS',
SUM(P.ISRPlanilla) as 'RENTA',
0.00 as 'ANTICIPOS',
SUM(P.Honorario) as 'TOTAL'


FROM Empleado E
LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
LEFT JOIN banco ba on e.IdBanco = ba.IdBanco
WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 1
and E.IdEmpleado NOT IN ( SELECT IdEmpleado FROM PLANILLA WHERE FechaTransaccion between '$FechaIni' AND '$FechaFin' group by IdEmpleado)
group by E.IdEmpleado

union all

SELECT ba.DescripcionBanco as 'BANCO', e.CBancaria as 'CUENTA', e.nit as 'NIT', 
pu.DescripcionPuestoEmpresa as 'PUESTOEMPRESA', E.IdEmpleado as 'IDEMPLEADO', CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',
15 - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) )  IS NULL
THEN 0 ELSE (SELECT SUM(P.DiasIncapacidad) )
END )
- (CASE WHEN (SELECT SUM(P.DiasPermiso) )  IS NULL
THEN 0 ELSE (SELECT SUM(P.DiasPermiso) )
END ) as 'DIAS',

SUM(P.Honorario) as 'SALARIO',
(CASE WHEN (SELECT SUM(AFPPlanilla)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(AFPPlanilla)
) END) as 'AFP',
(CASE WHEN (SELECT SUM(ISSSPlanilla)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(ISSSPlanilla)
) END) as 'ISSS',
SUM(P.ISRPlanilla) as 'RENTA',
(CASE WHEN (SELECT SUM(Anticipos)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(Anticipos)
) END) as 'ANTICIPOS',
((SUM(P.Honorario)) - (CASE WHEN (SELECT SUM(Anticipos)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(Anticipos)) END) - (SUM(P.ISRPlanilla))) as 'TOTALPAGAR'


FROM Empleado E
LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
LEFT JOIN banco ba on e.IdBanco = ba.IdBanco
WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 1 and  P.FechaTransaccion between '$FechaIni' and '$FechaFin'
group by E.IdEmpleado ";
      $resultadoqueryplanilla = $mysqli->query($queryplanilla);


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



     $mesfecha = substr($FechaFin, 5, 2);
                   $mes = $mesfecha;
      if($mes == '01'){
          $mes = 'Enero';
      }
      elseif($mes == '02'){
          $mes = 'Febrero';
      }
      elseif($mes == '03'){
          $mes = 'Marzo';
      }
      elseif($mes == '04'){
          $mes = 'Abril';
      }
      elseif($mes == '05'){
          $mes = 'Mayo';
      }
      elseif($mes == '06'){
          $mes = 'Junio';
      }
      elseif($mes == '07'){
          $mes = 'Julio';
      }
      elseif($mes == '08'){
          $mes = 'Agosto';
      }
      elseif($mes == '09'){
          $mes = 'Septiembre';
      }
      elseif($mes == '10'){
          $mes = 'Octubre';
      }
      elseif($mes == '11'){
          $mes = 'Noviembre';
      }
      else{
          $mes = 'Diciembre';
      }

   $anio = substr($FechaIni, 0, 4);



?>


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
        .table-c {
                  border: 1px solid black;
                  width:100%;
                  height: 30px;
                  table-layout: fixed;
              }
              .table-c td {
                  border: 1px solid black;
                  padding: 10px;
              }
              @media all
              {
              .page-break { display:none; }
              }

              @media print
              {
              .page-break { display:block; page-break-before:always; }
              }
  </style>
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <div class="invoice">
    <!-- title row -->
<?php
    while ($row = $resultadoqueryplanilla->fetch_assoc())
  {
       $row['NOMBRECOMPLETO'];
       $row['NIT'];
       $row['IDEMPLEADO'];
       $row['PUESTOEMPRESA'];
       $row['SALARIO'];
       $row['ISSS'];
       $row['AFP'];
       $row['RENTA'];
       $row['ANTICIPOS'];
       $row['TOTAL'];
       $row['DIAS'];
?>
          </br>
          </br>
          </br>
      <h4 class="page">
      <div class="col-xs-2">
      </div>
      <div class="col-xs-8">
       <center><strong><?php echo $empresa; ?></strong>
       <center><strong>COMPROBANTE DE PAGO</strong></center><strong>Del <?php echo $diaIni; ?> al <?php echo $diaFin; ?> de <?php echo $mes; ?> de <?php echo $anio; ?></strong>
       </br>
       </br>
       </center>
     </div>
     <div class="col-xs-2">
           <div style='position: relative;'>
               <img src='../../web/<?php echo $ima; ?>' style='width: 100px; height: 100px;' />
           </div>
     </div>
      </h4>
     <h5>
       <div class="col-sm-4 invoice-col">
            SALARIO: $<?php echo  $row['SALARIO']; ?>
       </div>
       <div class="col-sm-4 invoice-col">
       </div>
       <div class="col-sm-4 invoice-col">
             <p align="right">FECHA: <?php echo (new \DateTime())->format('d-m-Y'); ?></p>
       </div>
     </h5>
     <table class="table-c">
       <tr>
         <td style="width: 50%"><strong>EMPLEADO: <?php echo $row['NOMBRECOMPLETO']; ?> <br>NIT: <?php echo $row['NIT']; ?></strong></button></td>
         <td style="width: 50%"><strong>CARGO: <?php echo strtoupper($row['PUESTOEMPRESA']); ?></strong></td>
       </tr>
     </table>
     </br>
     <table class="table-c">
       <tr>
         <td style="width: 10%"><center><strong>ID EMPLEADO</strong></center></td>
         <td style="width: 30%"><center><strong>INGRESOS</strong></center></td>
         <td style="width: 10%"><center><strong>MONTO</strong></center></td>
         <td style="width: 30%"><center><strong>DESCUENTOS</strong></center></td>
         <td style="width: 10%"><center><strong>MONTO</strong></center></td>
       </tr>
       <tr style="height: 200px">
         <td><center><?php echo $row['IDEMPLEADO']; ?></center></br></br></br></br></br></br></td>
         <td> SALARIO</br>DIAS:<?php echo $row['DIAS']; ?> </br></br></br><strong>TOTAL DEVENGADO</strong></td>
         <td>$<?php echo $row['SALARIO']; ?></br></br></br></br><strong>$<?php echo $row['TOTAL']; ?></strong></td>
         <td>ISSS</br>AFP</br>RENTA</br>OTROS</br></br><strong>TOTAL DESCUENTO</strong></td>
         <td>$<?php echo $row['ISSS']; ?></br>$<?php echo $row['AFP']; ?></br>$<?php echo $row['RENTA']; ?></br>$<?php echo $row['ANTICIPOS']; ?></br></br><strong>$<?php echo$row['ANTICIPOS']; ?></strong></td>
       </tr>
     </table>
     </br>
     <table class="table-c">
       <tr>
         <h3><td style="width: 50%" align="left"><strong>RECIBI CONFORME: ________________________________<strong></td><h3>
         <h3><td style="width: 50%" align="right"><strong>NETO A PAGAR: $<?php echo $row['TOTAL']; ?> <br>BANCO: <?php echo $row['BANCO']; ?><br>CUENTA: <?php echo $row['CUENTA']; ?> <strong></td><h3>
       </tr>
     </table>
     </br>
     </br>
     </br>
     </br>
     </br>
  
     <h4 class="page">
     <div class="col-xs-2">
     </div>
     <div class="col-xs-8">
      <center><strong><?php echo $empresa; ?></strong>
      <center><strong>COMPROBANTE DE PAGO</strong></center><strong>Del <?php echo $diaIni; ?> al <?php echo $diaFin; ?> de <?php echo $mes; ?> de <?php echo $anio; ?></strong>
      </br>
      </br>
      </center>
    </div>
    <div class="col-xs-2">
          <div style='position: relative;'>
              <img src='../../web/<?php echo $ima; ?>' style='width: 100px; height: 100px;' />
          </div>
    </div>
     </h4>
    <h5>
      <div class="col-sm-4 invoice-col">
           SALARIO: $<?php echo  $row['SALARIO']; ?>
      </div>
      <div class="col-sm-4 invoice-col">
      </div>
      <div class="col-sm-4 invoice-col">
            <p align="right">FECHA: <?php echo (new \DateTime())->format('d-m-Y'); ?></p>
      </div>
    </h5>
    <table class="table-c">
      <tr>
        <td style="width: 50%"><strong>EMPLEADO: <?php echo $row['NOMBRECOMPLETO']; ?> <br>NIT: <?php echo $row['NIT']; ?></strong></button></td>
        <td style="width: 50%"><strong>CARGO: <?php echo strtoupper($row['PUESTOEMPRESA']); ?></strong></td>
      </tr>
    </table>
    </br>
    <table class="table-c">
       <tr>
         <td style="width: 10%"><center><strong>ID EMPLEADO</strong></center></td>
         <td style="width: 30%"><center><strong>INGRESOS</strong></center></td>
         <td style="width: 10%"><center><strong>MONTO</strong></center></td>
         <td style="width: 30%"><center><strong>DESCUENTOS</strong></center></td>
         <td style="width: 10%"><center><strong>MONTO</strong></center></td>
       </tr>
       <tr style="height: 200px">
         <td><center><?php echo $row['IDEMPLEADO']; ?></center></br></br></br></br></br></br></td>
         <td> SALARIO</br>DIAS:<?php echo $row['DIAS']; ?> </br></br></br><strong>TOTAL DEVENGADO</strong></td>
         <td>$<?php echo $row['SALARIO']; ?></br></br></br></br></br><strong>$<?php echo $row['TOTAL']; ?></strong></td>
         <td>ISSS</br>AFP</br>RENTA</br>OTROS</br></br><strong>TOTAL DESCUENTO</strong></td>
         <td>$<?php echo $row['ISSS']; ?></br>$<?php echo $row['AFP']; ?></br>$<?php echo $row['RENTA']; ?></br>$<?php echo $row['ANTICIPOS']; ?></br></br><strong>$<?php echo  $row['ANTICIPOS']; ?></strong></td>
       </tr>
     </table>
     </br>
     <table class="table-c">
       <tr>
         <h3><td style="width: 50%" align="left"><strong>RECIBI CONFORME: ________________________________<strong></td><h3>
         <h3><td style="width: 50%" align="right"><strong>NETO A PAGAR: $<?php echo $row['TOTAL']; ?> <br>BANCO: <?php echo $row['BANCO']; ?><br>CUENTA: <?php echo $row['CUENTA']; ?> <strong></td><h3>
       </tr>
     </table>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    
<?php
  }
  ?>



  </div>
</div>
</body>
</html>


<script type="text/javascript">
  window.print();
   window.close();
</script>
