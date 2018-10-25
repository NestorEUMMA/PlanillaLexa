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

<?php include '../../include/dbconnect.php'; ?>
<?php


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


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
      p {
        font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif ;
    }
  </style>
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <div class="invoice">
    <!-- title row -->

<center>
  <div class="row">
    <h4>
    <div class="col-md-10 col-md-offset-1">
    <p align="right"><br><br><strong> SAN SALVADOR, <?php echo $dia; ?> DE <?php echo strtoupper($mes);?> DE <?php echo $anio;?></strong><p><br><br>
    <p align="left">
      <STRONG>SEÑORES
      <?php echo $empresa; ?>
      <br>
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
      <br>
      <br>
      <?php echo $nombre; ?><br>
      DUI: <?php echo $dui; ?><br>
      NIT: <?php echo $nit; ?>
    </STRONG>
    </p>
  </h4>
</div>
  </div>

  <div class="row">
    <h4>
    <div class="col-md-10 col-md-offset-1">

    <p align="justify">
      <br>
      <br>
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
      <br>
      <br>
      <br>
      <?php echo $nombre; ?><br>
      DUI: <?php echo $dui; ?><br>
      NIT: <?php echo $nit; ?>
    </STRONG>
    </p>
  </h4>
</div>
  </div>

</center>

  </div>
</div>
</body>
</html>
