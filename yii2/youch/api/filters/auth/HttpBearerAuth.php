<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\filters\auth;

use yii\filters\auth\AuthMethod;
use Yii;

/**
 * HttpBearerAuth is an action filter that supports the authentication method based on HTTP Bearer token.
 *
 * You may use HttpBearerAuth by attaching it as a behavior to a controller or module, like the following:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'bearerAuth' => [
 *             'class' => \yii\filters\auth\HttpBearerAuth::className(),
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HttpBearerAuth extends AuthMethod
{
    /**
     * @var string the HTTP authentication realm
     */
    public $realm = 'api';


    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match("/^Bearer\\s+(.*?)$/", $authHeader, $matches)) {
            return $user->loginByAccessToken($matches[1], get_class($user));
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $response = $this->response ?: Yii::$app->getResponse();

        $identity = $this->authenticate(
            $this->user ?: Yii::$app->getUser(),
            $this->request ?: Yii::$app->getRequest(),
            $response
        );

        return true;
    }
}
