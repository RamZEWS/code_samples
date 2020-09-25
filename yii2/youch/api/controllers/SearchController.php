<?php

namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\forms\EventForm;
use api\models\ContentCategory;
use api\models\Content;
use api\models\ContentRating;
use api\models\ContentComment;
use api\models\User;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models\forms\UploadForm;

class SearchController extends BaseAuthController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['by-city', 'tour'],
                    'allow' => true
                ]
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'by-city' => ['GET'],
                'tour' => ['GET'],
            ],
        ];

        return $behaviors;
    }

    public function actionByCity($id, $page = 1, $perpage = 10){
        $activeData = new ActiveDataProvider([
            'query' => Content::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->joinWith('city', true)->where(['city.google_id' => $id, 'content.is_tour' => true]);
        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }

    public function actionTour($category_id = null, $city_id = null, $page = 1, $perpage = 10){
        $activeData = new ActiveDataProvider([
            'query' => Content::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->where(['content.is_tour' => true]);
        if($city_id) {
            $activeData->query->joinWith('city', true)->where(['city.google_id' => $city_id]);
        }
        if($category_id) {
            $activeData->query->joinWith('categories', true)->andFilterWhere(['content_category.category_id' => $category_id]);
        }
        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }
}
