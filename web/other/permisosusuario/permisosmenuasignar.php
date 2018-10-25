 <?php
    include '../../include/dbconnect.php';
    session_start();

    if (!empty($_SESSION['user']))
      {
          $urluri = str_replace('?'.$_SERVER["QUERY_STRING"],"", $_SERVER["REQUEST_URI"] );
          $url = str_replace("/SisPlanillasLexa/web/","../",$urluri );
      //   $validarmenu = "select me.url as 'url' from menudetalle me
      //             inner join menuusuario mu on me.IdMenuDetalle = mu.IdMenuDetalle
      //             inner join usuario u on mu.IdUsuario = u.IdUsuario
      //             where u.InicioSesion = '" . $_SESSION['user'] . "'  and me.Url = '" . str_replace('/SisPlanillasLexa/web/','../', $_SERVER["REQUEST_URI"]) . "'";
      //   $resultadovalidarmenu = $mysqli->query($validarmenu);

      // if (mysqli_num_rows($resultadovalidarmenu) <> 0)
      //     {
      //        header( "Location: ../site/index" );





    $id =$_REQUEST['IDUSUARIO'];
                  $queryexpedientes = "SELECT * FROM usuario WHERE IdUsuario  = '$id'";
                  $resultadoexpedientes = $mysqli->query($queryexpedientes);
                  while ($test = $resultadoexpedientes->fetch_assoc())
                  {
                      $IdUsuario = $test['IdUsuario'];
                      $id = $test['IdUsuario'];
                      $PrimerNomEmpleado = $test['Nombres'];
                      $PrimerApellEmpleado = $test['Apellidos'];
                      $InicioSesion = $test['InicioSesion'];
                  }


      $querymenuusuariopermiso = "select  menudetalle.DescripcionMenuDetalle as 'DETALLE', menuusuario.MenuUsuarioActivo as 'ACTIVO' from menuusuario
                      inner join MenuDetalle on menuusuario.IdMenuDetalle = menudetalle.IdMenuDetalle
                      inner join menu on menuusuario.IdMenu = menu.IdMenu
                      inner join usuario on menuusuario.IdUsuario = usuario.IdUsuario
                      where usuario.IdUsuario = '$id' and TipoPermiso = 2  ";
        $resultadomenusuariopermiso = $mysqli->query($querymenuusuariopermiso);


    ?>

  <!doctype html>
<html lang="en">

<head>
        <title>Permisos Usuario</title>

       <?php include '../../include/include.php'; ?>


</head>

<body>
    <div class="wrapper">

      <?php include '../../include/aside2.php'; ?>

        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Inicio <?php echo  $url; ?> </a>
                    </div>
                    <div class="collapse navbar-collapse">
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                          <!--breadcrumbs start -->
                          <ul class="breadcrumb">
                              <li><a href="#"> Inicio</a></li>
                              <li><a href="index.php">Seleccionar Empleado</a></li>
                          </ul>
                          <!--breadcrumbs end -->
                      </div>

                  </div>
                    <div class="row">

                        <div class="col-md-6 col-md-offset-3">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">mail_outline</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo "Nombre: ". $PrimerNomEmpleado. " " .$PrimerApellEmpleado. " / Usuario: " .$InicioSesion?> </h4>
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                          <?php
                                          echo"<thead>";
                                              echo"<tr>";
                                              echo"<th>PERMISO</th>";
                                              echo"<th>ACTIVO</th>";
                                              echo"</tr>";
                                          echo"</thead>";
                                          echo"<tfoot>";
                                              echo"<tr>";
                                              echo"<th>PERMISO</th>";
                                              echo"<th>ACTIVO</th>";
                                              echo"</tr>";
                                          echo"</tfoot>";
                                          echo"<tbody>";

                                           while ($row = $resultadomenusuariopermiso->fetch_assoc())
                                          {

                                             echo"<tr>";
                                               echo"<td>".$row['DETALLE']."</td>";
                                               echo"<td>".$row['ACTIVO']."</td>";
                                              echo"</tr>";

                                          }
                                          echo"</tbody>  ";
                                    ?>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          <?php include '../../include/footer.php'; ?>
        </div>
    </div>
</body>
</html>



    <script type="text/javascript">
    $(document).ready(function(){
        $(".btn-cal").click(function(){
            var id = $(this).attr("id").replace("btn","");

            var myData  = {"id":id};
            alert(myData);
            $.ajax({
                url   : "",
                type  :  "POST",
                data  :   myData,
                dataType : "JSON",
                beforeSend : function(){
                    $(this).html("Cargando");
                },
                success : function(data){

                }
            });
        });
    });
    $( "select[name='state']" ).change(function () {
    var stateID = $(this).val();


    if(stateID) {


        $.ajax({
            url: "submenu.php",
            dataType: 'Json',
            data: {'id':stateID},
            success: function(data) {
                $('select[name="city"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });


    }else{
        $('select[name="city"]').empty();
    }
});

</script>

    <?php
      //}
      // else
      // {
      //         echo "
      // <script>
      //   alert('Usted no tiene permiso para ingresar a esta pagina');
      //   document.location='../index.php';

      // </script>
      // ";

      // }
    }
    else{
      echo "
      <script>
        alert('No ha iniciado sesion');
        document.location='../index.php';

      </script>
      ";
    }
    ?>
