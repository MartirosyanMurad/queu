<?php

namespace app\models;

use Yii;
use yii\helpers\BaseMarkdown;

/**
 * This is the model class for table "terminal".
 *
 * @property int $id
 * @property string $number
 * @property int $configuration_view_id
 * @property int $terminal_monitor_group_id
 *
 * @property ConfigurationViews $configurationView
 * @property TerminalMonitorGroup $terminalMonitorGroup
 * @property Tickets[] $tickets
 */
class Terminal extends BaseModel
{
    const BLOCKED_FALSE = 0;
    const BLOCKED_TRUE = 1;
    static $block=[
        self::BLOCKED_FALSE=>'Ակտիվ',
        self::BLOCKED_TRUE=>'Պասիվ',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'terminal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['configuration_view_id', 'terminal_monitor_group_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['configuration_view_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfigurationViews::className(), 'targetAttribute' => ['configuration_view_id' => 'id']],
            [['terminal_monitor_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => TerminalMonitorGroup::className(), 'targetAttribute' => ['terminal_monitor_group_id' => 'id']],
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
            'last_ping' => 'Վերջին ակտիվություն',
            '' => 'Խումբ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigurationView()
    {
        return $this->hasOne(ConfigurationViews::className(), ['id' => 'configuration_view_id']);
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
    public function getTickets()
    {
        return $this->hasMany(Tickets::className(), ['terminal_id' => 'id']);
    }
    public static function getServices($terminal_id,$parent){
        $query = 'SELECT services FROM configuration_views WHERE id = (
              SELECT configuration_view_id FROM terminal WHERE id=:terminal_id
        )';
        $service_ids = Yii::$app->db->createCommand($query,['terminal_id'=>$terminal_id])->queryScalar();
        $result=ServiceType::find()->where(['parent_id'=>$parent]);
        if($service_ids){
            $result = $result->andWhere('id IN ('.$service_ids.')')->orderBy('`order`, `name`');
        }
        $result=$result->asArray()->all();
        if(empty($result)){
            return self::getCheck($parent);
        }
        if($parent == ServiceType::ALL_USERS_SERVICE_ID){
            foreach ($result as $index =>$service) {
                $query = 'SELECT image FROM users WHERE id = :user_id';
                $image = Yii::$app->db->createCommand($query, ['user_id' => $service['service_user_id']])->queryScalar();
                $result[$index]['user_image'] = $image;
            }
        }
        /*foreach ($result as $index =>$service){
            $query = 'SELECT url FROM service_type_image WHERE service_type_id = :service_id';
            $images = Yii::$app->db->createCommand($query,['service_id'=>$service['id']])->queryColumn();
            $result[$index]['images']=$images;
        }*/
        return $result;
    }
    public static function getCheck($service_id){
        return Tickets::registerTicket($service_id);

    }

    public static function block($terminal_id,$block){
        $query = 'UPDATE '.self::tableName().' SET is_blocked = :block WHERE id=:id';
        $params = [
            'block'=>$block,
            'id'=>$terminal_id
        ];
        \Yii::$app->db->createCommand($query,$params)->execute();
        Commands::addCommand([
            'command_name'=>$block?'block':'unblock',
            'id'=>$terminal_id,
            'type'=>Commands::TYPE_TERMINAL,
        ]);
    }

}
