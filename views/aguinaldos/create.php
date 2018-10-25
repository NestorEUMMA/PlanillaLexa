<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Aguinaldos */

$this->title = 'Ingresar Aguinaldos';
$this->params['breadcrumbs'][] = ['label' => 'Aguinaldos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



