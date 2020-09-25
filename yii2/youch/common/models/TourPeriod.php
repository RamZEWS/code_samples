<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $tour_id
 * @property datetime $date_start
 * @property integer $created_at
 * @property integer $updated_at
 */
class TourPeriod extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tour_period}}';
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
            [['tour_id'], 'integer'],
            [['date_start'], 'safe']
        ];
    }

    public function getTour() {
        return $this->hasOne(Content::className(), ['id' => 'tour_id']);
    }
}
