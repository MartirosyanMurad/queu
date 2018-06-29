<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "terminal_monitor_group".
 *
 * @property int $id
 * @property string $name Կոնֆիգուրացիայի տեսք
 * @property string $key
 */
class TerminalMonitorGroup extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'terminal_monitor_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'key'], 'required'],
            [['name', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Անվանում'),
            'key' => Yii::t('app', 'Key'),
        ];
    }
}
