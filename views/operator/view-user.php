<?php
/*  @var $user \app\models\Users */
/*  @var $model \app\models\Book*/
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
$book_times = ArrayHelper::index($book_times,'time')
?>
<div>
    <h1 class="page_title pull-left"><?= $user->getDisplayName()?> (<?= $model->date?>)</h1>
    <div class="pull-right">
        <form method="get" id="date_form">
            <input type="hidden" value="<?= $user->id?>" name="id">

            <?= DatePicker::widget([
                'name' => 'date',
                'value' => Yii::$app->request->get('date'),
                'options'=>[
                    'class'=>'form-control'
                ],
                'clientOptions'=>[
                    'minDate'=>0,
                    'onSelect' => new \yii\web\JsExpression('function(){$("#date_form").submit()}')
                ]
            ])?>
        </form>

    </div>
    <div class="clearfix">
    </div>
</div>
<?php if($date = date('Y-m-d')){
    $spasoxner = \app\models\Tickets::getWaitCount($user->id);
    if($spasoxner){
        echo '<div> Սպասողների քանակ՝ '.$spasoxner.'</div>';
    }
}?>
<?php
$start = 9;
$end = 18;
$in_row = 8;
$delta = 15;
$hour = $start;
$minute = 0;
?>
<table class="table table-bordered" id="book_table">
    <tbody>
        <tr>
            <?php while ($hour<$end){
                for($i = 0;$i<$in_row && $hour<$end;$i++){
                    $time = str_pad($hour,2,0, STR_PAD_LEFT).':'.str_pad($minute,2,0, STR_PAD_LEFT);
                    $book = ArrayHelper::getValue($book_times,$time.':00');
                    if($book){
                        echo '<td data-time = "'.$time.'" class="booked">'.
                            \yii\helpers\Html::a(
                                    '<i class="glyphicon glyphicon-remove"></i>',
                                    \yii\helpers\Url::to(['/operator/delete-book','id'=>$book['id']]),
                                    [
                                        'data-confirm'=>"Վստա՞հ եք, որ ցանկանում եք ջնջել:",
                                        'data-method'=>"post"
                                    ]
                            ).
                            $time.
                            '<div>'.$book['name'].'</div>'.
                            '<div>'.$book['phone'].'</div>'.
                            '<div>'.$book['code'].'</div>'.
                            '</td>';

                    }else{
                        echo '<td data-time = "'.$time.'" class="free">'.$time.'</td>';

                    }
                    $minute+=$delta;
                    if($minute>=60){
                        $minute=$minute%60;
                        $hour ++;
                    }
                }
                echo '</tr><tr>';
            }?>
        </tr>
    </tbody>
</table>
<div class="modal fade" id="bookModal" role="dialog">
    <div class="modal-dialog" >

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Նոր հերթ</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id'=>'book_form']); ?>
                <?= $form->field($model,'phone')?>
                <?= $form->field($model,'name')?>
                <?= $form->field($model,'time')->hiddenInput(['id'=>'book_time'])->label(false)?>
                <?php ActiveForm::end()?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="book_form_submit">Պահպանել</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Փակել</button>
            </div>
        </div>

    </div>
</div>