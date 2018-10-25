<?php
 include '../../include/dbconnect.php';
session_start();

if (!empty($_SESSION['user']))
  {

    $id =$_REQUEST['IdEmpleado'];
                  $queryexpedientes = "SELECT * FROM empleado WHERE IdEmpleado  = '$id'";
                  $resultadoexpedientes = $mysqli->query($queryexpedientes);
                  while ($test = $resultadoexpedientes->fetch_assoc())
                  {
                      $IdEmpleado = $test['IdEmpleado'];
                      $id = $test['IdEmpleado'];
                      $PrimerNomEmpleado = $test['PrimerNomEmpleado'];
                      $SegunNomEmpleado = $test['SegunNomEmpleado'];
                      $PrimerApellEmpleado = $test['PrimerApellEmpleado'];
                      $SegunApellEmpleado = $test['SegunApellEmpleado'];
                      $SalarioNominal = $test['SalarioNominal'];
                  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Blank</title>
   <?php include '../../include/include.php'; ?>
  </head>

  <body>

  <section id="container" class="">
      <section id="container" class="">


    <?php include '../../include/aside2.php'; ?>
      

      <section id="main-content">
          <section class="wrapper site-min-height">

               <div class="row">
                  <div class="col-sm-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <?php echo $PrimerNomEmpleado. " " .$SegunNomEmpleado. " " .$PrimerApellEmpleado. " " .$SegunApellEmpleado ?> 
                          </header>
                            <table id="example2" class="table table-bordered table-hover">
                              
                            </table>
                      </section>
                          <form id="frm" action="deduccionesseleccion.php" method="post">

                          </form>

              <div class="row">
                  <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                             SUELDO  - AFP - ISSS
                          </header>
                          <div class="panel-body">
                              <form class="form-horizontal" role="form">
                                  <div class="form-group">
                                      <label for="SUELDO" class="col-lg-2 col-sm-2 control-label">SUELDO</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="SUELDO" disabled="true" value="<?php echo $SalarioNominal ?>" >
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="AFP" class="col-lg-2 col-sm-2 control-label">AFP</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="AFP" disabled="true">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="ISSS" class="col-lg-2 col-sm-2 control-label">ISSS</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="ISSS" disabled="true">
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                           ISR - SUELDO NETO
                          </header>
                          <div class="panel-body">
                              <form class="form-horizontal" role="form">
                                  <div class="form-group">
                                      <label for="ISR" class="col-lg-2 col-sm-2 control-label">ISR</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="ISR" disabled="true">
                                          
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="SUELDO NETO" class="col-lg-2 col-sm-2 control-label">SUELDO NETO</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="SUELDONETO" disabled="true">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <div id='btn$id' class='btn-cal'><span class='btn btn-info'> CALCULAR <i class='fa fa-search'></i></span>

                                          <button type="submit" class="btn btn-success">GUARDAR</button>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
                  </div>
              </div>

                  </div>
              </div>
          </section>
      </section>
    <?php include '../include/footer.php'; ?>
  </section>
  </body>
</html>


<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-cal").click(function(){
            var id = $(this).attr("id").replace("btn","");

            var myData  = {"id":id};
            alert(myData);
            $.ajax({
                url   : "deduccioncalcular.php",
                type  :  "POST",
                data  :   myData,
                dataType : "JSON",
                beforeSend : function(){
                    $(this).html("Cargando");
                },
                success : function(data){
                    $("#AFP").val(data.AFP);
                    $("#ISSS").val(data.ISSS);
                    $("#ISR").val(data.ISR);
                    $("#SUELDONETO").val(data.SUELDONETO);
                }
            });
        });



    $('#demo-form1').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
      })
      .on('form:submit', function() {
        return true;
      });
    });
</script>




<?php
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


