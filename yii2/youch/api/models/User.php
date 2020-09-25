<?php
namespace api\models;

use common\models\User as CommonUser;
/**
 * User model
 */
class User extends CommonUser {
    public static $statuses = [
        self::STATUS_DELETED => 'deleted',
        self::STATUS_ACTIVE => 'active',
        self::STATUS_BANNED => 'inactive'
    ];

    public function fields() {
        return [
            'id',
            'username',
            'email',
            'first_name',
            'last_name',
            'state',
            'site',
            'avatar',
            'get_messages',
            'hide_events',
            'birthday',
            'about',
            'city',
            'counts'
        ];
    }

    public function __get($name) {
        if(in_array($name, ['get_messages', 'hide_events'])){
            return (bool)$this->getAttribute($name);
        } else if (in_array($name, ['created_at', 'updated_at'])){
            return date('c', $this->getAttribute($name));
        }
        return parent::__get($name);
    }

    public function getState(){
        return isset(self::$statuses[$this->status]) ? self::$statuses[$this->status] : "unknown";
    }

    public function getAvatar(){
        if($this->avatar_id) {
            $file = File::findOne($this->avatar_id);
            if($file) {
                return $file->path;
            }
        }
        return null;
    }

    public function getCity(){
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getCounts(){
        return [
            'content' => Content::find()->where(['user_id' => $this->id])->count(),
            'followers' => UserSubscription::find()->where(['follower_id' => $this->id])->count(),
            'followings' => UserSubscription::find()->where(['user_id' => $this->id])->count(),
            'comments' => ContentComment::find()->where(['user_id' => $this->id])->count(),
        ];
    }
}
