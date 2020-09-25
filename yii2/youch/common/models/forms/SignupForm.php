<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class SignupForm extends Model
{
    const ROLE_TOURIST = 'tourist';
    const ROLE_COMPANY = 'company';

    const STEP_1 = 'step1';
    const STEP_2 = 'step4';
    const STEP_3 = 'step3';
    const STEP_4 = 'step2';

    public $username;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;
    public $role;
    public $city_id;
    public $about;

    private $user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Step 1
            [['email', 'first_name', 'last_name', 'confirm_password', 'password', 'role'], 'required', 'on' => self::STEP_1],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Passwords don't match"],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\common\models\User'],
            [['first_name', 'last_name'], 'string'],
            ['role', 'in', 'range' => [self::ROLE_TOURIST, self::ROLE_COMPANY]],

            // Step 2
            ['username', 'required', 'on' => self::STEP_2],
            ['username', 'unique', 'targetAttribute' => 'username', 'targetClass' => '\common\models\User'],
            ['username', 'string'],

            // Step 3
            ['city_id', 'required', 'on' => self::STEP_3],
            ['city_id', 'integer'],

            // Step 4
            ['about', 'required', 'on' => self::STEP_4],
            ['about', 'string']
        ];
    }

    public function step1(){
        if ($this->validate()) {
            $this->user = new User([
                'username' => $this->email,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'status' => User::STATUS_ACTIVE
            ]);
            $this->user->setPassword($this->password);
            $this->user->generateAuthKey();
            $this->user->generatePasswordResetToken();
            if ($this->user->save()) {
                $auth = Yii::$app->authManager;
                if($this->role == self::ROLE_COMPANY) {
                    $role = $auth->getRole('moderator');
                } else {
                    $role = $auth->getRole('user');
                }
                $auth->assign($role, $this->user->id);

                return $this->getAccessToken($this->user->id);
            }
        }
        return $this;
    }

    public function step2(){
        if ($this->validate()) {
            $this->user = Yii::$app->user->identity;
            $this->user->username = $this->username;
            $this->user->save();
            return $this->user;
        }
        return $this;
    }

    public function step3(){
        if ($this->validate()) {
            $this->user = Yii::$app->user->identity;
            $this->user->city_id = $this->city_id;
            $this->user->save();
            return $this->user;
        }
        return $this;
    }

    public function step4(){
        if ($this->validate()) {
            $this->user = Yii::$app->user->identity;
            $this->user->about = $this->about;
            $this->user->save();
            return $this->user;
        }
        return $this;
    }

    protected function getAccessToken($user_id) {
        $module = Yii::$app->modules["oauth2"];
        $server = $module->getServer();
        return $server->createAccessToken("testclient", $user_id);
    }
}
