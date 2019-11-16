<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $modelAddress app\models\Address */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['validateOnBlur' => false, 'enableClientValidation' => true, 'enableAjaxValidation' => true]); ?>

<div class="row">
	<div class="col-md-<?= isset($modelAddress) ? '6' : '12' ?>">

        <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

        <?php if (Yii::$app->controller->action->id === 'create'): ?>
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value'=>'']) ?>
        <?php endif; ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'gender')->widget(Select2::classname(), [
            'data' => $model->getGenderData(),
            'options' => ['placeholder' => 'Select gender...'],
            'hideSearch' => true,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'role')->widget(Select2::classname(), [
            'data' => User::getRoleData(),
            'options' => ['placeholder' => 'Select role...'],
            'hideSearch' => true,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
	</div>
    <?php if (isset($modelAddress)): ?>
		<div class="col-md-6">
            <?= $form->field($modelAddress, 'index')->textInput() ?>

            <?= $form->field($modelAddress, 'country')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelAddress, 'city')->textInput() ?>

            <?= $form->field($modelAddress, 'street')->textInput() ?>

            <?= $form->field($modelAddress, 'building')->textInput() ?>

            <?= $form->field($modelAddress, 'apartment')->textInput() ?>
		</div>
    <?php endif ?>
</div>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>


