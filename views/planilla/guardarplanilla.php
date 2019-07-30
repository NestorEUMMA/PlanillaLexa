<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();




      $FechaIni = str_replace('/',"-", $_POST['FechaIni'] );
      $FechaFin = str_replace('/',"-", $_POST['FechaFin'] );
      $Tipo = $_POST['Tipo'];
      $mesfecha = substr($FechaFin, 5, 2);



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
			$hoy = (new \DateTime())->format('Y-m-d');




			$queryvalidacionplanilla = "select * from parametrosplanilla where MesPlanilla = '$mes' and PeriodoPlanilla = '$anio' and QuincenaPlanilla = '$quincena'";
			$resultqueryvalidacionplanilla = $mysqli->query($queryvalidacionplanilla);

			if(mysqli_num_rows($resultqueryvalidacionplanilla)==0){

		$queryparametrosplanilla = "insert into parametrosplanilla
												(FechaCreacion,MesPlanilla,PeriodoPlanilla,QuincenaPlanilla,FechaIni,FechaFin,Tipo)
										values
												('$hoy','$mes','$anio',$quincena,'$FechaIni','$FechaFin','$Tipo')
										";
		$resultparametrosplanilla = $mysqli->query($queryparametrosplanilla);





	$queryplanillarenta = "SELECT E.Nit as 'NIT' ,E.IdEmpleado as 'IDEMPLEADO', CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',

	/**************************** CALCULO SALARIO **************************/
	(CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	AS 'SALARIO',

	/************************ CALCULO ISSS **********************************/
	(CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
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
	END
	WHEN E.DeducIsssIpsfa = 1  THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	))

	<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

	THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	))

	* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
	THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	END

	WHEN E.Pensionado = 1  THEN
	CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)) * 0.00), DECIMAL(10,2))



	WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)) * 0.00), DECIMAL(10,2))
	END) AS 'ISSS',



	/*********************** CALCULO AFP ************************************/
	(CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
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
	END


	WHEN E.Pensionado = 1 THEN
	CASE
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
	END


	WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)) * 0.00), DECIMAL(10,2))
	END) AS 'AFP',

	/********************************** CALCULO IPSFA  *****************************/
	CASE
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
	END
	WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	END AS 'IPSFA',



	/****************************** CALCULO RENTA ISR **************************/
	(CASE
	WHEN ( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)

	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END


	/* ISR PARA PENSIONADOS*/
	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END

	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) IS NULL THEN 0.00 ELSE
	( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END


	/* ISR PARA PENSIONADOS*/
	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0.00 ELSE (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)
	END) AS 'RENTA'

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
	group by E.IdEmpleado";


		$resultadoqueryplanillarenta = $mysqli->query($queryplanillarenta);

		$ttotsalario = 0;
		$ttotisss = 0;
		$ttotafp = 0;
		$ttotipsfa = 0;
		$ttotrenta = 0;


		while ($test = $resultadoqueryplanillarenta->fetch_assoc())
							 {
									 $ttotsalario += $test['SALARIO'];
									 $ttotisss += $test['ISSS'];
									 $ttotafp += $test['AFP'];
									 $ttotipsfa += $test['IPSFA'];
									 $ttotrenta +=  $test['RENTA'];

									 $idempleado = $test['IDEMPLEADO'];
									 $nit = $test['NIT'];
									 $totsalario = $test['SALARIO'];
									 $totisss = $test['ISSS'];
									 $totafp = $test['AFP'];
									 $toipsfa = $test['IPSFA'];
									 $totrenta =  $test['RENTA'];


									 $insertrptrenta = "INSERT INTO rptrentaanual(IdEmpleado, Nit, Descripcion, CodigoIngreso, MontoDevengado ,Isss, Afp, Anio, Mes,ImpuestoRetenido,AguinaldoGravado,AguinaldoExento,ipsfa,FechaCreacion,Quincena)"
 																										. "VALUES ('$idempleado','$nit' ,'SALARIO', '01','$totsalario', '$totisss', '$totafp', '$anio','$mes','$totrenta',0,0,'$toipsfa','$hoy','$quincena')";
 									$resultadoinsertplanilla = $mysqli->query($insertrptrenta);

								 	}






								 	

	$querytotplanilla = "SELECT E.SalarioNominal as 'SALARIONOMINAL', pu.DescripcionPuestoEmpresa as 'PUESTOEMPRESA', E.IdEmpleado as 'IDEMPLEADO', CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',

	/**************************** CALCULO SALARIO **************************/
	(CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	AS 'SALARIO',


	15 - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	THEN 0 ELSE (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END )
	- (CASE WHEN (SELECT SUM(P.DiasPermiso) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	THEN 0 ELSE (SELECT SUM(P.DiasPermiso) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END ) as 'DIAS',



	/************************** CALCULO COMISIONES + BONOS SEGUN FECHA *******************************/
	CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') END + CASE WHEN ( SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END + CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END as 'EXTRA',


	/************************* CALCULO SUMA DE SALARIO + COMISIONES + BONOS SEGUN FECHA *******************************/
	CASE
	WHEN
	(CASE
	WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	+
	CASE
	WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	+
	CASE
	WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	IS NULL THEN 0 ELSE
	(CASE WHEN
	(SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
	+
	CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT  SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	+
	CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT  SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+ (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	END AS 'TOTALSALARIO',




	/************************ CALCULO ISSS **********************************/
	(CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	*
	(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	END
	WHEN E.DeducIsssIpsfa = 1  THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))

	<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

	THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))

	* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
	THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	END

	WHEN E.Pensionado = 1  THEN
	CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
	+ CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))



	WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END +
	CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))
	END) AS 'ISSS',

	/*********************** CALCULO AFP ************************************/
	(CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	END


	WHEN E.Pensionado = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	END


	WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END)) * 0.00), DECIMAL(10,2))
	END) AS 'AFP',

	/********************************** CALCULO IPSFA  *****************************/
	CASE
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
	END
	WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	END AS 'IPSFA',

	/****************************** CALCULO RENTA ISR **************************/
	(CASE
	WHEN ( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)

	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END


	/* ISR PARA PENSIONADOS*/
	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END

	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) IS NULL THEN 0.00 ELSE
	( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END


	/* ISR PARA PENSIONADOS*/
	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0.00 ELSE (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)
	END) +
	CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END) ELSE 0.00 END)
	+
	(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END) ELSE 0.00 END)
	+

	(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END)ELSE 0.00 END),DECIMAL(10,2)) AS 'RENTA',





	/********************************** CALCULO SUMA ISSS + AFP + RENTA GLOBAL ********************************/
	(CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	*
	(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	END


	WHEN E.Pensionado = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	END


	WHEN E.DeducIsssIpsfa = 1  THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))

	<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

	THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))

	* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
	THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	END

	WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END + CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))
	END)

	+

	(CASE
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
	END
	WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	END)

	+
	(CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	END


	WHEN E.Pensionado = 1  THEN
	CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END + CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))


	WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END)) * 0.00), DECIMAL(10,2))
	END)
	+
	(CASE
	WHEN ( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END


	/* PENSIONADOS 1 */

	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END


	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) IS NULL THEN 0 ELSE
	( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END

	/* PENSIONADOS 1 */

	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)
	END) +
	CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END) ELSE 0.00 END)
	+
	(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END) ELSE 0.00 END)
	+

	(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END)ELSE 0.00 END),DECIMAL(10,2))
	AS 'TOTALPERCEPCION',









	/********************************** CALCULO ANTICIPOS ********************************/

	(CASE WHEN (SELECT SUM(Anticipos)  where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL THEN 0.00 ELSE (SELECT SUM(Anticipos)
	where FechaTransaccion between '$FechaIni' and '$FechaFin') END)

	as 'ANTICIPOS',








	/********************************** CALCULO SALARIO LIQUIDO ********************************/

	(CASE WHEN

	(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
	+
	CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
	+
	CASE WHEN
	(SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END) IS NULL
	THEN 0 ELSE
	(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
	+
	CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
	+
	CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)

	+ (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)END)

	-
	(CASE WHEN (SELECT SUM(Anticipos)  where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL THEN 0.00 ELSE (SELECT SUM(Anticipos)  where FechaTransaccion between '$FechaIni' and '$FechaFin')  END)

	-

	((CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	*
	(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	END

	WHEN E.Pensionado = 1  THEN
	CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END + CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))


	WHEN E.DeducIsssIpsfa = 1  THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))

	<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

	THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))

	* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
	THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
	END

	WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END +
	CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))
	END)

	+

	(CASE
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
	END
	WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))
	END)

	+
	(CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	END

	WHEN E.Pensionado = 1 THEN
	CASE
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END))
	>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
	END

	WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)+
	  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +
	  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	    END) ELSE 0.00 END)
	    +

	  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
	          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	  END)ELSE 0.00 END)) * 0.00), DECIMAL(10,2))
	END)

	+

	(CASE
	WHEN ( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* PENSIONADOS 1 */

	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) IS NULL THEN 0 ELSE
	( CASE
	WHEN E.DeducIsssAfp = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.DeducIsssIpsfa = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END

	/* PENSIONADOS 1 */

	WHEN E.Pensionado = 1 THEN
	CASE  /* TRAMO 1 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
	>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.03)), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.00), DECIMAL(10,2))

	/* TRAMO 2 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 3 */
	WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN
	CASE
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	)
	- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END
	WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) -
	(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
	(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	/* TRAMO 4 */
	WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) - (
	((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
	(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
	AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

	WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
	THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
	- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
	+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
	END


	/* CALCULO DE IPSFA CON ISSS PARA ISR */
	WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
	CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END  -

	CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
	  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END
	) * 0.10), DECIMAL(10,2))
	END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)
	END)

	) +
	CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END) ELSE 0.00 END)
	+
	(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END) ELSE 0.00 END)
	+

	(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
	(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
	THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
	END)ELSE 0.00 END),DECIMAL(10,2))
	AS 'SALARIOLIQUIDO'

		FROM Empleado E
		LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
		LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
		WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 0
		group by E.IdEmpleado";



	$resultadoquerytotplanilla = $mysqli->query($querytotplanilla);

	$ttotsalario = 0;
	$ttotextras = 0;
	$ttotsalariotot = 0;
	$ttotisss = 0;
	$ttotafp = 0;
	$ttotipsfa = 0;
	$ttotrenta = 0;
	$ttotprecepcion = 0;
	$ttotanticipos = 0;
	$ttotsalarioliquido = 0;
		$ttotsalarionominal = 0;

	while ($test = $resultadoquerytotplanilla->fetch_assoc())
	           {
	               $ttotsalario += $test['SALARIO'];
	               $ttotextras += $test['EXTRA'];
	               $ttotsalariotot += $test['TOTALSALARIO'];
	               $ttotisss += $test['ISSS'];
	               $ttotafp += $test['AFP'];
	               $ttotipsfa += $test['IPSFA'];
	               $ttotrenta +=  $test['RENTA'];
	               $ttotprecepcion +=  $test['TOTALPERCEPCION'];
	               $ttotanticipos +=  $test['ANTICIPOS'];
	               $ttotsalarioliquido +=  $test['SALARIOLIQUIDO'];
								 $ttotsalarionominal +=  $test['SALARIONOMINAL'];

	               $idempleado = $test['IDEMPLEADO'];
	               $nombreCom = $test['NOMBRECOMPLETO'];
	               $totsalario = $test['SALARIO'];
	               $totextras = $test['EXTRA'];
	               $totsalariotot = $test['TOTALSALARIO'];
	               $totisss = $test['ISSS'];
	               $totafp = $test['AFP'];
	               $toipsfa = $test['IPSFA'];
	               $totrenta =  $test['RENTA'];
	               $totprecepcion =  $test['TOTALPERCEPCION'];
	               $totanticipos =  $test['ANTICIPOS'];
	               $totsalarioliquido =  $test['SALARIOLIQUIDO'];
								 $totsalarionominal =  $test['SALARIONOMINAL'];


	               $queryInsResp = "insert into rptplanilla
	                                   (IdEmpleado,PRptSalario,PRptExtras,PRptTotal,PRptIsss,PRptAfp,PRptRenta,PRptPercepcion,PRptAnticipo,PRptLiquido,RptPeriodo,RptAnio,RptQuincena,PRptIpsfa,PRrtSalarioNominal)
	                               values
	                                   ($idempleado,$totsalario,$totextras,$totsalariotot,$totisss,$totafp,$totrenta,$totprecepcion,$totanticipos,$totsalarioliquido,'$mes',$anio,$quincena,$toipsfa,$totsalarionominal)
	                               ";
	               $resultInsResp = $mysqli->query($queryInsResp);

  						 header('Location: ../../web/planilla/index');
	           }

			}

			else{
				echo '<script>alert("La Planilla ha sido generada");</script>';
				//echo $queryvalidacionplanilla;
			}




?>
</body>
</html>
