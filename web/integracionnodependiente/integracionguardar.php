<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

 include '../../include/dbconnect.php';
 session_start();

    $mes = $_POST['mes'];
    $periodo = $_POST['periodo'];
    $quincena = $_POST['quincena'];

    $percepciones = $_POST['honorario'];
    $isss = $_POST['isr'] * -1;
    $afp = ($_POST['honorario'] - $_POST['isr'])* -1;
    $fecha = $_POST['fecha'];

		$queryserv= "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'SERVICIOS PROFESIONALES'";
		$resultadoqueryserv= $mysqli->query($queryserv);
		while($row = $resultadoqueryserv->fetch_assoc()){
				$codigyserv= $row['CODIGO'];
				$cuentyserv= $row['CUENTA'];
		}
		$queryliquido = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'SALARIO LIQUIDO'";
		$resultadoqueryliquido = $mysqli->query($queryliquido);
		while($row = $resultadoqueryliquido->fetch_assoc()){
				$codigyliquido = $row['CODIGO'];
				$cuentyliquido = $row['CUENTA'];
		}
		$queryisr = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'RETENCIONES LEGALES ISR'";
		$resultadoqueryisr = $mysqli->query($queryisr);
		while($row = $resultadoqueryisr->fetch_assoc()){
				$codigoisr = $row['CODIGO'];
				$cuentaisr = $row['CUENTA'];
		}


     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigyserv,'$cuentyserv','$percepciones','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',1)";
     $resultadoinsert = $mysqli->query($insert);

     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigoisr,'$cuentaisr','$isss','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',1)";
     $resultadoinsert = $mysqli->query($insert);

		 $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigyliquido,'$cuentyliquido','$afp','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',1)";
     $resultadoinsert = $mysqli->query($insert);


       header('Location: ../../web/integracionnodependiente/index.php');
?>
</body>
</html>
