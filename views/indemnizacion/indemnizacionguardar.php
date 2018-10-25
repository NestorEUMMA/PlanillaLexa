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
		$FechaActual = date("Y-m-d");

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

		// CALCULO DE INDEMNIZACION
    $Contratacion = 'select FechaContratacion from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Contratacion);
    $ResultadoParametro = mysqli_fetch_row($SQL);
    $FechaContratacion = $ResultadoParametro[0];

    $Despido = 'select FechaDespido from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Despido);
    $ResultadoParametro1 = mysqli_fetch_row($SQL);
    $FechaDespido = $ResultadoParametro1[0];


    $Salario = 'select SalarioNominal from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Salario);
    $ResultadoParametro = mysqli_fetch_row($SQL);
    $SalarioBase = $ResultadoParametro[0];

    $datetime1 = date_create($FechaContratacion);
    $datetime2 = date_create($FechaDespido);
    $intervalo = date_diff($datetime1, $datetime2);
    $dias = $intervalo->format('%a');

    $Indemnizacion = ($SalarioBase/365)*$dias;


		// CALCULO DE VACACIONES PROPORCIONALES

		$UltimaFechaVac = 'SELECT FechaVacaciones FROM vacaciones WHERE IdEmpleado = '.$Empleado.' ORDER BY IdVacaciones DESC LIMIT 1';
		$SQL = $mysqli->query($UltimaFechaVac);
    $ResultadoParametro = mysqli_fetch_row($SQL);
    $UltimaFechaVacacion = $ResultadoParametro[0];

		$FechaVac1 = date_create($UltimaFechaVacacion);
    $FechaVac2 = date_create($FechaActual);
    $diferencia = date_diff($FechaVac1, $FechaVac2);
    $DiasVacacion = $diferencia->format('%a');


		if($DiasVacacion >= 1 and $DiasVacacion <= 364){
				$Montovacaciones = ((($SalarioBase/2)/365)*$DiasVacacion)*1.3;
		}
		else{
				$Montovacaciones = (((($SalarioBase/2))*1.3)/365)*$DiasVacacion;
		}

		// CALCULO DE AGUINALDOS PROPORCIONALES
			$UltimaFechaAgui = 'SELECT FechaAguinaldo FROM aguinaldos WHERE IdEmpleado = '.$Empleado.' ORDER BY IdAguinaldo DESC LIMIT 1';
			$SQL = $mysqli->query($UltimaFechaAgui);
			$ResultadoParametro = mysqli_fetch_row($SQL);
			$UltimaFechaAguinaldo = $ResultadoParametro[0];

			$FechaAgui1 = date_create($UltimaFechaVacacion);
	    $FechaAgui2 = date_create($FechaActual);
	    $diferenciaDias = date_diff($FechaAgui1, $FechaAgui2);
	    $DiasAguinaldo = $diferenciaDias->format('%a');

			if($dias >= 1 and $dias <= 364){
				 $Aguinaldo = (($SalarioBase/2)/365)*$dias;
			}
			elseif($dias >= 365 and $dias <= 1095){
				 $Aguinaldo = ((($SalarioBase/30)*15)/365)*$DiasAguinaldo;
			}
			elseif($dias >= 1096 and $dias <= 3650){
				 $Aguinaldo = ((($SalarioBase/30)*19)/365)*$DiasAguinaldo;
			}

			else {
						$Aguinaldo = ((($SalarioBase/30)*21)/365)*$DiasAguinaldo;
			}

		// INSERT DE VACACIONES PROPORCIONALES
		$insertvacaciones = "INSERT INTO vacaciones(IdEmpleado,MesPeriodoVacaciones,AnoPeriodoVacaciones,MontoVacaciones,FechaVacaciones)"
												 . "VALUES ('$Empleado','$mes','$anio','$Montovacaciones','$FechaActual')";
		$resultadoinsertvacas = $mysqli->query($insertvacaciones);

		// INSERT DE AGUINALDO PROPORCIONALES
		$insertaguinaldo = "INSERT INTO aguinaldos(IdEmpleado,PeridoAguinaldo,FechaAguinaldo,MontoAguinaldo)"
											 . "VALUES ('$Empleado','$anio','$FechaActual','$Aguinaldo')";
		$resultadoinsertaguinaldo = $mysqli->query($insertaguinaldo);


		// INSERT DE INDEMNIZACION
    $insert = "INSERT INTO indemnizacion(IdEmpleado,FechaIndemnizacion,MesPeriodoIndem,AnoPeriodoIndem,MontoIndemnizacion)"
                         . "VALUES ('$Empleado','$FechaDespido','$mes','$anio','$Indemnizacion')";
    $resultadoinsert = $mysqli->query($insert);
		$last_id = $mysqli->insert_id;

     header('Location: ../../web/indemnizacion/view?id='.$last_id);
		echo $insertaguinaldo;
?>
</body>
</html>
