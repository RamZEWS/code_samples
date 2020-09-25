<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\Content;

class EventForm extends Model
{
    public $id;
    public $is_tour;

    public $content;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['is_tour'], 'boolean']
        ];
    }

    public function saveEvent(){
        if ($this->validate()) {
            $bodyParams = Yii::$app->getRequest()->getBodyParams();
            if($this->is_tour) {
                $model = new TourForm();
            } else {
                if(Yii::$app->user->can('moderator')) {
                    $model = new TourForm();
                } else {
                    $model = new ContentForm();
                }
            }
            $model->load($bodyParams, '');
            if ($model->saveContent()) {
                return $model->content->id;
            } else {
                return $model;
            }
        }
        return $this;
    }
}
