

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>


<section class="user-index panel">
      <header class="panel-heading no-border">
          <?= Html::encode($this->title) ?>
        <div class="pull-right box-tools">
            <?= Html::a('Ingresar User', ['create'], ['class' => 'btn btn-success btn-sm btn-tool']) ?>
        </div>
      </header>


    <section class="main-content">
    <section class="warper">
        <div class="row">
            <div class="col-xs-12">

                <table class="table table-bordered">
                                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                        
                            <p>
                                
                            </p>

                                                    <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
        'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    'id',
            'first_name',
            'last_name',
            'phone_number',
            'username',
            // 'email:email',
            // 'password',
            // 'authKey',
            // 'password_reset_token',
            // 'user_image',
            // 'user_level',
            // 'IdEmpleado',

                                    ['class' => 'yii\grid\ActionColumn',
                                     'options' => ['style' => 'width:140    px;'],
                                    ],
                                ],
                            ]); ?>
                                        </table>
            </div>
         </div>
     </div>
     </section>
    </section>

</section>

