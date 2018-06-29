<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int $user_id
 * @property string $date
 * @property string $time
 * @property string $phone
 * @property string $code
 * @property string $create_date
 * @property int $creator_id
 * @property string $name
 */
class Book extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    const STATUS_NEW =0;
    const STATUS_DONE = 1;
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'date', 'time', 'phone'], 'required'],
            [['user_id', 'creator_id'], 'integer'],
            [['date', 'time', 'create_date'], 'safe'],
            [['phone', 'code'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'time' => 'Time',
            'phone' => 'Phone',
            'code' => 'Code',
            'create_date' => 'Create Date',
            'creator_id' => 'Creator ID',
            'name' => 'Name',
        ];
    }
    public function beforeSave($insert)
    {
        $this->creator_id = Yii::$app->user->id;
        $this->code = rand('10000','99999');
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
