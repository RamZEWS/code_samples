<?php

namespace api\models;

use common\models\ContentCategory as CommonContentCategory;

class ContentCategory extends CommonContentCategory {

    public function fields() {
        return [
            'id',
            'category_id',
            'content_id',
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

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getContent() {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
}
