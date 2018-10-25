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
require("../NumeroALetras.php");
require("../FechaALetras.php");


$id =$_REQUEST['IdEmpleado'];

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
e.FechaContratacion as 'FechaContratacion',
e.HerramientasTrabajo as HerramientasTrabajo,
e.Dependiente1 as Dependiente1,
TIMESTAMPDIFF(YEAR, e.FNacimientoDep1,CURDATE()) AS Edad1,
e.Dependiente2 as Dependiente2,
TIMESTAMPDIFF(YEAR, e.FNacimientoDep2,CURDATE()) AS Edad2,
e.Dependiente3 as Dependiente3,
TIMESTAMPDIFF(YEAR, e.FNacimientoDep3,CURDATE()) AS Edad3,
pu.DescripcionPuestoEmpresa as 'PuestoEmpresa',
de.DescripcionDepartamentoEmpresa as 'DepartamentoEmpresa'
from empleado e
left join estadocivil es on e.IdEstadoCivil = es.IdEstadoCivil
inner join departamentoempresa de on e.IdDepartamentoEmpresa = de.IdDepartamentoEmpresa
inner join puestoempresa pu on e.IdPuestoEmpresa = pu.IdPuestoEmpresa
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
  $contratacion = $test['FechaContratacion'];
  $puestoempresa = $test['PuestoEmpresa'];
  $departamentoempresa = $test['DepartamentoEmpresa'];

}

$n = $salario;
$aux = (string) $n;
$decimal = substr( $aux, strpos( $aux, "." ) );
$centavos = str_replace('.',"", $decimal );

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

$SalarioRenta = $salario * 0.10;
$Salarioliquido = $salario - $SalarioRenta;

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
            <center><strong>CONSTANCIA DE SALARIO</strong></center>
            <strong><small><?php echo $direccionempresa; ?></small></strong>
          </br><strong><small><?php echo $nitempresa; ?></small></strong>
        </center>
      </h4>
      </div>
    </div>
<center>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <p align="justify">
      </br></br>A QUIEN INTERESE </br></br></br>

      Por medio de la presente se hace constar que <strong> <?php echo $nombre; ?> </strong> labora en esta Institución <strong><?php echo $empresa; ?></strong>
      desde el <?php echo strtoupper(obtenerFechaEnLetra($contratacion));?>, desempeñando el cargo de <strong> <?php echo $puestoempresa; ?> </strong> en el
      area de <strong> <?php echo $departamentoempresa; ?> </strong> y devengando actualmente un salario mensual de <?php echo $SalarioLetras =  NumeroALetras::convertir($salario, 'DOLARES', 'CENTAVOS') ?>
      <?php echo $centavos; ?>/100 (<strong> $<?php echo $salario; ?> </strong>), haciéndole las siguientes deducciones:
      </p>

    </div>
    <div class="col-md-4 col-md-offset-4">
      <p><center>
        Servicios Profesionales: <?php echo $salario; ?> </br>
        Deduccion:</br>
        Renta: <?php  echo number_format($SalarioRenta,2);  ?> </br>
        Liquido: <?php echo number_format($Salarioliquido,2); ?>
      </p>
    </center>
    </div>
    <div class="col-md-8 col-md-offset-2">
      <p align="justify">
        Y para los usos que <?php echo $nombre ?>  estime conveniente se le extiende la presente a los
        <?php echo $dias = NumeroALetras::convertir($dia); ?> DÍAS DEL MES DE <?php echo strtoupper($mes);?> DE <?php echo $anios = NumeroALetras::convertir($anio);?>
      </p>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <p><center>
          <strong><?php echo $emnombre?></br>
          REPRESENTANTE LEGAL</br></strong>
      </p></center>
    </div>

</div>

</center>

  </div>
</div>
</body>
</html>
