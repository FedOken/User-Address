<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Address;
use app\models\AddressSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class MainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param User|Address $model
     * @return string|\yii\web\Response
     * @throws
     */
    public function setDataBeforeValidateAndSave($model)
    {
        if ($model->load(Yii::$app->request->post())) {

            $model->dataProcessingBeforeSave();

            if ($model->save()) {
                if (Yii::$app->controller->action->id === 'update') {
                    Yii::$app->session->setFlash('success', 'Update successful saved!');
                } else {
                    Yii::$app->session->setFlash('success', 'New object successful saved!');
                }
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('error', 'Something went wrong while saving data, this is a problem...');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (Yii::$app->controller->action->id === 'update') {
            return $this->render('update', ['model' => $model]);
        } elseif (Yii::$app->controller->action->id === 'create') {
            return $this->render('create', ['model' => $model]);
        } else {
            return $this->render('index');
        }
    }
}
