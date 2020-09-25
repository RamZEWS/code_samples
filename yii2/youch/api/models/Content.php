<?php

namespace api\models;

use Yii;
use common\models\Content as CommonContent;
use api\components\DateFormatter;

class Content extends CommonContent {
    public static $statuses = [
        self::STATUS_DELETED => 'deleted',
        self::STATUS_ACTIVE => 'active',
        self::STATUS_INACTIVE => 'inactive'
    ];

    public function fields() {
        $fields = [
            'id',
            'title',
            'description',
            'user',
            'rating',
            'ratings',
            'my_rating',
            'category',
            'days',
            'date_from',
            'date_to',
            'is_free',
            'is_tour',
            'site',
            'phone',
            'city',
            'address',
            'state',
            'file',
            'counts',
            'created_at',
            'updated_at'
        ];

        if($this->is_tour) {
            $fields[] = 'price';
            $fields[] = 'currency';
            $fields[] = 'period';
            $fields[] = 'period_type';
            $fields[] = 'dates';
        } else {
            $fields[] = 'price_from';
            $fields[] = 'price_to';
            $fields[] = 'currency';
            $fields[] = 'time_from';
            $fields[] = 'time_to';
        }

        return $fields;
    }

    public function __get($name) {
        if(in_array($name, ['is_free', 'is_tour'])){
            return (bool)$this->getAttribute($name);
        } else if(in_array($name, ['date_from', 'date_to'])){
            if($this->is_tour) {
                $nearestDate = TourPeriod::find()
                    ->andFilterWhere(['=', 'tour_id', $this->id])
                    ->andFilterWhere(['>=', 'date_start', date('Y-m-d')])
                    ->one();
                if($nearestDate) {
                    if($name == 'date_from') {
                        return date('c', strtotime($nearestDate->date_start));
                    } else if ($name == 'date_to') {
                        $period_type = $this->period_type ?: 'day';
                        return date('c', strtotime('+ '.$this->period.' '.$period_type.'s', strtotime($nearestDate->date_start)));
                    }
                }
            }
            return DateFormatter::convert($this->getAttribute($name));
        } else if(in_array($name, ['time_from', 'time_to'])){
            return DateFormatter::convert($this->getAttribute($name), 'time');
        } else if(in_array($name, ['my_rating'])){
            $rating = null;
            if(Yii::$app->user->id){
                $model = ContentRating::find()->where(['user_id' => Yii::$app->user->id, 'content_id' => $this->id])->one();
                if($model) $rating = $model->rating;
            }
            return $rating;
        } else if (in_array($name, ['created_at', 'updated_at'])){
            return date('c', $this->getAttribute($name));
        }
        return parent::__get($name);
    }

    public function getState(){
        return isset(self::$statuses[$this->status]) ? self::$statuses[$this->status] : "unknown";
    }

    public function getPrice(){
        return $this->price_from;
    }    

    public function getCity(){
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    } 

    public function getAddress(){
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])
            ->viaTable(ContentCategory::tableName(), ['content_id' => 'id']);
    }
    
    public function getFile(){
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    public function getDays() {
        $days = [];
        $contentDays = WeekDayContent::find()->where(['content_id' => $this->id])->all();
        foreach($contentDays as $d) {
            $days[$d->day->code] = [
                'name' => $d->day->name_en, 
                'from' => date('c', strtotime($d->from)), 
                'to' => date('c', strtotime($d->to))
            ];
        }
        return $days;
    }

    public function getDates() {
        $dates = [];
        $contentDays = TourPeriod::find()->where(['tour_id' => $this->id])->all();
        foreach($contentDays as $d) {
            $start = date('c', strtotime($d->date_start));
            //$end = date('c', strtotime('+ '.$this->period.' days', strtotime($start)));
            $dates[] = $start;//['from' => $start, 'to' => $end];   
        }
        return $dates;
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCounts(){
        return [
            'ratings' => ContentRating::find()->where(['content_id' => $this->id])->count(),
            'comments' => ContentComment::find()->where(['content_id' => $this->id])->count(),
        ];
    }

    public function getRatings() {
        $models = ContentRating::find()->where(['content_id' => $this->id])->orderBy(['rating' => SORT_DESC])->all();
        if($models) {
            $arr = [];
            $total = 0;
            foreach($models as $m){
                if(!isset($arr[$m->rating])) $arr[$m->rating] = 0;
                $arr[$m->rating] = $arr[$m->rating] + 1;
                $total++;
            }

            $result = [];
            foreach($arr as $rating => $count) {
                $percent = ($count * 100) / $total;
                $result[$rating] = ['count' => $count, 'percent' => $percent];
            }
            return $result;
        }
        return null;
    }
}
