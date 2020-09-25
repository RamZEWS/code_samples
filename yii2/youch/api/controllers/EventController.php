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
use api\models\File;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models\forms\UploadForm;

class EventController extends BaseAuthActiveController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index', 'view', 'get-comments', 'user', 'recommended'],
                    'allow' => true
                ],
                [
                    'actions' => ['save', 'add-comment', 'add-mark', 'delete-image'],
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
                'user' => ['GET'],
                'get-comments' => ['GET'],
                'save' => ['POST'],
                'delete-image' => ['POST'],
                'add-comment' => ['POST'],
                'add-mark' => ['POST'],
                'recommended' => ['GET']
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
        $model = new EventForm();
        $model->load($bodyParams, '');
	    if ($id = $model->saveEvent()) {
            return Content::findOne($id);
        } else {
            return $model;
        }
    }

    public function actionUser($id, $page = 1, $perpage = 10){
        $user = User::find()->where(['username' => $id])->one();
        $where = ['user.username' => $id, 'content.status' => Content::STATUS_ACTIVE, 'content.is_tour' => 0];
        if($user) {
            $auth = Yii::$app->getAuthManager();
            if($auth->checkAccess($user->id, 'moderator')) {
                $where['content.is_tour'] = 1;
            }
        }
        
        $activeData = new ActiveDataProvider([
            'query' => Content::find()->joinWith('user', true),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->where($where)->orderBy(['created_at' => SORT_DESC]);

        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }

    public function actionDeleteImage($id){
        $content = $this->findContent($id);
        if($content) {
            if($content->file_id) {
                $file = File::findOne($content->file_id);
                if($file) {
                    $path = implode('', [$_SERVER['DOCUMENT_ROOT'], $file->file_base_url, $file->file_url]);
                    if(file_exists($path)) {
                        unlink($path);
                    }
                    $file->delete();
                }
            }
            $content->file_id = null;
            $content->save();
            return $content;
        }
    }

    public function actionAddComment(){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new ContentComment();
        $model->load($bodyParams, '');
        if ($model->validate() && $model->save()) {
            $files = isset($bodyParams['files']) ? $bodyParams['files'] : false;
            if($files) {
                foreach($files as $f) {
                    if($f['id']) {
                        $model = new CommentFiles(['comment_id' => $comment->id, 'file_id' => $f['id']]);
                        $model->save();
                    }
                }
            }
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

    public function actionIndex($category_id = null, $page = 1, $perpage = 10){
        $activeData = new ActiveDataProvider([
            'query' => Content::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->where(['status' => Content::STATUS_ACTIVE, 'is_tour' => 1])->orderBy(['created_at' => SORT_DESC]);
        if($category_id) {
            $activeData->query->joinWith('categories', true)->andFilterWhere(['content_category.category_id' => $category_id]);
        }

        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }

    public function actionRecommended($page = 1, $perpage = 10){
        $activeData = new ActiveDataProvider([
            'query' => Content::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->where(['status' => Content::STATUS_ACTIVE, 'is_tour' => 1])->orderBy(['rating' => SORT_DESC]);

        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }

    protected function findContent($id){
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }
        return false;
    }
}
