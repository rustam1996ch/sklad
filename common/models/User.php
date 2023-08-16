<?php

namespace common\models;

use mdm\admin\models\User as UserModel;
use sklad\models\Role;
use Yii;
use yii\base\Exception;

/**
 * User model
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $username
 * @property string $full_name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property string $type_social
 * @property string $access_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends UserModel
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $new_password;

    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['username', 'password_hash', 'email','full_name'], 'string', 'max' => 255],
            [['role_id'],  'integer'],
            [['username'],  'unique'],
            [['email'], 'email'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'username' => 'Логин',
            'password_hash' => 'Пароль',
            'new_password' => 'Новый Пароль',
            'email' => 'Email',
            'full_name' => 'ФИО',
        ];
    }

    public function generateEmailVerificationToken()
    {
        try {
            $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
        } catch (Exception $e) {
        }
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    public function generateAccessToken()
    {
        try {
            $this->access_token = Yii::$app->security->generateRandomString();
        } catch (Exception $e) {
        }
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole(){
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

}
