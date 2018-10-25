<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanillaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planillas';
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                  <?php $form = ActiveForm::begin(['action' => ['planilla/report'],'options' => ['method' => 'post']]) ?>
                  <div class="row">
                    <div class="form-group col-md-3">
                    <?php echo '<label class="control-label">Fecha Fin</label>'; ?>
                    <?php
                    echo DatePicker::widget([
                            'name' => 'fechaini',
                            'type' => DatePicker::TYPE_INPUT,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>
                    </div>
                    <div class="form-group col-md-3">
                    <?php echo '<label class="control-label">Fecha Fin</label>'; ?>
                      <?php
                      echo DatePicker::widget([
                              'name' => 'fechafin',
                              'type' => DatePicker::TYPE_INPUT,
                              'pluginOptions' => [
                                  'autoclose'=>true,
                                  'format' => 'yyyy-mm-dd'
                              ]
                          ]);
                      ?>

                    </div>
                    <div class="row">
                      <div class="form-group col-md-3">

                      <?php
                      $data = [
                              "QUINCENAL" => "QUINCENAL",
                              "SEMANAL" => "SEMANAL",
                              "MENSUAL" => "MENSUAL"
                            ];
                        echo '<label class="control-label">Tipo</label>';
                            echo Select2::widget([
                              'name' => 'tipo',
                              'data' => $data,
                              'options' => [
                                  'placeholder' => 'Seleccione ...',
                                  'multiple' => false
                              ],
                            ]);
                            ?>
                       </div>
                       <div class="form-group col-md-3">
                       </br>
                           <center>
                             <?= Html::submitButton('Enviar Parametros', ['class' => 'btn btn-primary']) ?>
                           </center>
                        </div>
                       </div>
                      </div>
                    <?php ActiveForm::end(); ?>

                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
                    <!-- end row -->
