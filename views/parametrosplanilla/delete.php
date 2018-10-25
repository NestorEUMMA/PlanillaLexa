<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();




      $IdParametroPlanilla = $_POST['IdParametroPlanilla'];

			$queryvalidacionplanilla = "select MesPlanilla, QuincenaPlanilla, PeriodoPlanilla from parametrosplanilla where IdParametroPlanilla = '$IdParametroPlanilla'";
			$resultqueryvalidacionplanilla = $mysqli->query($queryvalidacionplanilla);
      while ($test = $resultqueryvalidacionplanilla->fetch_assoc())
                 {
                   $mes = $test['MesPlanilla'];
  	               $quincena = $test['QuincenaPlanilla'];
  	               $periodo = $test['PeriodoPlanilla'];
                 }
     $queryInsResp = "delete from rptplanilla where RptPeriodo = '$mes' and RptAnio = '$periodo' and RptQuincena = '$quincena'
                     ";
     $resultInsResp = $mysqli->query($queryInsResp);

			$queryInsResp1 = "delete from parametrosplanilla where IdParametroPlanilla = '$IdParametroPlanilla'
		 								 ";
		  $resultInsResp = $mysqli->query($queryInsResp1);
 			header('Location: ../../web/parametrosplanilla/index');




?>
</body>
</html>
