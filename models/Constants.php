<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "constants".
 *
 * @property string $key
 * @property string $value
 */
class Constants extends \yii\db\ActiveRecord
{
    const KEY_COUNTER = 'counter';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'constants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['key', 'value'], 'safe'],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => 'Key',
            'value' => 'Value',
        ];
    }
    public static function resetCounter($set=0){
        $counter = self::findOne(self::KEY_COUNTER);
        $counter->value = $set;
        $counter->save();
    }
    public static function getCounter($increment = true){
        $counter = self::findOne(self::KEY_COUNTER);
        if(empty($counter)){
            $counter = new self(['key'=>self::KEY_COUNTER,'value'=>0]);
        }
        if($increment){
            $counter->value++;
            $counter->save(false);
        }
        return $counter->value;
    }
}
