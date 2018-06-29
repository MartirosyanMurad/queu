<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_m_commands".
 *
 * @property int $id
 * @property int $type
 * @property int $command_id
 * @property int $t_m_id
 * @property int $status
 * @property string $done_time
 * @property string $command_type
 *
 * @property Commands $command
 */
class TMCommands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_m_commands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'command_id', 't_m_id'], 'required'],
            [['type', 'command_id', 't_m_id', 'status','command_type'], 'integer'],
            [['done_time'], 'safe'],
            [['command_id'], 'exist', 'skipOnError' => true, 'targetClass' => Commands::className(), 'targetAttribute' => ['command_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'command_id' => 'Command ID',
            't_m_id' => 'T M ID',
            'status' => 'Status',
            'done_time' => 'Done Time',
            'command_type' => 'Command Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommand()
    {
        return $this->hasOne(Commands::className(), ['id' => 'command_id']);
    }

    public static function addGroupCommand($id,$type,$command_id,$command_type, $is_group = null)
    {
        $t_m_command = new TMCommands();
        $t_m_command->command_id = $command_id;
        $t_m_command->command_type = $command_type;
        $t_m_command->type = $type;
        if(is_null($is_group)){
            $t_m_command->t_m_id = $id;
            $t_m_command->save();
        }else{
            foreach ($id as $id_one ){
                $t_m_command->isNewRecord=true;
                $t_m_command->id=null;
                $t_m_command->t_m_id = $id_one;
                $t_m_command->save();
            }
        }
    }
    public static function setDone($id){
        $model = self::findOne($id);
        $model->status = Commands::STATUS_DONE;
        $model->done_time = date('Y-m-d h:i:s');
        $model->save();
    }

}
