<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Honorario */

$this->title = 'Ingresar Honorario';
$this->params['breadcrumbs'][] = ['label' => 'Honorarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



