<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rptsepp */

$this->title = 'Ingresar Rptsepp';
$this->params['breadcrumbs'][] = ['label' => 'Rptsepps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



