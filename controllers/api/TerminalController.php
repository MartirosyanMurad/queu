<?php
/**
 * Created by PhpStorm.
 * User: Murad
 * Date: 3/9/2018
 * Time: 4:51 PM
 */

namespace app\controllers\api;


use app\models\Book;
use app\models\ServiceType;
use app\models\Terminal;
use app\models\Tickets;

class TerminalController extends ApiBaseController
{
    public function actionGetConfig(){
        $terminal_id = \Yii::$app->request->post('id');
        return Terminal::find()->where(['id'=>$terminal_id])->asArray()->one();
    }
    public function actionGetServices(){
        $terminal_id = \Yii::$app->request->post('id');
        $terminal_id = (int)$terminal_id;
        $parent = \Yii::$app->request->post('parent');
        if($parent===0){$parent=null;}
        return Terminal::getServices($terminal_id,$parent);
    }
    public function actionCheckId(){
        $terminal_id = \Yii::$app->request->post('terminal_id');
        $termianl = Terminal::findOne($terminal_id);
        if($termianl){
            return [
                'respcode'=>1
            ];
        }
        return [
            'respcode'=>0
        ];
    }
    public function actionGetList(){
        return Terminal::find()->all();
    }
    public function actionIndex(){
        return ['status'=>'works'];

    }
    public function actionActivateCheck(){
        $phone = \Yii::$app->request->post('phone');
        $code = \Yii::$app->request->post('code');
        $booked_ticket = Book::find()->where([/*'phone'=>$phone,*/'code'=>$code, 'status'=>Book::STATUS_NEW])->one();
        if($booked_ticket){
            $user_id = $booked_ticket->user_id;
            $service = ServiceType::find()->where(['service_user_id'=>$user_id])->one();
            if($service){
                $return = Tickets::registerTicket($service->id, $booked_ticket->id);
                $return['check']['book_time']= substr($booked_ticket->time,0,5);
                if($return['respcode']==1){
                    $booked_ticket->status =Book::STATUS_DONE;
                    $booked_ticket->save();
                }
                return $return;
            }else{
                return [
                    'respcode'=>0,
                    'respmess'=>'Ընտրված ծառայությունը սխալ է։'
                ];
            }
        }else{
            return [
                'respcode'=>0,
                'respmess'=>'Տվյալները սխալ են։'
            ];
        }
    }
    public function actionGetFirstChars(){
        return ServiceType::getFirstChars();
    }
}