<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $old_password;
    public $password;
    public $confirm_password;

    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_password', 'password', 'confirm_password'], 'string'],
            [['old_password', 'password', 'confirm_password'], 'required'],

            ['old_password', 'validateOldPassword'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Passwords don't match"]
        ];
    }

    public function changePassword(){
        if ($this->validate()) {
            $this->user = Yii::$app->user->identity;
            $this->user->setPassword($this->password);
            if($this->user->save()) return $this->user;
        }
        return $this;
    }

    public function validateOldPassword($attribute, $params){
        $this->user = Yii::$app->user->identity;
        if($this->user) {
            if(!$this->user->validatePassword($this->old_password)) {
                $this->addError($attribute, "Old password is incorrect");        
            }
        } else {
            $this->addError($attribute, "You are not authorized");
        }
        return $this;
    }
}
