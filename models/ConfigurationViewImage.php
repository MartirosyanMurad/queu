<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuration_view_image".
 *
 * @property int $id
 * @property int $configuration_view_id
 * @property string $url
 * @property resource $name
 *
 * @property ConfigurationViews $configurationView
 */
class ConfigurationViewImage extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuration_view_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['configuration_view_id'], 'integer'],
            [['url', 'name'], 'string', 'max' => 255],
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
            'configuration_view_id' => 'Configuration View ID',
            'url' => 'Url',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigurationView()
    {
        return $this->hasOne(ConfigurationViews::className(), ['id' => 'configuration_view_id']);
    }
}
