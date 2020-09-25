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
use api\models\BlackList;
use api\models\UserSubscription;


class SubscriptionController extends BaseAuthController {
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['black-list', 'followers', 'followings'],
                    'allow' => true
                ],
                [
                    'actions' => ['block', 'remove-block', 'follow', 'remove-follow'],
                    'allow' => true,
                    'roles' => ['@']
                ]
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'black-list' => ['get'],
                'followers' => ['get'],
                'followings' => ['get'],
                'block' => ['post'],
                'remove-block' => ['post'],
                'follow' => ['post'],
                'remove-follow' => ['post'],
            ],
        ];

        return $behaviors;
    }

    public function actionBlock() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        if(isset($bodyParams['user_id'])) {
            $model = new BlackList();
            if($bodyParams['user_id'] != Yii::$app->user->id) {
                $existed = $this->findBlock($bodyParams['user_id']);
                if(!$existed) {
                    $model->block_id = $bodyParams['user_id'];
                    if($model->validate()) {
                        $model->save();
                    }
                }
            } else {
                $model->addError('user_id', 'You cannot block youself.');
                return $model;
            }
        }
        return BlackList::find()->where(['user_id' => Yii::$app->user->id])->select(['id', 'block_id', 'created_at', 'updated_at'])->all(); 
    }
    public function actionRemoveBlock() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        if(isset($bodyParams['user_id'])) {
            $existed = $this->findBlock($bodyParams['user_id']);
            if($existed) {
                $existed->delete();
            }
        }
        return BlackList::find()->where(['user_id' => Yii::$app->user->id])->select(['id', 'block_id', 'created_at', 'updated_at'])->all();
    }
    private function findBlock($user_id){
        return BlackList::find()->where(['user_id' => Yii::$app->user->id, 'block_id' => $user_id])->one();
    }

    public function actionBlackList($id) {
        return BlackList::find()
                ->joinWith('user', true)
                ->where(['user.username' => $id])
                ->orderBy(['created_at' => SORT_DESC])
                ->select(['black_list.id', 'black_list.block_id', 'black_list.created_at', 'black_list.updated_at'])
                ->all();
    }

    public function actionFollow() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        if(isset($bodyParams['user_id'])) {
            $model = new UserSubscription();
            if($bodyParams['user_id'] != Yii::$app->user->id) {
                $existed = $this->findFollow($bodyParams['user_id']);
                if(!$existed) {
                    $model->follower_id = $bodyParams['user_id'];
                    if($model->validate()) {
                        $model->save();
                    }
                }
            } else {
                $model->addError('user_id', 'You cannot follow youself.');
                return $model;
            }
        }
        return UserSubscription::find()->where(['user_id' => Yii::$app->user->id])->select(['id', 'follower_id', 'created_at', 'updated_at'])->all();
    }
    public function actionRemoveFollow() {
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        if(isset($bodyParams['user_id'])) {
            $existed = $this->findFollow($bodyParams['user_id']);
            if($existed) {
                $existed->delete();
            }
        }
        return UserSubscription::find()->where(['user_id' => Yii::$app->user->id])->select(['id', 'follower_id', 'created_at', 'updated_at'])->all();
    }
    private function findFollow($user_id){
        return UserSubscription::find()->where(['user_id' => Yii::$app->user->id, 'follower_id' => $user_id])->one();
    }

    public function actionFollowers($id) {
        return UserSubscription::find()
                ->joinWith('follower', true)
                ->where(['user.username' => $id])
                ->orderBy(['created_at' => SORT_DESC])
                ->select(['user_subscription.id', 'user_subscription.user_id', 'user_subscription.created_at', 'user_subscription.updated_at'])
                ->all();
    }
    public function actionFollowings($id) {
        return UserSubscription::find()
                ->joinWith('user', true)
                ->where(['user.username' => $id])
                ->orderBy(['created_at' => SORT_DESC])
                ->select(['user_subscription.id', 'user_subscription.follower_id', 'user_subscription.created_at', 'user_subscription.updated_at'])
                ->all();
    }
}