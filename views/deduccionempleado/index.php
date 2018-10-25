

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeduccionempleadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deduccion Empleados';
$this->params['breadcrumbs'][] = $this->title;

include '../include/dbconnect.php';

      $queryempleado = "select IdEmpleado, CONCAT(PrimerNomEmpleado,' ',SegunNomEmpleado,' ',PrimerApellEmpleado,' ',SegunApellEmpleado)  AS NombreCompleto from empleado where EmpleadoActivo = 1 order by NombreCompleto asc";
      $resultadoqueryempleado = $mysqli->query($queryempleado);
?>

<div align="right">
     <button class="btn btn-success btn-raised " data-toggle="modal" data-target="#ModalSeleccionarDeduccion">
                                         Nueva Deduccion
    </button>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">      
                  <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
                  <div class="toolbar">
                    </div>
                    <div class="table-responsive">
                        <table class="table">

                                                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                        
                            <p>
                                
                            </p>

                                                    <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
        'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    //'IdDeduccionEmpleado',
                                     [
                                      'attribute'=>'IdEmpleado',
                                      'value'=>'idEmpleado.fullname',
                                    ],
                                                                      [
                                       'attribute' => 'SueldoEmpleado',
                                       'value' => function ($model) {
                                           return '$' . ' ' . $model->SueldoEmpleado ;
                                       }
                                    ] ,
                                                                                                          [
                                       'attribute' => 'DeducAfp',
                                       'value' => function ($model) {
                                           return '$' . ' ' . $model->DeducAfp ;
                                       }
                                    ] ,
                                                                                                          [
                                       'attribute' => 'DeducIsss',
                                       'value' => function ($model) {
                                           return '$' . ' ' . $model->DeducIsss ;
                                       }
                                    ] ,
                                                                                                          [
                                       'attribute' => 'DeducIsr',
                                       'value' => function ($model) {
                                           return '$' . ' ' . $model->DeducIsr ;
                                       }
                                    ] ,
                                                                                                          [
                                       'attribute' => 'DeducIpsfa',
                                       'value' => function ($model) {
                                           return '$' . ' ' . $model->DeducIpsfa ;
                                       }
                                    ] ,
                                                                                                          [
                                       'attribute' => 'SueldoNeto',
                                       'value' => function ($model) {
                                           return '$' . ' ' . $model->SueldoNeto ;
                                       }
                                    ] ,
                                      'FechaCalculo',

                                    ['class' => 'yii\grid\ActionColumn',
                                     'options' => ['style' => 'width:115px;'],
                                    ],
                                ],
                            ]); ?>
                                              </table>
                    </div>
                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
<!--                     <!-- end row -->


                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="ModalSeleccionarDeduccion" class="modal fade">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                              <h4 class="modal-title">CALCULO DE DEDUCCIONES</h4>
                                          </div>
                                          <div class="modal-body">
                                              <form class="form-horizontale">
                                                      <div class="form-group" hidden="true">
                                                          <label for="exampleInputEmail1">ID</label>
                                                          <input type="text" class="form-control" id="IDEMPLEADO"  name="IDEMPLEADO" value="">
                                                      </div>
                                                      <div class="form-group">
                                                      <label for="title">Seleccione un Empleado:</label>
                                                      <select name="Empleado" class="form-control" id="EmpleadoDrop" onchange="Deduccion()">
                                                          <option value="">--- Seleccione un Empleado ---</option>
                                                          <?php
                                                              while($row = $resultadoqueryempleado->fetch_assoc()){
                                                                  echo "<option value='".$row['IdEmpleado']."'>".$row['NombreCompleto']."</option>";
                                                              }
                                                          ?>
                                                      </select>
                                                     </div>
                                                      <div class="form-group col-sm-6">
                                                          <label for="exampleInputEmail1">SALARIO</label>
                                                          <input type="text" class="form-control" id="SALARIONOMINAL"  name="SALARIONOMINAL" readonly="true">
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                          <label for="exampleInputPassword1">ISSS</label>
                                                          <input type="text" class="form-control" id="ISSS"  name="ISSS" readonly="true">
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                          <label for="exampleInputPassword1">AFP</label>
                                                          <input type="text" class="form-control" id="AFP" name="AFP" readonly="true">
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                          <label for="exampleInputPassword1">IPSFA</label>
                                                          <input type="text" class="form-control" id="IPSFA" name="IPSFA" readonly="true">
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                          <label for="exampleInputPassword1">ISR</label>
                                                          <input type="text" class="form-control" id="ISR"  name="ISR" readonly="true">
                                                      </div>
                                                      <div class="form-group col-sm-6">
                                                          <label for="exampleInputPassword1">SUELDO NETO</label>
                                                          <input type="text" class="form-control" id="NETO"  name="NETO" readonly="true">
                                                      </div>

                                                      <div class="form-group">
                                                      <center>
                                                      <button type="submit" class="btn btn-success">GUARDAR</button>
                                                      <button  class="btn btn-danger " data-dismiss="modal">CERRAR</button>
                                                      </center> 
                                                      </div>
                                                  
                                              </form>

                                          </div>

                                      </div>
                                  </div>
                              </div>
                          </div>



<script src="../../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){

        demo.initFormExtendedDatetimepickers();

    });
</script>

<script>
  $(function() {
    $('#currency').maskMoney();
  })
</script>

    <script type="text/javascript">
      
          function Deduccion() {
              var id = document.getElementById("EmpleadoDrop").value;
              var myData  = {"id":id};
              $.ajax({
                    url   : "../../views/deduccionempleado/deduccioncalcular.php",
                    type  :  "POST",
                    data  :   myData,
                    dataType : "JSON",
                    beforeSend : function(){
                        $(this).html("Cargando");
                    },
                    success : function(data){
                        $("#SALARIONOMINAL").val("$"+data.SALARIONOMINAL);
                        $("#ISSS").val("$"+data.ISSS);
                        $("#AFP").val("$"+data.AFP);
                        $("#IPSFA").val("$"+data.IPSFA);
                        $("#ISR").val("$"+data.ISR);
                        $("#NETO").val("$"+data.NETO);
                        $("#IDEMPLEADO").val(data.IDEMPLEADO);
                    }
                });
          }

    </script> 