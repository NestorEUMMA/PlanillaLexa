<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

    $Empleado = $_POST['Empleado'];
    $anio = date("Y");
    $Fecha = ''.$anio.'-12-12';
		$FechaIni = ''.$anio.'-12-01';
		$FechaFin = ''.$anio.'-12-15';

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

    $Contratacion = 'select FechaContratacion from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Contratacion);
    $ResultadoParametro = mysqli_fetch_row($SQL);
    $FechaContratacion = $ResultadoParametro[0];


    $Salario = 'select SalarioNominal from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Salario);
    $ResultadoParametro = mysqli_fetch_row($SQL);
    $SalarioBase = $ResultadoParametro[0];

    $datetime1 = date_create($FechaContratacion);
    $datetime2 = date_create($Fecha);
    $intervalo = date_diff($datetime1, $datetime2);
    $dias = $intervalo->format('%a');

    if($dias >= 1 and $dias <= 364){
       $Aguinaldo = (($SalarioBase/2)/365)*$dias;
    }
    elseif($dias >= 365 and $dias <= 1095){
       $Aguinaldo = ($SalarioBase/30)*15;
    }
    elseif($dias >= 1096 and $dias <= 3650){
       $Aguinaldo = ($SalarioBase/30)*19;
    }

    else {
          $Aguinaldo = ($SalarioBase/30)*21;
    }


		$SalarioMinimoConf = "SELECT (SalarioMinimo * 2) from configuraciongeneral where IdConfiguracion = 1";
		$SQL = $mysqli->query($SalarioMinimoConf);
		$ResultadoParametro = mysqli_fetch_row($SQL);
		$SalarioMinimoPorDos = $ResultadoParametro[0];



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
																		 if($Aguinaldo < $SalarioMinimoPorDos){
																			 $insertrptrenta = "INSERT INTO rptrentaanual(IdEmpleado, Nit, Descripcion, CodigoIngreso, AguinaldoExento, AguinaldoGravado, Anio, Mes, FechaCreacion)"
																																				 . "VALUES ('$Empleado', '$Nit','AGUINALDO', '01','$Aguinaldo',0.00, '$anio','$mes','$Fecha')";
																			 $resultadoinsertplanilla = $mysqli->query($insertrptrenta);
																		 }
																		 else {
																			 $insertrptrenta = "INSERT INTO rptrentaanual(IdEmpleado, Nit, Descripcion, CodigoIngreso,AguinaldoExento,AguinaldoGravado, Anio, Mes, FechaCreacion)"
																																				 . "VALUES ('$Empleado', '$Nit','AGUINALDO', '01',0.00,'$Aguinaldo', '$anio','$mes','$Fecha')";
																			 $resultadoinsertplanilla = $mysqli->query($insertrptrenta);
																		 }
																 }


																 }


     $insert = "INSERT INTO aguinaldos(IdEmpleado,PeridoAguinaldo,FechaAguinaldo,MontoAguinaldo)"
                        . "VALUES ('$Empleado','$anio','$Fecha','$Aguinaldo')";
     $resultadoinsert = $mysqli->query($insert);
      $last_id = $mysqli->insert_id;


     header('Location: ../../web/aguinaldos/view?id='.$last_id);
?>
</body>
</html>
