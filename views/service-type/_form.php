<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\select2\Select2;
use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\ServiceType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-type-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'one_queu_time')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'queu_start_time')->widget(TimePicker::className(),[
                        'pluginOptions' => [
                            'showMeridian' => false,
                        ]
                    ]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'queu_end_time')->widget(TimePicker::className(),[
                        'pluginOptions' => [
                            'showMeridian' => false,
                        ]
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3"><?= $form->field($model, 'group_id')->dropDownList(\app\models\Groups::getList(),['prompt'=>'']) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'service_letter')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'active_passive')->dropDownList(\app\models\ServiceType::getConstList('aktive_pasive')) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'order')?></div>
            </div>
            <?= $form->field($model, 'users')->widget(Select2::className(),[
                'data' => \app\models\Users::getList('displayName'),
                'options' => [
                    'placeholder' => 'Select an item',
                ],
                'pluginOptions' => [
                    'multiple' => true,
                    'allowClear' => true,
                ],
            ]) ?>
            <?php \yii\widgets\Pjax::begin()?>
            <?php if($model->imageCount<\app\models\ServiceType::FILE_MAX_COUNT){
                echo $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']);
            }?>
            <div class="row">
                <?php
                if(!$model->isNewRecord){
                    foreach ($images as $file) {?>
                        <div class="col-md-3">
                            <img src="<?= \yii\helpers\Url::to([$file['url']])?>" class="img-responsive">
                            <?=Html::a('<span class="glyphicon glyphicon-remove"></span>',\yii\helpers\Url::to(['update', 'id'=>$model->id, 'delete_file_id'=>$file['id']]))?>
                        </div>
                    <?php }
                } ?>

            </div>
            <?php \yii\widgets\Pjax::end()?>
        </div>
        <div class="col-md-3">
            <div class="row">

                <?= $form->field($model,'group_id',['template' => "{label}\n{hint}\n{error}"])->textInput();
                echo \app\helpers\TreeRenderer::returnTree([
                    'dataArray' => \app\models\ServiceType::find()->asArray()->all(),
                    'checkbox' => true,
                    'single' =>true,
                    'title_field' => 'name',
                    'parent_field' => 'parent_id',
                    'model'=>$model,
                    'attribute'=>'parent_id',
                    'selectedAttr' => \yii\helpers\Json::encode([$model->parent_id])
                ]);
                ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Պահպանել'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
