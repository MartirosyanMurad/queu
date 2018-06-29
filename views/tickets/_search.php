<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Tickets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tickets-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'letter') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'queu_count') ?>

    <?= $form->field($model, 'kanchi_date') ?>

    <?php // echo $form->field($model, 'kanchi_time') ?>

    <?php // echo $form->field($model, 'terminal_id') ?>

    <?php // echo $form->field($model, 'service_type_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'call_user_id') ?>

    <?php // echo $form->field($model, 'call_time') ?>

    <?php // echo $form->field($model, 'book_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
