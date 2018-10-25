<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Ingresar User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="user-create panel">
  <header class="panel-heading no-border">
      <?= Html::encode($this->title) ?>
  </header>	

	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
		<div class="col-md-1">
		</div>
    </div>

</section>
