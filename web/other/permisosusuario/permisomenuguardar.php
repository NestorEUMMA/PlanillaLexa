<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>



</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

    $IdUsuario = $_POST['txtIdUsuario'];
    $Menu = $_POST['state'];
    $Submenu = $_POST['city'];
    $Activo = $_POST['menuactivo'];


// El tipopermiso = 1 es para menu y el tipopermiso = 2 es para permisos de crud
    $insertexpediente = "INSERT INTO menuusuario(IdMenuDetalle,IdUsuario,MenuUsuarioActivo, IdMenu, TipoPermiso)"
                       . "VALUES ('$Submenu','$IdUsuario','$Activo', '$Menu', 1)";
    $resultadoinsertmovimiento = $mysqli->query($insertexpediente);

    // echo $insertexpediente;
?>


        <form id="frm" action="permisosmenuasignar.php" method="post" class="hidden">
          <input type="hidden" id="IDUSUARIO" name="IDUSUARIO" value="<?php echo $IdUsuario ?>" />
        </form>

        <script type="text/javascript">
            $(document).ready(function(){
                    $("#frm").submit();
            });

        </script>
</body>
</html>