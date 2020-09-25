<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $week_day_id
 * @property integer $content_id
 * @property string $from
 * @property string $to
 * @property integer $created_at
 * @property integer $updated_at
 */
class WeekDayContent extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_week_day}}';
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
            [['week_day_id', 'content_id'], 'integer'],
            [['from', 'to'], 'string']
        ];
    }

    public function getDay(){
        return $this->hasOne(WeekDay::className(), ['id' => 'week_day_id']);
    }

    public function getContent() {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
}
