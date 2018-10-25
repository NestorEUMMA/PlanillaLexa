<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Horasextras */

$this->title = 'Ingresar Horasextras';
$this->params['breadcrumbs'][] = ['label' => 'Horasextras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



