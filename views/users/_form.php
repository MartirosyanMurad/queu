<?php

use app\models\Types;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-2"><?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?></div>
    </div>
    <div class="row">
        <div class="col-md-2"><?= $form->field($model, 'type_id')->dropDownList(Types::getList(),['prompt'=>'']) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'queue_type')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'groups_id')->textInput() ?></div>
        <div class="col-md-2"><?= $form->field($model, 'room')->textInput() ?></div>
        <div class="col-md-2"><?= $form->field($model, 'image_file')->fileInput(['maxlength' => true]) ?></div>
    </div>
    <div class="row">
        <div class="col-md-2"><?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true,'value'=>'']) ?></div>
        <div class="col-md-2"><?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
