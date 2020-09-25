<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * reset password form
 */
class ResetPasswordForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    public function reset()
    {
        $user = User::findOne(["email" => $this->email, 'status' => User::STATUS_ACTIVE]);
        if ($user) {
            $key = $user->password_reset_token;
            /* Send link for confirm email */
            $link = Yii::$app->request->hostInfo . "/change-password?key=" . $key;
            Yii::$app->mailer->compose("user/reset", ['link' => $link, 'login' => $user->username])
                ->setFrom("support@".getenv('SITE_URL'))
                ->setTo($user->email)
                ->setSubject("Восстановление пароля.")
                ->send();
            return true;
        } else {
            $this->addError('email', 'User is not found or inactive');
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email'
        ];
    }
}