<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\models\ConfigurationViews;
/* @var $this yii\web\View */
/* @var $model app\models\Terminal */
/* @var $form yii\widgets\ActiveForm */
$config_list = \yii\helpers\ArrayHelper::map(ConfigurationViews::find()->where(['view_type'=>ConfigurationViews::TYPE_TERMINAL])->all(),'id','name');
?>

<div class="terminal-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'configuration_view_id')->dropDownList($config_list,['prompt'=>'']) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'terminal_monitor_group_id')->dropDownList(\app\models\TerminalMonitorGroup::getList(),['prompt'=>'']) ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Պահպանել'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
