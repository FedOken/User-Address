<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $index
 * @property string $country
 * @property int $city
 * @property int $street
 * @property int $building
 * @property int $apartment
 * @property User $user
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'index', 'country', 'city', 'street', 'building'], 'required'],
            [['user_id'], 'integer'],
            [['country'], 'string', 'length' => [2, 2]],
            [['city', 'street', 'building', 'apartment', 'index'], 'string', 'max' => 255],
            ['country', 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'Only english latter.'],
            ['index', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Only number.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User login',
            'index' => 'Index',
            'country' => 'Country',
            'city' => 'City',
            'street' => 'Street',
            'building' => 'Building',
            'apartment' => 'Apartment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @param null|integer $userId
     */
    public function dataProcessingBeforeSave($userId = null)
    {
        //Edit input field
        $this->country = mb_strtoupper($this->country);
        //Set user from user create
        if ($userId && !$this->user_id) {
            $this->user_id = $userId;
        }
    }

    public static function getAllRelatedUser()
    {
        $addressIds = ArrayHelper::getColumn(Address::find()->all(), 'user_id');
        $addressIds = array_unique($addressIds);
        return User::find()->where(['id' => $addressIds])->all();
    }
}
