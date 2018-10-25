<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReporteanuarentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte Anual F910';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">assignment</i>
            </div>
            <div class="card-content">
              <?php $form = ActiveForm::begin(['action' => ['reporteanuarenta/report'],'options' => ['method' => 'post']]) ?>
              <div class="row">

                <div class="row">
                  <div class="form-group col-md-2">
                  </div>
                  <div class="form-group col-md-3">
                  <?php
                  $data = [
                          "2018" => "2018",
                          "2019" => "2019",
                          "2020" => "2020",
                          "2021" => "2021",
                          "2022" => "2022",
                          "2023" => "2023",
                          "2024" => "2024",
                          "2025" => "2025",
                          "2026" => "2026",
                          "2027" => "2027"
                        ];
                    echo '<label class="control-label">Seleccione un Periodo</label>';
                        echo Select2::widget([
                          'name' => 'periodo',
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
