<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "monitor".
 *
 * @property int $id
 * @property string $number
 * @property int $configuration_view_id
 * @property int $terminal_monitor_group_id
 *
 * @property TerminalMonitorGroup $terminalMonitorGroup
 * @property ConfigurationViews $configurationView
 */
class Monitor extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['configuration_view_id', 'terminal_monitor_group_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['terminal_monitor_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => TerminalMonitorGroup::className(), 'targetAttribute' => ['terminal_monitor_group_id' => 'id']],
            [['configuration_view_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfigurationViews::className(), 'targetAttribute' => ['configuration_view_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Համար',
            'configuration_view_id' => 'Կոնֆիգուրացիայի տեսք',
            'terminal_monitor_group_id' => 'Խումբ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminalMonitorGroup()
    {
        return $this->hasOne(TerminalMonitorGroup::className(), ['id' => 'terminal_monitor_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigurationView()
    {
        return $this->hasOne(ConfigurationViews::className(), ['id' => 'configuration_view_id']);
    }

    public static function getConfig($monitor_id){
        //todo
        $monitor = self::findOne($monitor_id);
        $data = [];
        if($monitor->configurationView){
            $data = $monitor->configurationView->getAttributes();
            $data['images']=[];
            foreach ($monitor->configurationView->imageList as $img){
                $img['url'] = Url::to([$img['url']],true);
                $data['images'][]=$img;
            }
        }
        return $data;
    }
}
