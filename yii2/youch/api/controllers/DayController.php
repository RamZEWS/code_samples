<?php

namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DayController extends BaseAuthActiveController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index', 'view'],
                    'allow' => true
                ],
                [
                    'actions' => ['create', 'delete', 'update'],
                    'allow' => true,
                    'roles' => ['admin']
                ],
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['GET'],
                'create' => ['POST'],
                'delete' => ['DELETE'],
                'update' => ['PUT', 'PATCH']
            ],
        ];

        return $behaviors;
    }

    public $modelClass = 'api\models\WeekDay';
}