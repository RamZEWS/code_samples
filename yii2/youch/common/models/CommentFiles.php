<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $comment_id
 * @property integer $file_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class CommentFiles extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_files}}';
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
            [['comment_id', 'file_id'], 'integer']
        ];
    }

    public function getComment() {
        return $this->hasOne(ContentComment::className(), ['id' => 'comment_id']);
    }

    public function getFile() {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
}
