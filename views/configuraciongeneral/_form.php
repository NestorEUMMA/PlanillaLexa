<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciongeneral */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container-fluid">
<div class="col-md-12">
<div class="card">
        <div class="card-header card-header-icon" data-background-color="orange">
            <i class="material-icons">mail_outline</i>
        </div>
        <div class="card-content">
        	<h4 class="card-title"><?= Html::encode($this->title) ?></h4>
			    <?php $form = ActiveForm::begin(); ?>
				<div class="form-group label-floating">

        <p><center><strong>* Si la percepcion queda marcada, esta descontara ISSS y AFP, si no queda marcada, automaticamente descontara ISR </strong></center></p>
        <?php echo $form->field($model, 'SalarioMinimo')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => '$ ',
                'allowNegative' => false
            ]
        ]);
        ?>

        <?= $form->field($model, 'ComisionesConfig')->checkbox() ?>

        <?= $form->field($model, 'HorasExtrasConfig')->checkbox() ?>

        <?= $form->field($model, 'BonosConfig')->checkbox() ?>

        <?= $form->field($model, 'HonorariosConfig')->checkbox() ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>
