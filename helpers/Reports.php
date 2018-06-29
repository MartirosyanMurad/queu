<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.05.2018
 * Time: 15:36
 */
namespace app\helpers;
use app\models\Tickets;
use Yii;

class Reports
{
    public  static function getReportByUser($date){
        $sql = 'SELECT 
                    CONCAT(`users`.fname," ",`users`.lname) as name,
                    call_user_id,
                    COUNT(tickets.id) AS num_all,
                    SUM(CASE WHEN `status` = :status_canceled THEN 1 ELSE 0 END) AS status3,
                    SUM(CASE WHEN `status` = :status_ended THEN 1 ELSE 0 END) AS status2
                FROM tickets 
                LEFT JOIN users
                   ON 
                   `tickets`.call_user_id = `users`.id 
                   WHERE
                   CONVERT(`tickets`.`date`,DATE)   =  :date
                   AND 
                   call_user_id is NOT null
                   GROUP BY call_user_id';
        $res = Yii::$app->db->createCommand($sql,['date' => $date,'status_canceled'=>Tickets::STATUS_CANCELED,'status_ended'=>Tickets::STATUS_ENDED])->queryAll();
        return $res;

    }
   public static function getReportByService($date){
        $sql = 'SELECT 
                     `name`,
                    `service_type_id`,
                    COUNT(tickets.id) AS num_all,
                    SUM(CASE WHEN `status` = :status_canceled THEN 1 ELSE 0 END) AS status3,
                    SUM(CASE WHEN `status` = :status_ended THEN 1 ELSE 0 END) AS status2
                FROM tickets 
                LEFT JOIN service_type
                   ON 
                   `tickets`.service_type_id = service_type.id 
                   WHERE
                   CONVERT(`tickets`.`date`,DATE)   = :date
                   AND 
                   service_type.service_user_id is null
                   GROUP BY service_type.id ;';
    $res = Yii::$app->db->createCommand($sql,['date' => $date,'status_canceled'=>Tickets::STATUS_CANCELED,'status_ended'=>Tickets::STATUS_ENDED])->queryAll();
    return $res;
    }
    public  static function getReportViewUser($id,$date){
        $sql = 'SELECT 
                    CONCAT(letter,"",`tickets`.number) as let_num,
                    CONVERT(`tickets`.`date`,TIME ) as time,
                    CONVERT(`tickets`.`call_time`,TIME) AS call_time,
                    status
        
                FROM tickets 
                   WHERE
                   DATE (`tickets`.`date`)   =  :date
                   AND 
                   call_user_id = :id';
        $res = Yii::$app->db->createCommand($sql,['date' => $date,'id' => $id])->queryAll();
        return $res;

    }
    public  static function getReportViewService($id,$date){
        $sql = 'SELECT 
                    CONCAT(`users`.fname," ",`users`.lname) as name,
                    CONCAT(letter,"",`tickets`.number) as let_num,
                    CONVERT(`tickets`.`date`,TIME ) as time,
                    CONVERT(`tickets`.`call_time`,TIME) AS call_time,
                    status
        
                FROM tickets
                LEFT JOIN users
                   ON 
                   `tickets`.call_user_id = `users`.id  
                   WHERE
                   DATE (`tickets`.`date`)   =  :date
                   AND 
                   service_type_id = :id';
        $res = Yii::$app->db->createCommand($sql,['date' => $date,'id' => $id])->queryAll();
        return $res;

    }
}