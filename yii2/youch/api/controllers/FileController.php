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
use api\models\File;
use common\models\forms\ChangePasswordForm;
use common\models\forms\ChangeProfileForm;
use common\models\forms\ChangeProfileAlertsForm;
use common\models\forms\ImageBase64Form;
use common\models\forms\UploadForm;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class FileController extends BaseAuthController {

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['upload'],
                    'allow' => true,
                ],
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'upload' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    public function actionUpload() {
        $images = null;
        $model = new UploadForm();
        $model->files = UploadedFile::getInstancesByName('file');
        if ($model->files && $model->validate()) {
            $images = $model->saveImage('/upload/files/', true);
        }
        if(!$images) {
            return $model;
        } else {
            $result = [];
            foreach($images as $img) {
                $model = new File();
                $model->file_base_url = $img['base_url'];
                $model->file_url = $img['file_name'];
                $model->save();
                $result[] = $model;
            }
            return $result;
        }
    }
}