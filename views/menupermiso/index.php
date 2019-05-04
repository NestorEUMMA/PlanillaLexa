

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenupermisoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Permiso';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div align="right">
   <?= Html::a('Ingresar Menuusuario', ['create'], ['class' => 'btn btn-success']) ?>
</div> -->

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
                                // 'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    [
                                      'attribute'=>'IdUsuario',
                                      'value'=>'idUsuario.InicioSesion',
                                    ],
                                    [
                                      'attribute'=>'IdMenuDetalle',
                                      'value'=>'idMenuDetalle.DescripcionMenuDetalle',
                                    ],
                                    [
                                    'format' => 'boolean',
                                    'attribute' => 'MenuUsuarioActivo',
                                    'filter' => [0=>'No',1=>'Si'],
                                    ],

                                    ['class' => 'yii\grid\ActionColumn',
                                     'options' => ['style' => 'width:155px;'],
                                     'template' => '{update}',
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
