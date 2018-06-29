<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_type_image".
 *
 * @property int $id
 * @property int $service_type_id
 * @property string $url
 * @property resource $name
 *
 * @property ServiceType $serviceType
 */
class ServiceTypeImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_type_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_type_id'], 'integer'],
            [['url', 'name'], 'string', 'max' => 255],
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
            'url' => Yii::t('app', 'Url'),
            'name' => Yii::t('app', 'Name'),
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
