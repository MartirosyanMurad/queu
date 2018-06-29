<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "types".
 *
 * @property int $id
 * @property string $name
 *
 * @property Users[] $users
 */
class Types extends BaseModel
{
    const SPASARKOX = 1;
    const ADMIN = 2;
    const OPERATOR = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['type_id' => 'id']);
    }
}
