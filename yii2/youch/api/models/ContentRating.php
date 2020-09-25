<?php

namespace api\models;

use common\models\ContentRating as CommonContentRating;

class ContentRating extends CommonContentRating {

    public function fields() {
        return [
            'id',
            'content',
            'user',
            'rating',
            'created_at',
            'updated_at'
        ];
    }

    public function __get($name) {
        if (in_array($name, ['created_at', 'updated_at'])){
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
}
