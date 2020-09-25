<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\forms\GoogleCityForm;

class ChangeProfileForm extends Model
{
    public $username;
    public $email;
    public $first_name;
    public $last_name;
    public $about;
    public $site;
    public $birthday;
    public $city;

    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'last_name', 'about', 'site'], 'string'],
            [['birthday'], 'safe'],
            [['city'], 'validateCity'],
            [
                'email', 
                'unique', 
                'targetAttribute' => 'email', 
                'targetClass' => '\common\models\User', 
                'filter' => function ($query) {
                    if(Yii::$app->user) {
                        $query->andFilterWhere(['not', ['id' => Yii::$app->user->id]]);
                    } else {
                        $this->addError('email', "You are not authorized");
                    }

                }
            ],
            [
                'username', 
                'unique', 
                'targetAttribute' => 'username', 
                'targetClass' => '\common\models\User', 
                'filter' => function ($query) {
                    if(Yii::$app->user) {
                        $query->andFilterWhere(['not', ['id' => Yii::$app->user->id]]);
                    } else {
                        $this->addError('username', "You are not authorized");
                    }

                }
            ]
        ];
    }

    public function changeProfile(){
        if ($this->validate()) {
            $this->user = Yii::$app->user->identity;
            if($this->user) {
                $this->user->email = $this->email;
                $this->user->username = $this->username;
                $this->user->first_name = $this->first_name;
                $this->user->last_name = $this->last_name;
                $this->user->site = $this->site;
                $this->user->about = $this->about;
                $this->user->city_id = $this->city ? $this->city->id : null;
                $this->user->birthday = $this->birthday;

                if($this->user->validate() && $this->user->save()) {
                    return $this->user;
                }
            }
        }
        return $this;
    }

    public function validateCity($attribute, $params){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new GoogleCityForm();
        $model->load($bodyParams['city'], '');
        $this->city = $model->getOrCreate();
        return $this;
    }
}
