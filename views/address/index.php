<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use app\models\Address;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Addresses';
?>
<div class="address-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Address', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'value' => 'user.login',
                'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
                'filter' => Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'user_id',
                        'data' => ArrayHelper::map(Address::getAllRelatedUser(), 'id', 'login'),
                        'options' => [
                            'prompt' => Yii::t('app', 'Select user...'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]
                ),
            ],
            'index',
            'country',
            'city',
            'street',
            'building',
            'apartment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
