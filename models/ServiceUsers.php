<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_users".
 *
 * @property int $id
 * @property int $service_type_id
 * @property int $user_id
 *
 * @property ServiceType $serviceType
 */
class ServiceUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_type_id', 'user_id'], 'required'],
            [['service_type_id', 'user_id'], 'integer'],
            [['service_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceType::className(), 'targetAttribute' => ['service_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'service_type_id' => Yii::t('app', 'Service Type ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);
    }
}
