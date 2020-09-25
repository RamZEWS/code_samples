<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $content_id
 * @property text $comment
 * @property integer $comment_id
 * @property double $rating
 * @property integer $created_at
 * @property integer $updated_at
 */
class ContentComment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content_id', 'comment_id'], 'integer'],
            [['comment'], 'string'],
            [['rating'], 'double'],
            [['user_id'], 'default', 'value' => Yii::$app->user->id]
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getContent() {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    public function getComment() {
        return $this->hasOne(self::className(), ['id' => 'comment_id']);
    }
}
