<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\City;
use common\models\Address;

class GoogleCityForm extends Model
{
    public $model;
    public $city;
    public $name;
    public $id;
    public $lat;
    public $long;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'name', 'id', 'model'], 'string'],
            [['city', 'name', 'id'], 'required'],
            [['lat', 'long'], 'double']
        ];
    }

    public function getOrCreate(){
        if ($this->validate()) {
            $modelName = $this->model ?: 'common\models\City';
            $item = $modelName::find()->where(['google_id' => $this->id])->one();
            if(!$item) {
                $item = new $modelName([
                    'name' => $this->name,
                    'city' => $this->city,
                    'google_id' => $this->id,
                    'lat' => $this->lat,
                    'lng' => $this->long
                ]);
                if($item->validate()) {
                    $item->save();
                }
            }
            return $item;
        }
        return false;
    }
}
