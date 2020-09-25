<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use api\models\User;
use api\models\Content;
use api\models\BlackList;
use api\models\UserSubscription;
use api\models\ContentComment;
use api\models\CommentRating;
use api\models\CommentFiles;
use common\models\forms\ChangePasswordForm;
use common\models\forms\ChangeProfileForm;
use common\models\forms\ChangeProfileAlertsForm;
use common\models\forms\ImageBase64Form;
use common\models\forms\UploadForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class CommentController extends BaseAuthController {

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['user', 'to-user', 'index'],
                    'allow' => true,
                ],
                [
                    'actions' => ['add-mark', 'image'],
                    'allow' => true,
                    'roles' => ['@']
                ],
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['GET'],
                'user' => ['GET'],
                'to-user' => ['GET'],
                'add-mark' => ['POST'],
                'image' => ['POST']
            ],
        ];

        return $behaviors;
    }

    public function actionUser($id) {
        $activeData = new ActiveDataProvider([
            'query' => ContentComment::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->joinWith(['user'], true)
                          ->where(['user.username' => $id])
                          ->orderBy(['created_at' => SORT_DESC]);

        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }

    public function actionToUser($id) {
        $activeData = new ActiveDataProvider([
            'query' => ContentComment::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->joinWith(['content', 'content.user'], true)
                          ->where(['user.username' => $id])
                          ->orderBy(['created_at' => SORT_DESC]);

        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }

    public function actionIndex($event_id, $page = 1, $perpage = 10) {
        $activeData = new ActiveDataProvider([
            'query' => ContentComment::find(),
            'pagination' => [
                'defaultPageSize' => $perpage,
                'validatePage' => false
            ],
        ]);
        $activeData->query->where(['content_id' => $event_id, 'comment_id' => null])->orderBy(['created_at' => SORT_DESC]);

        $pagination = $this->getPagination($activeData->getTotalCount(), $page, $perpage);
        return ['pagination' => $pagination, 'models' => $activeData->getModels()];
    }

    public function actionAddMark(){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new CommentRating();
        $model->load($bodyParams, '');
        $existed = CommentRating::find()->where(['user_id' => Yii::$app->user->id, 'comment_id' => $model->comment_id])->one();
        if(!$existed) {
            if ($model->validate() && $model->save()) {
                return ContentComment::findOne($model->comment_id);
            }
        } else {
            $model->addError('comment_id', 'You have already added the mark');
        }
        return $model;
    }
}