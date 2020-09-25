<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;

class ChangeProfileAlertsForm extends Model
{
    public $get_messages;
    public $hide_events;

    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['get_messages', 'hide_events'], 'boolean']
        ];
    }

    public function changeAlerts(){
        if ($this->validate()) {
            $this->user = Yii::$app->user->identity;
            if($this->user) {
                $this->user->get_messages = intval($this->get_messages);
                $this->user->hide_events = intval($this->hide_events);

                if($this->user->validate() && $this->user->save()) {
                    return $this->user;
                }
            }
        }
        return $this;
    }
}
