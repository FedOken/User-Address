<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'email',
            'login',
            'name',
            'surname',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
    	            /**@var $model \app\models\User */
    	            return User::getGenderLabel($model->gender);
                },
                'filter' => Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'gender',
                        'data' => User::getGenderData(),
                        'options' => [
                            'prompt' => Yii::t('app', 'Select gender...'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]
                ),
            ],
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->date, 'dd-MM-Y HH:mm');
                }
            ],
            [
                'attribute' => 'role',
                'filter' => Select2::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'role',
                        'data' => User::getRoleData(),
                        'options' => [
                            'prompt' => Yii::t('app', 'Select role...'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]
                ),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
