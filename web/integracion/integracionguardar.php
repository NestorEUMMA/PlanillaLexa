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
    $percepciones = $_POST['percepciones'];
    $isss = $_POST['isss'] * -1;
    $afp = $_POST['afp']* -1;
		$ipsfa = $_POST['ipsfa']* -1;
    $renta = $_POST['renta']* -1;
    $anticipo = $_POST['anticipo']* -1;
    $salario = $_POST['salarioliquido']* -1;
    $fecha = $_POST['fecha'];

		$querysalario = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'SALARIO ADMINISTRACION'";
		$resultadoquerysalario = $mysqli->query($querysalario);
		while($row = $resultadoquerysalario->fetch_assoc()){
				$codigoservicio = $row['CODIGO'];
				$cuentaservicio = $row['CUENTA'];
		}
		$queryserv = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'RETENCIONES LEGALES ISSS'";
		$resultadoqueryserv = $mysqli->query($queryserv);
		while($row = $resultadoqueryserv->fetch_assoc()){
				$codigoisss = $row['CODIGO'];
				$cuentaisss = $row['CUENTA'];
		}
		$queryafp = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'RETENCIONES LEGALES AFP'";
		$resultadoqueryafp = $mysqli->query($queryafp);
		while($row = $resultadoqueryafp->fetch_assoc()){
				$codigoafp = $row['CODIGO'];
				$cuentaafp = $row['CUENTA'];
		}
		$queryafp = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'RETENCIONES LEGALES AFP'";
		$resultadoqueryafp = $mysqli->query($queryafp);
		while($row = $resultadoqueryafp->fetch_assoc()){
				$codigoafp = $row['CODIGO'];
				$cuentaafp = $row['CUENTA'];
		}
		$queryipsfa = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'RETENCIONES LEGALES IPSFA'";
		$resultadoqueryipsfa = $mysqli->query($queryipsfa);
		while($row = $resultadoqueryipsfa->fetch_assoc()){
				$codigoipsfa = $row['CODIGO'];
				$cuentaipsfa = $row['CUENTA'];
		}
		$queryisr = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'RETENCIONES LEGALES ISR'";
		$resultadoqueryisr = $mysqli->query($queryisr);
		while($row = $resultadoqueryisr->fetch_assoc()){
				$codigoisr = $row['CODIGO'];
				$cuentaisr = $row['CUENTA'];
		}
		$queryanticipos = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'ANTICIPOS Y SALARIOS'";
		$resultadoqueryanticipos = $mysqli->query($queryanticipos);
		while($row = $resultadoqueryanticipos->fetch_assoc()){
				$codigyanticipos = $row['CODIGO'];
				$cuentyanticipos = $row['CUENTA'];
		}
		$queryliquido = "SELECT CodigoCuentas as 'CODIGO', TipoCuenta as 'CUENTA' FROM catalogocuentas WHERE TipoCuenta = 'SALARIO LIQUIDO'";
		$resultadoqueryliquido = $mysqli->query($queryliquido);
		while($row = $resultadoqueryliquido->fetch_assoc()){
				$codigyliquido = $row['CODIGO'];
				$cuentyliquido = $row['CUENTA'];
		}


     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA','1234','cuenta','$percepciones','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',0)";
     $resultadoinsert = $mysqli->query($insert);

     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigoisss,'$cuentaisss','$isss','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',0)";
     $resultadoinsert = $mysqli->query($insert);

     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigoafp,'$cuentaafp','$afp','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',0)";
     $resultadoinsert = $mysqli->query($insert);

		 $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigoipsfa,'$cuentaipsfa','$ipsfa','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',0)";
     $resultadoinsert = $mysqli->query($insert);

     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigoisr,'$cuentaisr','$renta','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',0)";
     $resultadoinsert = $mysqli->query($insert);

     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigyanticipos,'$cuentyanticipos','$anticipo','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',0)";
     $resultadoinsert = $mysqli->query($insert);

     $insert = "INSERT INTO integracionpeachtree(Date,Reference,Account,Description,Amount,UsedReimbursable,TransactionPeriod,TransactionNumber,CosolidatedTransaction,RecurNumber,RecurFrequency,Mes,Periodo,Quincena,dependiente)"
                        . "VALUES ('$fecha','PLANILLA',$codigyliquido,'$cuentyliquido','$salario','FALSE',13,1,'FALSE',0,0,'$mes','$periodo','$quincena',0)";
     $resultadoinsert = $mysqli->query($insert);


       header('Location: ../../web/integracion/index.php');
?>
</body>
</html>
