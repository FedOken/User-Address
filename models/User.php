<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use Yii;
use yii\widgets\ActiveForm;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $surname
 * @property string $gender
 * @property string $date
 * @property string $email
 * @property string $role
 * @property Address[] $addresses
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;

    const GENDER_MAN = 1;
    const GENDER_WOMAN = 2;
    const GENDER_DEFAULT = 3;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'name', 'surname', 'gender', 'date', 'email'], 'required'],
            [['date'], 'safe'],
            [['login', 'email'], 'unique',],
            [['login'], 'string', 'length' => [4, 255]],
            [['password'], 'string', 'length' => [6, 255]],
            [['name', 'surname', 'email', 'role'], 'string', 'max' => 255],
            [['gender'], 'integer', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'name' => 'Name',
            'surname' => 'Surname',
            'gender' => 'Gender',
            'date' => 'Create date',
            'email' => 'Email',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return array
     */
    public static function getGenderData()
    {
        return [
            self::GENDER_MAN => self::getGenderLabel(self::GENDER_MAN ),
            self::GENDER_WOMAN => self::getGenderLabel(self::GENDER_WOMAN ),
            self::GENDER_DEFAULT => self::getGenderLabel(self::GENDER_DEFAULT ),
        ];
    }

    /**
     * @return array
     */
    public static function getRoleData()
    {
        return [
            self::ROLE_USER => 'User',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    /**
     * @param $genderId
     * @return string
     */
    public static function getGenderLabel($genderId)
    {
        switch ($genderId) {
            case User::GENDER_MAN:
                return 'Man';
            case User::GENDER_WOMAN:
                return 'Woman';
            case User::GENDER_DEFAULT:
                return 'No indicated';
        }
        return '';
    }

    /**
     * @throws
     */
    public function dataProcessingBeforeSave()
    {
        //Edit input field
        $this->name = ucfirst($this->name);
        $this->surname = ucfirst($this->surname);
        //Set now time
        if (Yii::$app->controller->action->id === 'create') {
            $this->date = new Expression('NOW()');
            //Hash password
            $this->setPassword($this->password);
        }

        //Role
        if (!$this->role) {
            $this->role = self::ROLE_USER;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['user_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $model = new Address();

        if ($model->load(Yii::$app->request->post())) {

            $model->dataProcessingBeforeSave($this->id);

            if ($model->save()) {
                return parent::afterSave($insert, $changedAttributes);
            }
            User::deleteAll(['id' => $this->id]);
            return false;
        }
        return false;
    }
}
