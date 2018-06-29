<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tickets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tickets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'letter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'queu_count')->textInput() ?>

    <?= $form->field($model, 'kanchi_date')->textInput() ?>

    <?= $form->field($model, 'kanchi_time')->textInput() ?>

    <?= $form->field($model, 'terminal_id')->textInput() ?>

    <?= $form->field($model, 'service_type_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
