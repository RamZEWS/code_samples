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
use common\models\forms\GoogleCityForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class RegisterController extends BaseAuthController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['step1'],
                    'allow' => true
                ],
                [
                    'actions' => ['step2', 'step3', 'step4'],
                    'allow' => true,
                    'roles' => ['@']
                ],
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'step1' => ['post'],
                'step2' => ['post'],
                'step3' => ['post'],
                'step4' => ['post']
            ],
        ];

        return $behaviors;
    }

    public function actionStep1() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new SignupForm(['scenario' => SignupForm::STEP_1]);
        $model->load($bodyParams, '');
        if ($model->validate()) {
            return $model->step1();
        } else {
            return $model;
        }
    }

    public function actionStep2() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new SignupForm(['scenario' => SignupForm::STEP_2]);
        $model->load($bodyParams, '');
        if ($model->validate()) {
            return $model->step2();
        } else {
            return $model;
        }
    }

    public function actionStep3() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new GoogleCityForm();
        $model->load($bodyParams, '');
        if ($model->validate() && $city = $model->getOrCreate()) {
            $signup = new SignupForm(['scenario' => SignupForm::STEP_3, 'city_id' => $city->id]);
            return $signup->step3();
        } else {
            return $model;
        }
    }

    public function actionStep4() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new SignupForm(['scenario' => SignupForm::STEP_4]);
        $model->load($bodyParams, '');
        if ($model->validate()) {
            return $model->step4();
        } else {
            return $model;
        }
    }
}