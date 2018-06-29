<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConfigurationViews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuration-views-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'view_type')->dropDownList(\app\models\ConfigurationViews::getTypes(),[ 'readonly'=> !$model->isNewRecord]) ?>
        </div>
        <div class="col-md-4">
        <?php if(!$model->isNewRecord && $model->view_type==\app\models\ConfigurationViews::TYPE_TERMINAL):?>

            <?= $form->field($model,'services',['template' => "{label}\n{hint}\n{error}"])->textInput();
            echo \app\helpers\TreeRenderer::returnTree([
                'dataArray' => \app\models\ServiceType::find()->asArray()->all(),
                'checkbox' => true,
                'single' =>false,
                'title_field' => 'name',
                'parent_field' => 'parent_id',
                'model'=>$model,
                'attribute'=>'services',
                'selectedAttr' => $model->services
            ]);
            ?>
        <?php endif;?></div>
    </div>
    <?php if(!$model->isNewRecord && $model->view_type==\app\models\ConfigurationViews::TYPE_MONITOR):?>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'layout_type')->hiddenInput(['id'=>'layout']) ?>
            <ul id="layouts_list">
                <?php foreach (\app\models\ConfigurationViews::getLayouts() as $i =>$layout){
                    $active = $i==$model->layout_type?'active':'';
                    ?>
                    <li data-val="<?=$i?>" class="<?= $active?>">
                        <figure>
                            <img src='/images/l<?=$i?>.jpg' class="transition">
                            <figcaption><?= $layout?></figcaption>
                        </figure>
                    </li>
                <?php }?>
            </ul>
            <div class="clearfix"></div>
            <?= $form->field($model, 'block_title_1')->textInput() ?>
            <?= $form->field($model, 'block_content_1')->widget(\dosamigos\tinymce\TinyMce::className(), [
                'options' => ['rows' => 4],
            ]);?>

        </div>
    </div>
    <?php \yii\widgets\Pjax::begin()?>
    <?php if($model->imageCount<\app\models\ConfigurationViews::FILE_MAX_COUNT){
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
    <?php endif;?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Պահպանել'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
