<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenudetalleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Detalle';
$this->params['breadcrumbs'][] = $this->title;


?>

<div align="right">
   <?= Html::a('Ingresar Menu Detalle', ['create'], ['class' => 'btn btn-success']) ?>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                  <h4 class="card-title"><?= Html::encode($this->title) ?></h4>



                                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                            <p>

                            </p>

                    <?= GridView::widget([
                                'dataProvider' => $dataProvider,
        'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    'IdMenuDetalle',
                                    //'IdMenu',
                                    'DescripcionMenuDetalle',
                                    'Url:url',
                                    'Icono',

                                    ['class' => 'yii\grid\ActionColumn',
                                     'options' => ['style' => 'width:155px;'],
                                    ],
                                ],
                            ]); ?>

                </div>

                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
                    <!-- end row -->
