<?php
namespace api\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use filsh\yii2\oauth2server\filters\auth\CompositeAuth;
use common\models\forms\ResetPasswordForm;
use common\models\forms\SignupForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AuthController extends BaseAuthController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['reset'],
                    'allow' => true
                ]
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'reset' => ['post'],
            ],
        ];

        return $behaviors;
    }

    public function actionReset() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new ResetPasswordForm();
        $model->load($bodyParams, '');
        $model->validate();
        if (!$model->reset()) {
            if ($model->hasErrors()) {
                return $model;
            } else {
                throw new \yii\web\ServerErrorHttpException("Инструкция не выслана.");
            }
        }
        return ["msg" => "Instructions was sent to the email."];
    }
}