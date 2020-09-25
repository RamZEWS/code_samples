<?php

namespace api\modules\oauth2\controllers;

use api\models\User;
use filsh\yii2\oauth2server\models\OauthAccessTokens;
use Yii;

class RestController extends \filsh\yii2\oauth2server\controllers\RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                // Allow only POST and PUT methods
                'Access-Control-Allow-Headers' => ['*'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 86400,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => [],
            ]
        ];
        return $behaviors;
    }
    
    public function actionToken()
    {
        $response = $this->module->getServer()->handleTokenRequest();
        $parameters = $response->getParameters();
        /*
         * Имитируем разлогин юзера на одном устройстве, если получен токен на другом.
         * При выдаче нового токена удаляем все предыдущие выданные
         */
        if (array_key_exists('access_token', $parameters)) {
            $token = $parameters['access_token'];
            $username = Yii::$app->request->post('username');
            if ($username && $token) {
                $user = User::findOne(['username' => $username]);
                OauthAccessTokens::deleteAll("user_id = $user->id and access_token <> '$token'");
            }
        }
        return $response->getParameters();
    }
}