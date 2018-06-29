<?php

namespace app\models;

use app\controllers\BaseController;
use app\helpers\Errors;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $fname
 * @property string $lname
 * @property string $mname
 * @property string $image
 * @property int $type_id
 * @property string $queue_type
 * @property string $email
 * @property string $phone
 * @property int $groups_id
 * @property string $password
 * @property string $token
 *
 * @property Types $type
 * @property Groups $groups
 * @property UploadedFile $image_file
 */
class Users extends BaseModel implements IdentityInterface
{
    const SCENARIO_REG = 'registration';
    /**
     * @inheritdoc
     */

    public $image_file;
    public $confirm_password;
    public $old_password;

    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'groups_id'], 'integer'],
            [['image_file','old_password','confirm_password','password','token','room'], 'safe'],
            [['username'], 'required'],
            [['username'], 'unique'],
            [['email'], 'email'],
            [['password', 'confirm_password'], 'required', 'on'=>self::SCENARIO_REG],
            [['password', 'confirm_password'], 'required', 'on'=>self::SCENARIO_REG],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match", 'skipOnEmpty'=>false],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, jpeg'],
            [['fname','lname','mname', 'image', 'queue_type', 'phone', 'password','username','auth_key',], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Types::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['groups_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['groups_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'Անուն',
            'lname' => 'Ազգանուն',
            'mname' => 'Հայրանուն',
            'username' => 'Մուտքանուն',
            'image' => 'Նկար',
            'image_file' => 'Նկար',
            'type_id' => 'Օգտվողի տիպ',
            'queue_type' => 'Հերթի տիպպ',
            'email' => 'Էլ․ փոստ',
            'phone' => 'Հեռախոս',
            'groups_id' => 'Խումբ',
            'password' => 'Գաղտնաբառ',
            'confirm_password' => 'Կրկնել գաղտնաբառ',
            'auth_key' => 'Auth Key',
            'room' => 'Սենյակ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Types::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasOne(Groups::className(), ['id' => 'groups_id']);
    }

    public function upload()
    {
        $this->image_file = UploadedFile::getInstance($this, 'image_file');
        if ($this->validate()) {
            if(isset($this->image_file)){
                $url_img = 'uploads/' . $this->image_file->baseName .time(). '.' . $this->image_file->extension;
                $this->image_file->saveAs($url_img,false);
                $this->image = '/'.$url_img;
            }
        }
    }
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if($token===null){
            return null;
        }
        return self::find()->where(['token'=>$token])->one();
    }
    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }
    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function validatePassword($password)
    {
//        var_dump($password);
//        var_dump($this->password);
//        die;
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;

    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->auth_key = $this->generateAuthKey();
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }elseif(!empty($this->password)){
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }else{
            $this->password = $this->getOldAttribute('password');
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    public function oldPasswordsIsValide()
    {
        if(Yii::$app->security->validatePassword('qwerty',$this->password)) {
            return true;
        }else{
            Yii::$app->session->setFlash('error','Old password is incorrect');
            return false;
        }
    }
    public function getDisplayName(){
        return $this->fname.' '.$this->lname.' '.$this->mname;
    }
    public static function apiLogin($username,$password){
        $user = self::findByUsername($username);/*
        return [
            'user_hash' => $user->password_hash,
            'ttt'=>(Yii::$app->security->validatePassword($password, $user->password_hash))?$user->password_hash:'kky'
        ];*/
        if($user && $user->validatePassword($password)){
            $user->token = md5(rand(8000,55555));// Yii::$app->security->generateRandomKey();
            $user->save(false,['token']);
            return[
                'respcode'=>1,
                'data'=>[
                    'id'=> $user->id,
                    'fname'=>$user->fname,
                    'lname'=>$user->lname,
                    'mname'=>$user->mname,
                    'token'=>$user->token,
                ]
            ];
        }else{
            return [
                'respcode'=>0,
                'respmess'=>Errors::getMessage('user_not_found')
            ];
        }

    }
    public function addUserToServiceList(){
        $service = ServiceType::getModelByParams(['service_user_id'=>$this->id]);
        $service->name = $this->lname.' '.$this->fname;
        if($service->isNewRecord){
            $service->service_letter = ServiceType::ALL_USERS_SERVICE_LETTER;
        }
        $service->parent_id = ServiceType::ALL_USERS_SERVICE_ID;
        $service->active_passive = ServiceType::ACTIVE;
        $service->service_user_id = $this->id;
        $service->order = ($service->order)?$service->order:100;
        $service->users = [$this->id];
        $service->save();
    }
    public static function updateUsersServiceList(){
        $sql = 'UPDATE 
                  service_type 
                SET 
                  `service_user_id` = (
                    SELECT 
                      user_id 
                    FROM 
                      service_users 
                    WHERE 
                      service_users.`service_type_id`=service_type.id
                  )
                WHERE 
                  parent_id = 21';

        Yii::$app->db->createCommand($sql)->execute();
    }
    public function afterSave($insert, $changedAttributes)
    {
        if($this->type_id==Types::SPASARKOX){
            $this->addUserToServiceList();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
