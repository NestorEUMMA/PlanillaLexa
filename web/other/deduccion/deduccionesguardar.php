<html>
<head>
	<script src="../web/js/jquery-1.8.3.min.js"></script>

</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

    $IDEMPLEADO = $_POST['IDEMPLEADO'];
    $SALARIONOMINAL = $_POST['SALARIONOMINAL'];
    $AFP = $_POST['AFP'];
    $ISSS = $_POST['ISSS'];
    $IPSFA = $_POST['IPSFA'];
    $ISR = $_POST['ISR'];
    $NETO = $_POST['NETO'];


	   $insertexpediente = "INSERT INTO deduccionempleado(IdEmpleado,SueldoEmpleado,DeducAfp,DeducIsss,DeducIsr,SueldoNeto,DeducIpsfa,FechaCalculo)"
                     . "VALUES ('$IDEMPLEADO','$SALARIONOMINAL','$AFP','$ISSS','$ISR','$NETO','$IPSFA',now())";
  	 $resultadoinsertmovimiento = $mysqli->query($insertexpediente);

?>


        <form id="frm" action="deducciones.php" method="post">
          
        </form>

				<script type="text/javascript">
						$(document).ready(function(){
										//alert($("#IdConsulta").val());
										$("#frm").submit();
						});
				</script> 

<?php

?>
</body>
</html>