<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "commands".
 *
 * @property int $id
 * @property int $user_id
 * @property string $time
 * @property string $execute_time
 * @property int $command_type
 * @property string $command
 * @property string $params
 *
 * @property Users $user
 * @property TMCommands[] $tMCommands
 */
class Commands extends \yii\db\ActiveRecord
{
    const TYPE_MONITOR=2;
    const TYPE_TERMINAL = 1;
    const STATUS_NEW = 0;
    const STATUS_AUTO_DONE = 5;
    const STATUS_DONE = 10;
    const COMMAND_GROUP_POWER = 1;
    const COMMAND_GROUP_CONFIG = 2;
    const COMMAND_GROUP_BLOCK = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'command'], 'required'],
            [['user_id', 'command_type'], 'integer'],
            [['time', 'execute_time'], 'safe'],
            [['params'], 'string'],
            [['command'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Օգտվող',
            'time' => 'ընԺամանակ',
            'execute_time' => 'Execute Time',
            'command_type' => 'Type',
            'command' => 'Command',
            'params' => 'Params',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTMCommands()
    {
        return $this->hasMany(TMCommands::className(), ['command_id' => 'id']);
    }

    public static function getTypeFromApi($type_key){
        switch ($type_key){
            case 'monitor':
                return self::TYPE_MONITOR;
            case 'terminal':
                return self::TYPE_TERMINAL;
            default:
                return null;
        }
    }
    public static function getGroupByCommand($command){
        switch ($command){
            case 'off':
            case 'on':
            case 'restart':
                return self::COMMAND_GROUP_POWER;
            case 'getConfig':
                return self::COMMAND_GROUP_CONFIG;
            case 'block':
            case 'unblock':
                return self::COMMAND_GROUP_BLOCK;
        }
    }
    public static function addCommand($params){
        $command_name = ArrayHelper::getValue($params,'command_name');
        $command_params = ArrayHelper::getValue($params,'command_params',[]);
        $id = ArrayHelper::getValue($params,'id');
        $type = ArrayHelper::getValue($params,'type');
        $is_group = ArrayHelper::getValue($params,'is_group');
        $execute_time = ArrayHelper::getValue($params,'execute_time');
        if(is_null($execute_time)){
            $execute_time = date('Y-m-d h:i:s');
        }
        $command_type=self::getGroupByCommand($command_name);
        $command = new Commands();
        $command->command = $command_name;
        $command->params = Json::encode($command_params);
        $command->command_type = $command_type;
        $command->execute_time = $execute_time;
        $command->user_id = Yii::$app->user->getId();
        if($command->save()){
                TMCommands::addGroupCommand($id,$type,$command->id,$command_type, $is_group);
        };
    }
    public static function getCommandsList($t_m_id,$type)
    {
        $type = self::getTypeFromApi($type);
        switch ($type){
            case self::TYPE_TERMINAL:
                Terminal::updatePing($t_m_id);
                break;
            case self::TYPE_MONITOR:
                Monitor::updatePing($t_m_id);
                break;
        }
        $sql = "SELECT 
                  t_m_commands.id,command, params 
                FROM 
                  t_m_commands 
                    LEFT JOIN 
                      commands 
                    ON 
                      t_m_commands.command_id = commands.id
                WHERE 
                      t_m_id = :t_m_id 
                      AND  t_m_commands.type = :type
                      AND  t_m_commands.status = :status
                      AND commands.execute_time <= :time
                 ";
        $params = [
            't_m_id' => $t_m_id,
            'type' => $type,
            'status'=>self::STATUS_NEW,
            'time'=> date('Y-m-d H:i:s')
        ];
        return Yii::$app->db->createCommand($sql,$params)->queryAll();

    }
}
