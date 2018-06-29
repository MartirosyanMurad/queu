<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Groups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="groups-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4">
            <div class="form-group">
                <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-success submitAndLabel']) ?>
            </div>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
