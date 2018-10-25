<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConstanciadependienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// VALIDACION DE SESION Y CONEXION
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }



$this->title = 'Constancia de Salario Dependientes';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                  <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
                  <div class="toolbar">
                    </div>
                    <table class="table">

                    <!-- <?php  echo $this->render('_search', ['model' => $searchModel]); ?> -->

                        <p>

                        </p>

                          <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'rowOptions'=> function($model){
                              if($model->EmpleadoActivo == 0){
                                return ['class'=> 'danger'];
                              }
                            },
                               'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                          [
                                            'attribute' => 'IdEmpleado',
                                            'value' => function ($model) {
                                                return $model->getFullName();
                                            },
                                         ],
                                  ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width:50px;'], 'template' => "{report}"],

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
                    <!-- end row -->
