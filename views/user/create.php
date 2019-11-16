<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $modelAddress app\models\User */

$this->title = 'Create user';
?>
<div class="user-create row">
	<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelAddress' => $modelAddress,
    ]) ?>
</div>
