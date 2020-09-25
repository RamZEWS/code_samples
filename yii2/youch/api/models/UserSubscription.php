<?php

namespace api\models;

use common\models\UserSubscription as CommonUserSubscription;

class UserSubscription extends CommonUserSubscription {

    public function fields() {
        return [
            'id',
            'user',
            'follower',
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

    public function getFollower(){
        return $this->hasOne(User::className(), ['id' => 'follower_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
