<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use JWT;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $steam_name
 * @property string $steam_hash
 * @property string $jwt_token
 * @property string $avatar
 * @property int $balance
 * @property int $bonuses
 * @property string $trade_url
 * @property string $vk_link
 * @property string $youtube_link
 * @property string $user_products
 * @property string $user_cases
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_SUPERUSER = 'superuser';
    const ROLE_REGISTERED = 'registered';
    const ROLE_GUEST = 'guest';

    public $profile, $authKey, $file;

    static public function roleArray()
    {
        return [
            self::ROLE_SUPERUSER,
            self::ROLE_REGISTERED,
            self::ROLE_GUEST,
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['steam_name', 'avatar'], 'string', 'max' => 500],
            [['steam_hash', 'jwt_token', 'trade_url', 'vk_link', 'youtube_link', 'user_products', 'user_cases'], 'string', 'max' => 1000],
            [['auth_key'], 'string', 'max' => 32],
            [['balance', 'bonuses'], 'number'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['file'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 502400, 'tooBig' => 'Файл слишком большой', 'checkExtensionByMimeType' => false]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'steam_name' => 'Steam Name',
            'steam_hash' => 'Steam Hash',
            'jwt_token' => 'Jwt Token',
            'avatar' => 'Avatar',
            'balance' => 'Баланс',
            'bonuses' => 'Бонусы',
            'trade_url' => 'Trade Url',
            'vk_link' => 'Vk ссылка',
            'youtube_link' => 'Youtube ссылка',
            'user_products' => 'User Products',
            'user_cases' => 'User Cases',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Статус',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Последняя активность',
            'file' => 'Аватар'
        ];
    }

    /* OLD Func 
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
   //=============*/

    public static function findIdentity($id)
    {
        $identity =  static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        if ($identity) return $identity;
        else {
            if (Yii::$app->getSession()->has('user-' . $id)) {
                return new self(Yii::$app->getSession()->get('user-' . $id));
            } else {
                return isset(self::$users[$id]) ? new self(self::$users[$id]) : null;
            }
        }
    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service)
    {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $id = $service->getServiceName() . '-' . $service->getId();
        $attributes = [
            'id' => $id,
            'username' => $service->getAttribute('name'),
            'authKey' => md5($id),
            'profile' => $service->getAttributes(),
        ];
        $attributes['profile']['service'] = $service->getServiceName();
        Yii::$app->getSession()->set('user-' . $id, $attributes);

        $accessJwt = new \Lindelius\JWT\JWT(); // инициализируем
        $tokenExp = time() + 84600; // время жизни токена
        $accessJwt->exp = $tokenExp; // пишем в переменную
        $accessJwt->iat = time(); // время создания
        $accessJwt->sub = $id; // тут добавляем айди юзера в токен
        $accessToken = $accessJwt->encode('gixEZ2rUvQBnNGBL6iT7'); // енкодим его ключом

        setcookie("LoginToken", $accessToken, $tokenExp, "/", 'vipdrop.net'); // пишем в куку

        return new self($attributes);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    static public function getRoleOfUser($id)
    {
        return (new Query)
            ->select('role')
            ->from(self::tableName())
            ->where(['id' => $id])
            ->scalar();
    }

    public function getRole()
    {
        $identity = $this->getIdentity();
        return $identity !== null ? $identity->role : null;
    }
}