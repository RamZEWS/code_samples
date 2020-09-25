<?php

namespace api\models;

use Yii;
use common\models\ContentComment as CommonContentComment;

class ContentComment extends CommonContentComment {

    public function fields() {
        return [
            'id',
            'content',
            'user',
            'comment',
            'files',
            'rating',
            'ratings',
            'my_rating',
            'answers',
            'created_at',
            'updated_at'
        ];
    }

    public function __get($name) {
        if(in_array($name, ['my_rating'])){
            $rating = null;
            if(Yii::$app->user->id){
                $model = ContentRating::find()->where(['user_id' => $this->user_id, 'content_id' => $this->content_id])->one();
                if($model) $rating = $model->rating;
            }
            return $rating;
        } else if (in_array($name, ['created_at', 'updated_at'])){
            return date('c', $this->getAttribute($name));
        }
        return parent::__get($name);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getContent() {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    public function getAnswers() {
        return $this->hasMany(self::className(), ['comment_id' => 'id']);
    }

    public function getRatings() {
        $models = CommentRating::find()->where(['comment_id' => $this->id])->orderBy(['rating' => SORT_DESC])->all();
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

    public function getFiles(){
        return $this->hasMany(File::className(), ['id' => 'file_id'])
            ->viaTable(CommentFiles::tableName(), ['comment_id' => 'id']);
    }
}
