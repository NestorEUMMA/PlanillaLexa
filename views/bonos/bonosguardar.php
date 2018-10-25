<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();


$queryconfiguraciongeneral = "SELECT BonosConfig from configuraciongeneral where IdConfiguracion = 1";
$resultadoconfiguraciongeneral = $mysqli->query($queryconfiguraciongeneral);

while ($test = $resultadoconfiguraciongeneral->fetch_assoc())
					 {
							 $BonosConfig = $test['BonosConfig'];
					 }

    $Empleado = $_POST['Empleado'];
    $Bono = $_POST['Bono'];
    $Concepto = $_POST['Concepto'];
    $Fecha = $_POST['Fecha'];



		$ParametroTipo = 'SELECT Tipo FROM parametrosplanilla ORDER BY IdParametroPlanilla DESC LIMIT 1';
		$SQL = $mysqli->query($ParametroTipo);
		$ResultadoParametroTipo = mysqli_fetch_row($SQL);
		$Tipo = $ResultadoParametroTipo[0];

		$ParametroSalarioRentaLimite = "SELECT TramoDesde FROM tramoisr WHERE TramoFormaPago = '$Tipo' and NumTramo = 'Tramo 2'";
		$SQL = $mysqli->query($ParametroSalarioRentaLimite);
		$ResultadoParametroSalarioRentaLimite = mysqli_fetch_row($SQL);
		$TramoDesde = $ResultadoParametroSalarioRentaLimite[0];

		$anio = date("Y");
		$meses = date("m");

		$FechaIni = ''.$anio.'-'.$meses.'-01';
		$FechaFin = ''.$anio.'-'.$meses.'-15';

    $Parametro = 'select ISRParametro from parametros where IdParametro = 1';
    $SQL = $mysqli->query($Parametro);
    $ResultadoParametro = mysqli_fetch_row($SQL);

		$querynitempleado = "SELECT Nit as 'NIT' from empleado where IdEmpleado = '$Empleado'";
		$resultadonitempleado = $mysqli->query($querynitempleado);

		while ($test = $resultadonitempleado->fetch_assoc())
							 {
									 $Nit = $test['NIT'];
							 }

    $BonoISR = $Bono * $ResultadoParametro[0];

    $MontoPagarBonoISR = $Bono -  $BonoISR;

		// --------------------AFP----------------
				$TramoAfp = 'select TramoAfp from tramoafp where IdTramoAfp = 1';
				$SQL = $mysqli->query($TramoAfp);
				$ResultadoAFPtramo = mysqli_fetch_row($SQL);
				$AFPTRAMO = $ResultadoAFPtramo[0];

				$BonoAFP = $Bono * $AFPTRAMO;

		// --------------------ISSS----------------
				$TramoIsss = 'select TramoIsss from tramoisss where IdTramoIsss = 1';
				$SQL = $mysqli->query($TramoIsss);
				$ResultadoIsssTramo = mysqli_fetch_row($SQL);
				$AFPISSS = $ResultadoIsssTramo[0];
				$BonoISSS = $Bono * $AFPISSS;

		// --------------------PAGAR CON AFP ISSS----------------
				$MontoPagarBono = $Bono - $BonoAFP - $BonoISSS;



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



		if($BonosConfig == 0) //ISR
		{
			$insertplanilla = "INSERT INTO planilla(IdEmpleado, FechaTransaccion, Bono, ISRPlanilla ,MesPlanilla, AnioPlanilla)"
												 . "VALUES ('$Empleado','$Fecha', '$Bono', '$BonoISR', '$mes', '$anio')";
			$resultadoinsertplanilla = $mysqli->query($insertplanilla);

			$insertrptrenta = "INSERT INTO rptrentaanual(IdEmpleado, Nit, Descripcion, CodigoIngreso, MontoDevengado ,ImpuestoRetenido, Anio, Mes, FechaCreacion)"
									 											. "VALUES ('$Empleado','$Nit','BONOS', '11','$Bono', '$BonoISR', '$anio', '$mes','$Fecha')";
			$resultadoinsertplanilla = $mysqli->query($insertrptrenta);

	    $insert = "INSERT INTO bonos(IdEmpleado, MontoBono, MesPeriodoBono, AnoPeriodoBono, FechaBono, ConceptoBono, MontoPagarBono, MontoISRBono)"
	                       . "VALUES ('$Empleado','$Bono', '$mes','$anio', '$Fecha', '$Concepto', '$MontoPagarBonoISR', ' $BonoISR')";
	    $resultadoinsert = $mysqli->query($insert);
	    $last_id = $mysqli->insert_id;
		}
		else{ //ISSS-AFP
			$insertplanilla = "INSERT INTO planilla(IdEmpleado, FechaTransaccion, Bono, IsssPlanilla,AFPPLanilla, MesPlanilla, AnioPlanilla)"
												 . "VALUES ('$Empleado','$Fecha', '$Bono', '$BonoISSS','$BonoAFP','$mes', '$anio')";
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
																				 $insertrptrenta = "INSERT INTO rptrentaanual(IdEmpleado, Nit, Descripcion, CodigoIngreso, MontoDevengado ,Isss, Afp, Anio, Mes, FechaCreacion)"
 																										 											. "VALUES ('$Empleado','$Nit','BONOS', '01','$Bono', '$BonoISSS', '$BonoAFP', '$anio','$mes','$Fecha')";
 																				$resultadoinsertplanilla = $mysqli->query($insertrptrenta);
																		 }
																	 }


			$insert = "INSERT INTO bonos(IdEmpleado, MontoBono, MesPeriodoBono, AnoPeriodoBono, FechaBono, ConceptoBono, MontoPagarBono, ISSSBono, AFPBono)"
												 . "VALUES ('$Empleado','$Bono', '$mes','$anio', '$Fecha', '$Concepto', '$MontoPagarBono', '$BonoISSS','$BonoAFP')";
			$resultadoinsert = $mysqli->query($insert);
			$last_id = $mysqli->insert_id;
		}

      header('Location: ../../web/bonos/view?id='.$last_id);
		



?>

</body>
</html>
