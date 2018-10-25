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
    $Fecha = $_POST['Fecha'];

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

    $Despido = 'select FechaDespido from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Despido);
    $ResultadoParametro1 = mysqli_fetch_row($SQL);
    $FechaDespido = $ResultadoParametro1[0];


    $Salario = 'select SalarioNominal from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Salario);
    $ResultadoParametro = mysqli_fetch_row($SQL);
    $SalarioBase = $ResultadoParametro[0];

    $datetime1 = date_create($FechaContratacion);
    $datetime2 = date_create($Fecha);
    $intervalo = date_diff($datetime1, $datetime2);
    $dias = $intervalo->format('%a');


    if($dias >= 1 and $dias <= 364){
        $Montovacaciones = ((($SalarioBase/2)/365)*$dias)*1.3;
    }
    else{
        $Montovacaciones = (($SalarioBase/2))*1.3;
    }

		$MontoISR = $Montovacaciones * 0.10;

		$insertplanilla = "INSERT INTO planilla(IdEmpleado, FechaTransaccion, Vacaciones, ISRPlanilla , MesPlanilla, AnioPlanilla)"
											 . "VALUES ('$Empleado','$Fecha', '$Montovacaciones', '$MontoISR' ,'$mes', '$anio')";
		$resultadoinsertplanilla = $mysqli->query($insertplanilla);


    $insert = "INSERT INTO vacaciones(IdEmpleado,MesPeriodoVacaciones,AnoPeriodoVacaciones,MontoVacaciones,FechaVacaciones)"
                         . "VALUES ('$Empleado','$mes','$anio','$Montovacaciones','$Fecha')";
    $resultadoinsert = $mysqli->query($insert);
    $last_id = $mysqli->insert_id;

     header('Location: ../../web/vacaciones/view?id='.$last_id);
?>
</body>
</html>
