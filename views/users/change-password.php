<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin([
        'id'=>'changepassword-form',
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-lg-3\">
                        {input}</div>\n<div class=\"col-lg-5\">
                        {error}</div>",
            'labelOptions'=>['class'=>'col-lg-2 control-label'],
        ],
    ]); ?>
    <?= $form->field($model,'old_password',['inputOptions'=>['placeholder'=>'Old Password']])->passwordInput() ?>

    <?= $form->field($model,'Password_hash',['inputOptions'=>['placeholder'=>'New Password']])->passwordInput() ?>

    <?= $form->field($model,'confirm_password',['inputOptions'=>['placeholder'=>'Repeat New Password']])->passwordInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-11">
            <?= Html::submitButton('Change password',[
                'class'=>'btn btn-success'
            ]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
