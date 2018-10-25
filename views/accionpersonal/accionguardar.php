<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

    $Empleado = $_POST['Empleado'];
    $Descuento = $_POST['Descuento'];
    $Motivo = $_POST['Motivo'];
    $FechaAccion = $_POST['FechaAccion'];



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

		$insertplanilla = "INSERT INTO planilla(IdEmpleado, FechaTransaccion, Anticipos, MesPlanilla, AnioPlanilla)"
											 . "VALUES ('$Empleado','$FechaAccion', '$Descuento','$mes', '$anio')";
		$resultadoinsertplanilla = $mysqli->query($insertplanilla);

    $insert = "INSERT INTO accionpersonal(IdEmpleado, FechaAccion, Descuento,Motivo,PeriodoAccion, MesAccion)"
                       . "VALUES ('$Empleado','$FechaAccion', '$Descuento','$Motivo','$anio', '$mes')";
    $resultadoinsert = $mysqli->query($insert);
    $last_id = $mysqli->insert_id;

    header('Location: ../../web/accionpersonal/view?id='.$last_id);

?>

</body>
</html>
