<?php
/**
 * Created by PhpStorm.
 * User: comp
 * Date: 11/30/2017
 * Time: 10:06 AM
 */

namespace app\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class BaseModel extends ActiveRecord
{
    public static function getList($col='name')
    {
        return ArrayHelper::map(static::find()->all(), 'id', $col);
    }
    public static function getConstList($const_key,$index=null){
        try {
            $list =static::$$const_key;
            if($index!==null){
                return ArrayHelper::getValue($list,$index);
            }
            return $list;
        }catch (Exception $e){
            return null;
        }
    }

    public static function getValueById($id,$column_name = 'name')
    {
        return static::findOne($id)->$column_name;
    }
    public static function updatePing($id){
        $query = 'UPDATE '.static::tableName().' SET last_ping = :last_ping WHERE id=:id';
        $params = [
            'last_ping'=>date('Y-m-d H:i:s'),
            'id'=>$id
        ];
        \Yii::$app->db->createCommand($query,$params)->execute();
    }
    public static function getModelByParams($params){
        $model = static::find()->where($params)->one();
        if(empty($model)){
            return new static($params);
        }
        return $model;
    }
}