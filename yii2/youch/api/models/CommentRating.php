<?php

namespace api\models;

use common\models\CommentRating as CommonCommentRating;

class CommentRating extends CommonCommentRating {

    public function fields() {
        return [
            'id',
            'comment',
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

    public function getComment() {
        return $this->hasOne(ContentComment::className(), ['id' => 'comment_id']);
    }
}
