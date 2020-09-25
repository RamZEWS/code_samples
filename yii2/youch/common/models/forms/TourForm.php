<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\Category;
use common\models\Content;
use common\models\ContentCategory;
use common\models\TourPeriod;
use common\models\WeekDay;
use common\models\WeekDayContent;

class TourForm extends Model
{
    public $id;
    public $title;
    public $description;
    public $price;
    public $is_free;
    public $is_tour;
    public $period;
    public $period_type;
    public $site;
    public $phone;
    public $currency;
    public $file_id;
    public $address;
    public $category;

    public $content;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'currency', 'description', 'site', 'phone', 'period_type'], 'string'],
            [['id', 'period'], 'integer'],
            [['is_free', 'is_tour'], 'boolean'],
            [['price'], 'double'],
            [['address'], 'validateAddress'],
            [['category'], 'validateCategory'],
            [['file_id'], 'validateFile'],
            ['period_type', 'in', 'range' => ['day', 'hour']],
        ];
    }

    public function saveContent(){
        if ($this->validate()) {
            $this->content = $this->findContent();
            if($this->content) {
                $this->content->title = $this->title;
                $this->content->description = $this->description;
                $this->content->price_from = $this->price;
                $this->content->is_free = $this->is_free;
                $this->content->is_tour = true;
                $this->content->period = $this->period;
                $this->content->period_type = $this->period_type;
                $this->content->site = $this->site;
                $this->content->file_id = $this->file_id ?: null;
                $this->content->phone = $this->phone;
                $this->content->currency = $this->currency;
                $this->content->city_id = Yii::$app->user->identity->city_id;
                if($this->address) {
                    $this->content->address_id = $this->address->id;
                }

                if($this->content->validate() && $this->content->save()) {
                    $this->savePeriods();
                    $this->saveCategories();
                    $this->saveHours();
                }
            }
        }
        return $this;
    }

    public function findContent(){
        if (($model = Content::findOne($this->id)) !== null) {
            return $model;
        } else {
            return new Content();
        }
    }

    public function validateAddress($attribute, $params){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        $model = new GoogleCityForm();
        $model->load($bodyParams['address'], '');
        $model->model = 'common\models\Address'; 
        $this->address = $model->getOrCreate();
        return $this;
    }

    public function validateCategory($attribute, $params){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        if(isset($bodyParams['category']['id'])) {
            $this->category = Category::findOne($bodyParams['category']['id']);    
        }
        return $this;
    }

    public function validateFile($attribute, $params){
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        if(isset($bodyParams['file']['id'])) {
            $this->file_id = intval($bodyParams['file']['id']);
        }
        return $this;
    }

    public function saveCategories(){
        ContentCategory::deleteAll(['content_id' => $this->content->id]);
        if($this->category){
            $new = new ContentCategory(['category_id' => $this->category->id, 'content_id' => $this->content->id]);
            $new->save();
        }
    }

    public function savePeriods(){
        TourPeriod::deleteAll(['tour_id' => $this->content->id]);
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
	    if(isset($bodyParams['dates'])){
            $dates = $bodyParams['dates'];
            foreach($dates as $date) {
                if($date){
                    $new = new TourPeriod();
                    $new->date_start = date('Y-m-d H:i:s', strtotime($date));
                    $new->tour_id = $this->content->id;
                    $new->save();
                }
            }
	    }
    }

    public function saveHours(){
        WeekDayContent::deleteAll(['content_id' => $this->content->id]);
        $bodyParams = Yii::$app->getRequest()->getBodyParams();
        if(isset($bodyParams['days'])){
            $hours = $bodyParams['days'];
            foreach($hours as $code => $hour) {
                $weekday = WeekDay::find()->where(['code' => $code])->one();
                if($weekday) {
                    if($hour['from']){
                        $new = new WeekDayContent();
                        $new->from = date('H:i', strtotime($hour['from']));
                        $new->to = date('H:i', strtotime($hour['to']));
                        $new->week_day_id = $weekday->id;
                        $new->content_id = $this->content->id;
                        $new->save();
                    }
                }
            }
	    }
    }
}
