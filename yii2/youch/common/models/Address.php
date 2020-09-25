<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Address model
 *
 * @property integer $id
 * @property string $name
 * @property string $city
 * @property string $google_id
 * @property double $lat
 * @property double $lng
 * @property integer $created_at
 * @property integer $updated_at
 */
class Address extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
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
            [['name', 'city', 'google_id'], 'string'],
            [['lat', 'lng'], 'double']
        ];
    }
}
