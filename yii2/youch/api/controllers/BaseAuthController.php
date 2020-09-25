<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use api\filters\auth\HttpBearerAuth;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;

class BaseAuthController extends \yii\rest\Controller
{
    public function verbs()
    {
        return ArrayHelper::merge(parent::verbs(), [
            'index' => ['GET'],
            'create' => ['POST'],
            'delete' => ['DELETE'],
            'update' => ['PUT', 'PATCH']
        ]);
    }

    /**
     * @inheritdoc
     */
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
        return ArrayHelper::merge($behaviors, [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
                //'except' => ['OPTIONS']
            ],
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className()
            ],
        ]);
    }

    public function getPagination($total, $page, $perpage){
        $is_first = ($page == 1);

        $pages = ceil($total / $perpage);
        $is_last = ($page == $pages);
        return [
            'total' => $total,
            'current_page' => $page,
            'perpage' => $perpage,
            'is_first' => $is_first,
            'is_last' => $is_last
        ];
    }
}