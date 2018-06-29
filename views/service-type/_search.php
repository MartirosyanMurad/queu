<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ServiceTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'one_queu_time') ?>

    <?= $form->field($model, 'queu_start_time') ?>

    <?php // echo $form->field($model, 'queu_end_time') ?>

    <?php // echo $form->field($model, 'group_id') ?>

    <?php // echo $form->field($model, 'service_letter') ?>

    <?php // echo $form->field($model, 'active_passive') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
