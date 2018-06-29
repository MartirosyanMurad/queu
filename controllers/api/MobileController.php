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
use app\models\Users;
use Codeception\Module\Yii1;
use yii\helpers\Json;

class MobileController extends ApiBaseController
{
    public $user = null;
    public $token = null;
    public function beforeAction($action)
    {
        $parent_befor_action = parent::beforeAction($action);
        $this->token = \Yii::$app->request->post('token');
        $this->user = Users::findIdentityByAccessToken($this->token);
        if($this->token && !$this->user){
            echo Json::encode([
                'respcode'=>15,
                'respmess'=>"Auto Log Out"
            ]);
            \Yii::$app->end();
        }
        return $parent_befor_action;
    }

    public function actionLogin(){
        $password = \Yii::$app->request->post('password');
        $phone = \Yii::$app->request->post('username');
        return Users::apiLogin($phone,$password);
    }
    public function actionCallNext(){
        if($this->user){
            $ticket_id = Tickets::getNextTicketId($this->user->id);
            if($ticket_id){
                $ticket = Tickets::findOne($ticket_id);
                $ticket->status = Tickets::STATUS_CALLED;
                $ticket->call_user_id = $this->user->id;
                $ticket->call_time = date('Y-m-d H:i:s');
                $ticket->save();
                if($ticket->book_id){

                }
                return [
                    'respcode'=>1,
                    'ticket'=>$ticket,
                ];
            }
            return [
                'respcode'=>0,
                'respmess'=>"Հերթում սպասող չկա"
            ];
        }
        return [
            'respcode'=>1,
            'respmess'=>'callNext action'
        ];
    }
    public function actionGetCount(){
        if($this->user){
            $ticket_count = Tickets::getWaitCount($this->user->id);
            $user_ticket_counts = Tickets::getUserWaitCount($this->user->id);

            return [
                'respcode'=>1,
                'ticket_count'=>$ticket_count,
                'user_ticket_counts'=>$user_ticket_counts
            ];
        }
        return [
            'respcode'=>1,
            'respmess'=>'getCount action'
        ];
    }
    public function actionAccept(){
        $ticket_id =  \Yii::$app->request->post('ticket_id');
        $ticket = Tickets::findOne($ticket_id);
        if($ticket){
            $ticket->status=Tickets::STATUS_APPROVED;
            $ticket->save();
            return [
                'respcode'=>1,
            ];
        }
        return [
            'respcode'=>0,
            'respmess'=>"Հերթում սպասող չկա"
        ];
    }
    public function actionCancel(){
        $ticket_id =  \Yii::$app->request->post('ticket_id');
        $ticket = Tickets::findOne($ticket_id);
        if($ticket){
            $ticket->status=Tickets::STATUS_CANCELED;
            $ticket->save();
            return [
                'respcode'=>1,
            ];
        }
        return [
            'respcode'=>0,
            'respmess'=>"Հերթում սպասող չկա"
        ];
    }
    public function actionEnd(){
        $ticket_id =  \Yii::$app->request->post('ticket_id');
        $ticket = Tickets::findOne($ticket_id);
        if($ticket){
            $ticket->status=Tickets::STATUS_ENDED;
            $ticket->save();
            return [
                'respcode'=>1,
            ];
        }
        return [
            'respcode'=>0,
            'respmess'=>"Հերթում սպասող չկա"
        ];
    }
    public function actionGetServices(){
        $terminal_id = \Yii::$app->request->post('id');
        $terminal_id = (int)$terminal_id;
        $parent = \Yii::$app->request->post('parent');
        $ticket_id = \Yii::$app->request->post('ticket_id');
        if($parent===0){$parent=null;}
        $result=ServiceType::find()->where(['parent_id'=>$parent])->asArray()->all();
        if(empty($result)){
            return Tickets::redirect($ticket_id, $parent);
        }
        return $result;
    }
    public function actionGetBookList(){
        if($this->user){
            $date = \Yii::$app->request->post('date');
            $filter = ['user_id'=>$this->user->id, 'date'=>substr($date,0,10)];
            $book_times = Book::find()->where($filter)->orderBy('`time`')->asArray()->all();

            return $book_times;
        }
        return [
            'respcode'=>1,
            'respmess'=>'get book list'
        ];
    }
}