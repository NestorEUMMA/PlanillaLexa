<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

    $Empleado = $_POST['Empleado'];
    $Jornada = $_POST['Jornada'];
    $Dia = $_POST['Dia'];
    $Entrada = $_POST['Entrada'];
    $Salida = $_POST['Salida'];


    $insertexpediente = "INSERT INTO horario(IdEmpleado,JornadaLaboral,DiaLaboral, EntradaLaboral, SalidaLaboral)"
                       . "VALUES ('$Empleado','$Jornada','$Dia', '$Entrada', '$Salida')";
    $resultadoinsertmovimiento = $mysqli->query($insertexpediente);
    header('Location: ../../web/horario/index');

?>


<!--         <form id="frm" action="../../web/horario/index" method="post" class="hidden">
        </form>

        <script type="text/javascript">
            $(document).ready(function(){
                    $("#frm").submit();
            });

        </script> -->
</body>
</html>