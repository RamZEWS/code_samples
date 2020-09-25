<?php

namespace api\models;

use common\models\Category as CommonCategory;
use api\components\LocalizationHelper;

class Category extends CommonCategory {

    public function fields() {
        return [
            'id',
            'name_ru_RU',
            'name_en_US',
            'created_at',
            'updated_at'
        ];
    }

    public function __get($name) {
        if(in_array($name, ['name_ru_RU', 'name_en_US'])){
            $name = LocalizationHelper::getLocaleName($name);
            return $this->getAttribute($name);
        } else if (in_array($name, ['created_at', 'updated_at'])){
            return date('c', $this->getAttribute($name));
        }
        return parent::__get($name);
    }
}
