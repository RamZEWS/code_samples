<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $comment_id
 * @property double $rating
 * @property integer $created_at
 * @property integer $updated_at
 */
class CommentRating extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_rating}}';
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
            [['user_id', 'comment_id'], 'integer'],
            [['rating'], 'double', 'min' => 0, 'max' => 5],
            [['user_id'], 'default', 'value' => Yii::$app->user->id]
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        $avg = self::find()->where(['comment_id' => $this->comment_id])->average('rating');
        $content = ContentComment::findOne($this->comment_id);
        $content->rating = $avg;
        $content->save();
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getComment() {
        return $this->hasOne(ContentComment::className(), ['id' => 'comment_id']);
    }
}
