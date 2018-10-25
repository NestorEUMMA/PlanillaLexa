<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>

</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

$queryconfiguraciongeneral = "SELECT HonorariosConfig from configuraciongeneral where IdConfiguracion = 1";
$resultadoconfiguraciongeneral = $mysqli->query($queryconfiguraciongeneral);

while ($test = $resultadoconfiguraciongeneral->fetch_assoc())
					 {
							 $HonorariosConfig = $test['HonorariosConfig'];
					 }

    $Empleado = $_POST['Empleado'];
    $Honorario = $_POST['Honorario'];
    $Concepto = $_POST['Concepto'];
    $Fecha = $_POST['Fecha'];

		$querynitempleado = "SELECT Nit as 'NIT' from empleado where IdEmpleado = '$Empleado'";
		$resultadonitempleado = $mysqli->query($querynitempleado);

		while ($test = $resultadonitempleado->fetch_assoc())
							 {
									 $Nit = $test['NIT'];
							 }

	 $ParametroTipo = 'SELECT Tipo FROM parametrosplanilla ORDER BY IdParametroPlanilla DESC LIMIT 1';
		$SQL = $mysqli->query($ParametroTipo);
		$ResultadoParametroTipo = mysqli_fetch_row($SQL);
		$Tipo = $ResultadoParametroTipo[0];

		$ParametroSalarioRentaLimite = "SELECT TramoDesde FROM tramoisr WHERE TramoFormaPago = '$Tipo' and NumTramo = 'Tramo 2'";
		$SQL = $mysqli->query($ParametroSalarioRentaLimite);
		$ResultadoParametroSalarioRentaLimite = mysqli_fetch_row($SQL);
		$TramoDesde = $ResultadoParametroSalarioRentaLimite[0];

    $Parametro = 'select ISRParametro from parametros where IdParametro = 1';
    $SQL = $mysqli->query($Parametro);
    $ResultadoParametro = mysqli_fetch_row($SQL);

  // --------------------ISR----------------
    $HonorarioISR = $Honorario * $ResultadoParametro[0];

	// --------------------PAGAR ISR----------------
    $MontoPagarHonorarioISR = $Honorario - $HonorarioISR;

// --------------------AFP----------------
		$TramoAfp = 'select TramoAfp from tramoafp where IdTramoAfp = 1';
		$SQL = $mysqli->query($TramoAfp);
		$ResultadoAFPtramo = mysqli_fetch_row($SQL);
		$AFPTRAMO = $ResultadoAFPtramo[0];

		$HonorarioAFP = $Honorario * $AFPTRAMO;

// --------------------ISSS----------------
		$TramoIsss = 'select TramoIsss from tramoisss where IdTramoIsss = 1';
		$SQL = $mysqli->query($TramoIsss);
		$ResultadoIsssTramo = mysqli_fetch_row($SQL);
		$AFPISSS = $ResultadoIsssTramo[0];
		$HonorarioISSS = $Honorario * $AFPISSS;

// --------------------PAGAR CON AFP ISSS----------------
		$MontoPagarHonorario = $Honorario - $HonorarioAFP - $HonorarioISSS;

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

		$meses = date("m");

		$FechaIni = ''.$anio.'-'.$meses.'-01';
		$FechaFin = ''.$anio.'-'.$meses.'-15';


		if($HonorariosConfig == 0) //ISR
		{
			$insertplanilla = "INSERT INTO planilla(IdEmpleado, FechaTransaccion, Honorario, ISRPlanilla, MesPlanilla, AnioPlanilla)"
												 . "VALUES ('$Empleado','$Fecha', '$Honorario', '$HonorarioISR','$mes', '$anio')";
			$resultadoinsertplanilla = $mysqli->query($insertplanilla);

			$insertrptrenta = "INSERT INTO rptrentaanual(IdEmpleado, Nit, Descripcion, CodigoIngreso, MontoDevengado,AguinaldoExento,AguinaldoGravado,ImpuestoRetenido, Anio, Mes, FechaCreacion,isss,afp,ipsfa)"
									 											. "VALUES ('$Empleado','$Nit','HONORARIO', '11','$Honorario',0,0,'$HonorarioISR', '$anio', '$mes','$Fecha',0,0,0)";
			$resultadoinsertplanilla = $mysqli->query($insertrptrenta);


			$insert = "INSERT INTO honorario(IdEmpleado,MontoHonorario,IdParametro,ConceptoHonorario,FechaHonorario,MesPeriodoHono,AnoPeriodoHono,MontoPagar,MontoISRHonorarios)"
	                       . "VALUES ('$Empleado','$Honorario', 1 , '$Concepto', '$Fecha','$mes','$anio', '$MontoPagarHonorarioISR','$HonorarioISR')";
	    $resultadoinsert = $mysqli->query($insert);
	    $last_id = $mysqli->insert_id;
		}
		else{ //ISSS-AFP
			$insertplanilla = "INSERT INTO planilla(IdEmpleado, FechaTransaccion, Honorario, IsssPlanilla,AFPPLanilla, MesPlanilla, AnioPlanilla)"
												 . "VALUES ('$Empleado','$Fecha', '$Honorario', '$HonorarioISSS','$HonorarioAFP','$mes', '$anio')";
			$resultadoinsertplanilla = $mysqli->query($insertplanilla);


			$salarioliquido = "SELECT e.IdEmpleado as 'IDEMPLEADO', ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -
											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											)
												-
												(CASE
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END))

											<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
											THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END))
											*
											(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
											END)
												-
											(CASE
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
											END)) as 'SALARIOLIQUIDO'



										FROM Empleado E
										LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
										LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
										WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 0
										AND ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -
											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											)
												-
												(CASE
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END))

											<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
											THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END))
											*
											(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
											END)
												-
											(CASE
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
											WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
											CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END  -

											CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
												THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
											END
											))
											>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
											END))  > (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
											and E.IdEmpleado = '$Empleado'";

											$resultadoquerysalarioliquido = $mysqli->query($salarioliquido);

											while ($test = $resultadoquerysalarioliquido->fetch_assoc())
																 {

																		 $totrenta =  $test['SALARIOLIQUIDO'];

																			 if($totrenta > $TramoDesde){
																				 $insertrptrenta = "INSERT INTO rptrentaanual(IdEmpleado, Nit, Descripcion, CodigoIngreso, MontoDevengado,AguinaldoExento,AguinaldoGravado ,Isss, Afp, Anio, Mes, FechaCreacion)"
 																																					. "VALUES ('$Empleado','$Nit','HONORARIO', '01','$Honorario',0,0,'$HonorarioISSS', '$HonorarioAFP', '$anio','$mes','$Fecha')";
 																				$resultadoinsertplanilla = $mysqli->query($insertrptrenta);
																		 }
																	 }




			$insert = "INSERT INTO honorario(IdEmpleado,MontoHonorario,IdParametro,ConceptoHonorario,FechaHonorario,MesPeriodoHono,AnoPeriodoHono,MontoPagar,ISSSHonorario,AFPHonorario)"
												 . "VALUES ('$Empleado','$Honorario', 1 , '$Concepto', '$Fecha','$mes','$anio', '$MontoPagarHonorario','$HonorarioISSS','$HonorarioAFP')";
			$resultadoinsert = $mysqli->query($insert);
			$last_id = $mysqli->insert_id;
		}



    header('Location: ../../web/honorario/view?id='.$last_id);


?>

</body>
</html>
