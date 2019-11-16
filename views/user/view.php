<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Address;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $searchModel app\models\AddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->can('admin')):?>
	        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => 'Are you sure you want to delete this item?',
	                'method' => 'post',
	            ],
	        ]) ?>
	    <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'login',
            'name',
            'surname',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    /**@var $model \app\models\User */
                    return User::getGenderLabel($model->gender);
                },
            ],
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->date, 'dd-MM-Y HH:mm');
                }
            ],
            'email',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'index',
            'country',
            'city',
            'street',
            'building',
            'apartment',
        ],
    ]); ?>

</div>
