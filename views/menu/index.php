

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu';
$this->params['breadcrumbs'][] = $this->title;
?>

<div align="right">
   <?= Html::a('Ingresar Menu', ['create'], ['class' => 'btn btn-success']) ?>
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
                        <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                
                                    'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                            //'IdMenu',
                                            'DescripcionMenu',
                                            'Icono',
                                            'TipoMenu',

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
                    <!-- end row -->
