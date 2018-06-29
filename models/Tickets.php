<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tickets".
 *
 * @property int $id
 * @property string $letter
 * @property int $number
 * @property int $queu_count
 * @property string $kanchi_date
 * @property string $kanchi_time
 * @property int $terminal_id
 * @property int $service_type_id
 * @property int $status
 * @property string $date
 * @property int $call_user_id
 * @property string $call_time
 * @property int $book_id
 *
 * @property Terminal $terminal
 */
class Tickets extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_CALLED = 1;
    const STATUS_APPROVED = 2;
    const STATUS_CANCELED = 3;
    const STATUS_ENDED = 4;
    const STATUS_REDIRECTED = 5;
    const STATUS_NEW_DAY = 6;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'queu_count', 'terminal_id', 'service_type_id', 'status'], 'integer'],
            [['kanchi_date', 'kanchi_time', 'date'], 'safe'],
            [['letter'], 'string', 'max' => 3],
            [['terminal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Terminal::className(), 'targetAttribute' => ['terminal_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'letter' => 'Տառ',
            'number' => 'Համար',
            'queu_count' => 'Հերթում սպասողների քանակ',
            'kanchi_date' => 'Կանչի ամսաթիվ',
            'kanchi_time' => 'Կանչի ժամ',
            'terminal_id' => 'Terminal ID',
            'service_type_id' => 'Service Type ID',
            'status' => 'Կարգավիճակ',
            'date' => 'Տպագրման ամսաթիվ/ժամ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminal()
    {
        return $this->hasOne(Terminal::className(), ['id' => 'terminal_id']);
    }
    public function getServiceType(){
        return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);
    }
    public function getBook(){
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
    public static function registerTicket($service_id,$booked=0){
        $service = ServiceType::findOne($service_id);
        $counter = Constants::getCounter();
        $model = new self();
        $model->service_type_id = $service->id;
        $model->letter = $service->service_letter;
        $model->number = $counter;
        $model->status = self::STATUS_NEW;
        $model->book_id = $booked;
        $model->date = date('Y-m-d H:i');
        $model->save();
        $return =  [
            'check'=>array_merge([
                'code'=>$service->service_letter.$counter,
                'date'=> date('d/m/Y H:i'),
                'name'=> $service->name,
                'parent_id' => $service->parent_id
            ],self::getWaitTime($service->id, $model->id,$service->one_queu_time))
        ];
        if($booked){
            $return['respcode'] = 1;
        }
        return $return;

    }
    public static function getWaitTime($service_id,$ticket_id,$time){
        if(empty($time)){
            $time = Yii::$app->params['one_queu_time'];
        }
        $query = "SELECT COUNT(id) FROM tickets WHERE service_type_id=:service_id AND status=:status AND id<:ticket_id";
        $ticket_count = Yii::$app->db->createCommand($query,[
            'service_id'=>$service_id,
            'status'=>self::STATUS_NEW,
            'ticket_id'=>$ticket_id,
        ])->queryScalar();
        $wait_minutes = $ticket_count*$time;
        $wait_time = strtotime('+ '.$wait_minutes.' minutes');
        return [
            'wait_time'=>date('d/m/Y H:i:s',(int)$wait_time),
            'timestamp'=>$wait_minutes,
            'count'=>$ticket_count
        ];
    }
    public static function getCalledTickets(){

        $query = "SELECT tickets.*, users.image,users.fname, users.lname,users.room FROM tickets LEFT JOIN users ON users.id = tickets.call_user_id
              WHERE status=:status ORDER BY id DESC LIMIT 6 ";
        return Yii::$app->db->createCommand($query,[
            'status'=>self::STATUS_CALLED
        ])->queryAll();
    }
    public static function redirect($ticket_id, $service){
        $ticket = self::findOne($ticket_id);
        $ticket->service_type_id = $service;
        $ticket->status = self::STATUS_REDIRECTED;
        $ticket->save();
        return [
            'respcode'=>1,
            'check'=>[
                'code'=>$ticket->letter.$ticket->number,
            ]
        ];
    }
    public static function getWaitCount($user_id){
        return self::find()->where(['status'=>Tickets::STATUS_NEW])
            ->andWhere('`service_type_id` IN (SELECT `service_type_id` FROM `service_users` WHERE user_id = :user_id)')
            ->params(['user_id'=>$user_id])
            ->count();
    }
    public static function getNextTicketId($user_id){
        $sql = 'SELECT book.date AS book_date,book.time, 
            CASE WHEN (book.date=CURDATE() AND book.time<=TIME(NOW() + INTERVAL 10 MINUTE) AND TIME(tickets.`date` - INTERVAL 10 MINUTE)<book.time) THEN 1 ELSE 0 END AS book_ok,tickets.*
            FROM tickets 
            LEFT JOIN book ON tickets.`book_id` = book.id
            WHERE `service_type_id` IN (SELECT `service_type_id` FROM `service_users` WHERE user_id = :user_id)
             AND tickets.status<=:status
            ORDER BY book_ok DESC,tickets.id ASC
             LIMIT 1';
        $ticket = Yii::$app->db->createCommand($sql,['user_id'=>$user_id, 'status'=>self::STATUS_CALLED])->queryOne();
        if($ticket){
            return $ticket['id'];
        }
        return null;
    }
    public static function getUserWaitCount($user_id){
        $sql = 'SELECT count(*) FROM tickets WHERE service_type_id = (SELECT id FROM service_type WHERE service_user_id = :user_id LIMIT 1) AND STATUS = :status ';
        return Yii::$app->db->createCommand($sql,['status'=>Tickets::STATUS_NEW,'user_id'=>$user_id])->queryScalar();
    }

    public static function newDay(){
        $done_status_list = [self::STATUS_CANCELED, self::STATUS_ENDED];
        $sql = 'UPDATE tickets SET status = '.self::STATUS_NEW_DAY.' WHERE status NOT IN ('.implode(',',$done_status_list).')';
        Yii::$app->db->createCommand($sql)->execute();
    }
    public static function getStatus($index=null){
        $types=[
            self::STATUS_CALLED => 'Կանչված',
            self::STATUS_APPROVED => 'Հրավիրած',
            self::STATUS_CANCELED => 'Չեղարկած',
            self::STATUS_ENDED => 'Ավարտած',
        ];
        if(!is_null($index)){
            return ArrayHelper::getValue($types,$index);
        }
        return $types;
    }
}
