<?php

namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\forms\TourForm;
use api\models\Content;
use api\models\ContentRating;
use api\models\ContentComment;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models\forms\UploadForm;

class TourController extends BaseAuthActiveController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index', 'view', 'get-comments', 'user'],
                    'allow' => true
                ],
                [
                    'actions' => ['save', 'add-comment', 'add-mark', 'image', 'delete-image'],
                    'allow' => true,
                    'roles' => ['@']
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'roles' => ['admin']
                ],
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['GET'],
                'user' => ['GET'],
                'get-comments' => ['GET'],
                'add-comment' => ['POST'],
                'image' => ['POST'],
                'delete-image' => ['POST'],
                'add-mark' => ['POST'],
                'delete' => ['DELETE'],
                'update' => ['PUT', 'PATCH']
            ],
        ];

        return $behaviors;
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public $modelClass = 'api\models\Content';

    public function actionSave(){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new TourForm();
        $model->load($bodyParams, '');
        if ($model->saveContent()) {
            return Content::findOne($model->content->id);
        } else {
            return $model;
        }
    }

    public function actionImage($id){
        $content = $this->findContent($id);
        if($content) {
            $image = null;
            $model = new UploadForm();
            $model->file = UploadedFile::getInstanceByName('file');
            if ($model->file && $model->validate()) {
                $image = $model->saveImage('/upload/content/');
            }
            if(!$image) {
                return $model;
            } else {
                if($content->file_url) {
                    $file = implode('', [$_SERVER['DOCUMENT_ROOT'], $content->file_base_url, $content->file_url]);
                    if(file_exists($file)) {
                        unlink($file);
                    }
                }
                $content->file_base_url = $image['base_url'];
                $content->file_url = $image['file_name'];
                $content->save();
                return $content;
            }
        }
    }

    public function actionDeleteImage($id){
        $content = $this->findContent($id);
        if($content) {
            if($content->file_url) {
                $file = implode('', [$_SERVER['DOCUMENT_ROOT'], $content->file_base_url, $content->file_url]);
                if(file_exists($file)) {
                    unlink($file);
                }
            }
            $content->file_base_url = null;
            $content->file_url = null;
            $content->save();
            return $content;
        }
    }

    public function actionAddComment(){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new ContentComment();
        $model->load($bodyParams, '');
        if ($model->validate() && $model->save()) {
            return $this->actionGetComments($model->content_id);
        } else {
            return $model;
        }
    }

    public function actionAddMark(){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new ContentRating();
        $model->load($bodyParams, '');
        $existed = ContentRating::find()->where(['user_id' => Yii::$app->user->id, 'content_id' => $model->content_id])->one();
        if(!$existed) {
            if ($model->validate() && $model->save()) {
                return Content::findOne($model->content_id);
            }
        } else {
            $model->addError('content_id', 'You have already added the mark');
        }
        return $model;
    }

    public function actionGetComments($id, $page = 1, $perpage = 10){
        $activeData = new ActiveDataProvider([
            'query' => ContentComment::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
            ],
        ]);
        $activeData->query->select(['id', 'comment', 'user_id', 'created_at', 'updated_at'])->where(['content_id' => $id])->orderBy(['created_at' => SORT_DESC]);
        return $activeData;
    }

    public function actionIndex($category_id = null, $page = 1, $perpage = 10){
        $activeData = new ActiveDataProvider([
            'query' => Content::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
            ],
        ]);
        $activeData->query->where(['status' => Content::STATUS_ACTIVE, 'is_tour' => 1])->orderBy(['created_at' => SORT_DESC]);
        if($category_id) {
            $activeData->query->joinWith('categories', true)->andFilterWhere(['content_category.category_id' => $category_id]);
        }
        return $activeData;
    }

    public function actionUser($id){
        return Content::find()
                ->joinWith('user', true)
                ->where(['user.username' => $id, 'content.status' => Content::STATUS_ACTIVE, 'content.is_tour' => 1])
                ->orderBy(['created_at' => SORT_DESC])
                ->all();
    }

    protected function findContent($id){
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }
        return false;
    }
}