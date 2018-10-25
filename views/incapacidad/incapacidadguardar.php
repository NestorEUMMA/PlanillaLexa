<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

    $Empleado = $_POST['Empleado'];
    $Dias = $_POST['Dias'];
    $Motivo = $_POST['Motivo'];
    $Fecha = $_POST['Fecha'];

    $Parametro = 'select ISRParametro from parametros where IdParametro = 1';
    $SQL = $mysqli->query($Parametro);
    $ResultadoParametro = mysqli_fetch_row($SQL);

    $Salario = 'select SalarioNominal from empleado where IdEmpleado = '.$Empleado.'';
    $SQL = $mysqli->query($Salario);
    $ResultadoSalario = mysqli_fetch_row($SQL);
    $SalarioBase = $ResultadoSalario[0];

    $SalarioPorDia = ($SalarioBase/30);

    $SalarioDescuento = $SalarioPorDia * $Dias;


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

		$insertplanilla = "INSERT INTO planilla(IdEmpleado, FechaTransaccion, Incapacidades, DiasIncapacidad,MesPlanilla, AnioPlanilla)"
		 									 . "VALUES ('$Empleado','$Fecha', '$SalarioDescuento','$Dias', '$mes', '$anio')";
		$resultadoinsertplanilla = $mysqli->query($insertplanilla);

    $insert = "INSERT INTO incapacidad(IdEmpleado,DiasIncapacidad,SalarioDescuento,FechaIncapacidad,
                                         PeriodoIncapacidad,MesIncapacidad,DescripcionIncapacidad)"
                            . "VALUES ('$Empleado','$Dias', '$SalarioDescuento' , '$Fecha',
                                    '$mes','$anio','$Motivo')";
    $resultadoinsert = $mysqli->query($insert);
    $last_id = $mysqli->insert_id;

    header('Location: ../../web/incapacidad/view?id='.$last_id);
		 echo $insert;
?>


</body>
</html>
