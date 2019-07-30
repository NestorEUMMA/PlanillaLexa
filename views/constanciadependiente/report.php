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
$Tipo = 'MENSUAL';
$queryempresa = "select
em.NombreEmpresa, em.Direccion, em.NitEmpresa, em.GiroFiscal, em.Representante
from empresa em
inner join departamentos d on em.IdDepartamentos = d.IdDepartamentos
where em.IdEmpresa = 1";
$resultadoqueryempresa = $mysqli->query($queryempresa);
while ($test = $resultadoqueryempresa->fetch_assoc())
{
  $empresa = $test['NombreEmpresa'];
  $direccionempresa = $test['Direccion'];
  $nitempresa = $test['NitEmpresa'];
  $giro = $test['GiroFiscal'];
  $emnombre = $test['Representante'];

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

$TramoAfp = 'select TramoAfp from tramoafp where IdTramoAfp = 1';
$SQL = $mysqli->query($TramoAfp);
$ResultadoAFPtramo = mysqli_fetch_row($SQL);
$AFPTRAMO = $ResultadoAFPtramo[0];

$SalarioAFP = $salario * $AFPTRAMO;

$TramoIsss = 'select TramoIsss from tramoisss where IdTramoIsss = 1';
$SQL = $mysqli->query($TramoIsss);
$ResultadoIsssTramo = mysqli_fetch_row($SQL);
$AFPTRAMO = $ResultadoIsssTramo[0];

$SalarioISSS = $salario * $AFPTRAMO;

$queryrentas = "SELECT E.Nit as 'NIT' ,E.IdEmpleado as 'IDEMPLEADO', CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',

  /**************************** CALCULO SALARIO **************************/
    (CONVERT((E.SalarioNominal), DECIMAL(10,2)) 
)
  AS 'SALARIO',

  (CASE
  WHEN ( CASE
  WHEN E.DeducIsssAfp = 1 THEN
  CASE  /* TRAMO 1 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2)))

  * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
  >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.03)), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.00), DECIMAL(10,2))

  /* TRAMO 2 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 3 */
  WHEN CONVERT( (CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
  THEN
  CASE
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) -
  (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 4 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (
  ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END


  /* ISR PARA PENSIONADOS*/
  WHEN E.Pensionado = 1 THEN
  CASE  /* TRAMO 1 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
  >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.03)), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.00), DECIMAL(10,2))

  /* TRAMO 2 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2)))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 3 */
  WHEN CONVERT( (CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN
  CASE
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2)))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  WHEN  CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) -
  (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT((((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 4 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (
  ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT((((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT(((( ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END

  /* CALCULO DE IPSFA CON ISSS PARA ISR */
  WHEN E.DeducIsssIpsfa = 1 THEN
  CASE  /* TRAMO 1 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
  >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.03)), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.00), DECIMAL(10,2))

  /* TRAMO 2 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 3 */
  WHEN CONVERT( (CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
  THEN
  CASE
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) -
  (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 4 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (
  ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  /* CALCULO DE IPSFA CON ISSS PARA ISR */
  WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.10), DECIMAL(10,2))
  END) IS NULL THEN 0.00 ELSE
  ( CASE
  WHEN E.DeducIsssAfp = 1 THEN
  CASE  /* TRAMO 1 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
  >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.03)), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.00), DECIMAL(10,2))

  /* TRAMO 2 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 3 */
  WHEN CONVERT( (CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
  THEN
  CASE
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) -
  (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 4 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (
  ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  /* CALCULO DE IPSFA CON ISSS PARA ISR */
  WHEN E.DeducIsssIpsfa = 1 THEN
  CASE  /* TRAMO 1 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
  >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.03)), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.00), DECIMAL(10,2))

  /* TRAMO 2 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 3 */
  WHEN CONVERT( (CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
  THEN
  CASE
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) -
  (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 4 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (
  ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END


  /* ISR PARA PENSIONADOS*/
  WHEN E.Pensionado = 1 THEN
  CASE  /* TRAMO 1 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
  >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.03)), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.00), DECIMAL(10,2))

  /* TRAMO 2 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2)))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 3 */
  WHEN CONVERT( (CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN
  CASE
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  AND CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT(((((CONVERT((E.SalarioNominal), DECIMAL(10,2)))
  - ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  WHEN  CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) -
  (((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
  (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
  THEN CONVERT((((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  /* TRAMO 4 */
  WHEN CONVERT((CONVERT((E.SalarioNominal), DECIMAL(10,2))) - (
  ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
  (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
  AND (CONVERT((E.SalarioNominal), DECIMAL(10,2))) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT((((((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

  WHEN (CONVERT((E.SalarioNominal), DECIMAL(10,2))) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
  THEN CONVERT(((( ((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
  - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
  + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
  END
  /* CALCULO DE IPSFA CON ISSS PARA ISR */
  WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal), DECIMAL(10,2))) * 0.10), DECIMAL(10,2))
  END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) ) IS NULL THEN 0.00 ELSE (SELECT SUM(P.ISRPlanilla) ) END)
  END) AS 'RENTA'

  FROM Empleado E
LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 0 and E.IdEmpleado  = '$id'";

  $resultadoquery = $mysqli->query($queryrentas);
  while ($test = $resultadoquery->fetch_assoc())
  {
    $renta = $test['RENTA'];
  }

  $MontoPagarSalario = $salario - $SalarioAFP - $SalarioISSS - $renta ;
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

$TramoAfp = 'select TramoAfp from tramoafp where IdTramoAfp = 1';
$SQL = $mysqli->query($TramoAfp);
$ResultadoAFPtramo = mysqli_fetch_row($SQL);
$AFPTRAMO = $ResultadoAFPtramo[0];

$SalarioAFP = $salario * $AFPTRAMO;

$TramoIsss = 'select TramoIsss from tramoisss where IdTramoIsss = 1';
$SQL = $mysqli->query($TramoIsss);
$ResultadoIsssTramo = mysqli_fetch_row($SQL);
$AFPTRAMO = $ResultadoIsssTramo[0];

$SalarioISSS = $salario * $AFPTRAMO;

$MontoPagarSalario = $salario - $SalarioAFP - $SalarioISSS;


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
  <div class="card">
          <div class="card-header card-header-icon" data-background-color="orange">
              <i class="material-icons">mail_outline</i>
          </div>
          <div class="card-content">
                <h4 class="card-title">Constancia de Salario Dependiente</h4>
                <div class="row">
                  <div class="col-xs-12">
                    <h4 class="page">
                      <center><strong><?php echo $empresa; ?></strong>
                        <center><strong>CONSTANCIA DE SALARIO</strong></center>
                        <strong><small><?php echo $direccionempresa; ?></small></strong>
                      </br><strong><small><?php echo $nitempresa; ?></small></strong>
                    </center>
                  </h4>
                </div>
                </div>
                </br>
                <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                    <p align="justify">
                    A QUIEN INTERESE </br></br></br></br>

                    Por medio de la presente se hace constar que <strong> <?php echo $nombre; ?> </strong> labora en esta Institución <strong><?php echo $empresa; ?></strong>
                    desde el <?php echo strtoupper(obtenerFechaEnLetra($contratacion));?>, desempeñando el cargo de <strong> <?php echo $puestoempresa; ?> </strong> en el
                    area de <strong> <?php echo $departamentoempresa; ?> </strong> y devengando actualmente un salario mensual de <?php echo $SalarioLetras =  NumeroALetras::convertir($salario, 'DOLARES', 'CENTAVOS') ?>
                    <?php echo $centavos; ?>/100 (<strong> $<?php echo $salario; ?> </strong>), haciéndole las siguientes deducciones:
                    </p>

                  </div>
                  <div class="col-md-4 col-md-offset-4">
                    <p><center>
                      Salario: $<?php echo $salario; ?> </br>
                      Deduccion:</br>
                      ISSS: $<?php  echo number_format($SalarioISSS,2);  ?> </br>
                      AFP: $<?php  echo number_format($SalarioAFP,2);  ?> </br>
                      RENTA: $<?php  echo number_format($renta,2);  ?> </br></br>
                      Liquido: $<?php echo number_format($MontoPagarSalario,2); ?>
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
                  <div class="col-xs-12">
                    <center>
                      <a href="../constanciadependiente/index" class="btn btn-warning"></i> REGRESAR</a>
                    <button class="btn btn-success btn-raised btn-success" onclick="javascript:window.imprimirDIV('ID_DIV');">Imprimir </button>
                  </center>
                </div>
          </div>
      </div>

        <div id="ID_DIV" class="hidden">
        </br></br>
                  <center>
                    <div class="row">
                      <div class="col-xs-12">
                        <h4 class="page">
                          <center><strong><?php echo $empresa; ?></strong>
                            <center><strong>CONSTANCIA DE SALARIO </strong></center>
                            <strong><small><?php echo $direccionempresa; ?></small></strong>
                          </br><strong><small><?php echo $nitempresa; ?></small></strong>
                        </center>
                      </h4>
                    </div>
                    </div>
                    </br>
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
                            Salario: $<?php echo $salario; ?> </br>
                            Deduccion:</br>
                            ISSS: $<?php  echo number_format($SalarioISSS,2);  ?> </br>
                            AFP: $<?php  echo number_format($SalarioAFP,2);  ?> </br>
                            RENTA: $<?php  echo number_format($renta,2);  ?> </br></br>
                            Liquido: $<?php echo number_format($MontoPagarSalario,2); ?>
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
